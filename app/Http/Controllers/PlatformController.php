<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Currency;
use App\Models\Setting;
use App\Models\Taxonomies_sessions; // Make sure class name matches file
use App\Models\Teacher;
use App\Models\Payment;
use App\Models\TeacherCourse;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionPayout;

class PlatformController extends Controller
{
    public function create()
    {
        // Fetch related data
        $subject_datas = Course::all();
        $teacher_datas = Teacher::all();
        $session_datas = Taxonomies_sessions::all();
        $currency_datas = Currency::all();


        // Get default currency from settings
        $default_currency_id = Setting::find(6)?->value;
        $selected_currency = Currency::find($default_currency_id);
        $selected_currency_id = $selected_currency?->id;

        // Get the first session
        $first_session = Taxonomies_sessions::first();
        $session_id = $first_session?->id;

        // Fetch platform transactions with eager loading
        $platform_transaction_datas = Transaction::with([
            'teacher',
            'course',
            'session',
            'currency',
            'payments',
            'expressPayments'
        ])
            ->where('selected_currency', $selected_currency_id)
            ->when($session_id, fn($q) => $q->where('session_id', $session_id))
            ->latest()
            ->get();

        // Total revenue
        $total_revenue = $platform_transaction_datas->sum('total');

        // Withdrawn balance for the platform
        $withdrawn_balance = TransactionPayout::where('type', 'platform')
            ->where('selected_currency', $selected_currency_id)
            ->when($session_id, fn($q) => $q->where('session_id', $session_id))
            ->sum('paid_amount');

        // Platform balance calculation
        $platform_balance = 0;
        foreach ($platform_transaction_datas as $transaction) {
            $teacherCourse = TeacherCourse::where('teacher_id', $transaction->teacher_id)
                ->where('course_id', $transaction->course_id)
                ->first();

            $teacher_percentage = $teacherCourse?->teacher_percentage ?? 0;
            $teacher_share = $transaction->course_fee * ($teacher_percentage / 100);
            $platform_balance += ($transaction->course_fee - $teacher_share);
        }

        return view('platform.index', get_defined_vars());
    }















    public function platform_transaction_store(Request $request)
    {
        $selected_currency_id = Setting::find(6)->value;

        try {
            // Validate request
            $validated = $request->validate([
                'teacher_id'          => 'required|exists:acc_teachers,id',
                'course'              => 'required|exists:acc_courses,id',
                'session_id'          => 'required|exists:acc_taxonomies_sessions,id',
                'student_name'        => 'required|string|max:255',
                'student_contact'     => 'nullable|string|max:255',
                'student_email'       => 'nullable|email|max:255',
                'parent_name'         => 'nullable|string|max:255',
                'course_fee'          => 'required|numeric|min:0',
                'note_fee'            => 'required|numeric|min:0',
                'paid_amount'         => 'required|numeric|min:0',
                'selected_currency_id' => 'required|exists:acc_currencies,id',
            ]);

            // Fees
            $courseFee = $validated['course_fee'];
            $noteFee   = $validated['note_fee'];
            $total     = $courseFee + $noteFee;

            // Get teacher percentage from pivot
            $teacherPercentage = Course::find($validated['course'])
                ->teacherCourses()
                ->where('teacher_id', $validated['teacher_id'])
                ->first()?->teacher_percentage ?? 0;

            // Calculate teacher amount (course % + note fee)
            $teacherShareFromCourse = $courseFee * ($teacherPercentage / 100);
            $teacherAmount = $teacherShareFromCourse + $noteFee;

            // Platform amount (only from course fee)
            $platformAmount = $courseFee - $teacherShareFromCourse;

            // Create transaction
            $transaction = Transaction::create([
                'teacher_id'        => $validated['teacher_id'],
                'course_id'         => $validated['course'],
                'session_id'        => $validated['session_id'],
                'student_name'      => $validated['student_name'],
                'student_contact'   => $validated['student_contact'] ?? null,
                'student_email'     => $validated['student_email'] ?? null,
                'parent_name'       => $validated['parent_name'] ?? null,
                'course_fee'        => $courseFee,
                'note_fee'          => $noteFee,
                'total'             => $total,
                'paid_amount'       => $validated['paid_amount'],
                'selected_currency' => $selected_currency_id,
                'teacher_amount'    => $teacherAmount,
                'platform_amount'   => $platformAmount,
            ]);

            // Create payment record
            $transaction->payments()->create([
                'paid_amount' => $validated['paid_amount'],
            ]);

            // Load relationships
            $transaction->load('teacher', 'course', 'session', 'currency');

            // Total revenue and platform balance
            $total_revenue = Transaction::where('selected_currency', $selected_currency_id)->sum('total');
            $platform_balance = Transaction::where('selected_currency', $selected_currency_id)->sum('platform_amount');

            return response()->json([
                'status' => 'success',
                'message' => 'Transaction & payment saved successfully',
                'transaction' => [
                    'id'               => $transaction->id,
                    'teacher'          => $transaction->teacher->teacher_name ?? '',
                    'course'           => $transaction->course->course_title ?? '',
                    'session'          => $transaction->session->session_title ?? '',
                    'student_name'     => $transaction->student_name,
                    'student_contact'  => $transaction->student_contact,
                    'student_email'    => $transaction->student_email,
                    'parent_name'      => $transaction->parent_name,
                    'course_fee'       => $transaction->course_fee,
                    'note_fee'         => $transaction->note_fee,
                    'total'            => $transaction->total,
                    'paid_amount'      => $transaction->paid_amount,
                    'remaining'        => $transaction->total - $transaction->paid_amount,
                    'teacher_amount'   => $transaction->teacher_amount,
                    'platform_amount'  => $transaction->platform_amount,
                    'created_at'       => $transaction->created_at->format('Y-m-d H:i:s'),
                ],
                'total_revenue'     => $total_revenue,
                'platform_balance'  => $platform_balance,
                'currency'          => $transaction->currency->currency_name ?? '',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
                'message' => 'Validation failed'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server error: ' . $e->getMessage(),
                'error_details' => [
                    'file' => basename($e->getFile()),
                    'line' => $e->getLine()
                ]
            ], 500);
        }
    }





    // public function platform_transaction_index(Request $request)
    // {
    //     // Selected currency ID from settings
    //     $selected_currency_id = Setting::find(6)->value;

    //     // Session filter
    //     $session_id = $request->session_id;

    //     // =====================================================
    //     // ✔ Fetch transactions WITH payments
    //     // =====================================================
    //     $platform_transaction_datas = Transaction::with([
    //         'teacher',
    //         'course',
    //         'session',
    //         'currency',
    //         'payments'  // <-- REQUIRED TO CALCULATE PLATFORM PAID
    //     ])
    //         ->where('selected_currency', $selected_currency_id)
    //         ->when($session_id, fn($q) => $q->where('session_id', $session_id))
    //         ->when($request->start_date, fn($q) => $q->whereDate('created_at', '>=', $request->start_date))
    //         ->when($request->end_date, fn($q) => $q->whereDate('created_at', '<=', $request->end_date))
    //         ->latest()
    //         ->get();

    //     // =====================================================
    //     // ✔ Total revenue (sum of all transaction totals)
    //     // =====================================================
    //     $total_revenue = $platform_transaction_datas->sum('total');

    //     // =====================================================
    //     // ✔ Withdrawn balance (actual paid out)
    //     // =====================================================
    //     $withdrawn_balance = TransactionPayout::where('type', 'platform')
    //         ->where('selected_currency', $selected_currency_id)
    //         ->when($session_id, fn($q) => $q->where('session_id', $session_id))
    //         ->sum('paid_amount');

    //     // =====================================================
    //     // ✔ Platform balance based on actual payments collected
    //     // =====================================================
    //     $platform_balance = 0;

    //     foreach ($platform_transaction_datas as $transaction) {

    //         // Sum of payments collected for this transaction
    //         $platformPaid = $transaction->payments->sum('paid_amount');

    //         // Get teacher percentage
    //         $teacherCourse = TeacherCourse::where('teacher_id', $transaction->teacher_id)
    //             ->where('course_id', $transaction->course_id)
    //             ->first();

    //         $teacher_percentage = $teacherCourse ? $teacherCourse->teacher_percentage : 0;

    //         // Teacher gets % from actual payments
    //         $teacher_share = $platformPaid * ($teacher_percentage / 100);

    //         // What platform keeps
    //         $platform_balance += ($platformPaid - $teacher_share);
    //     }

    //     // =====================================================
    //     // ✔ Return JSON
    //     // =====================================================
    //     return response()->json([
    //         'status'            => 'success',
    //         'message'           => 'Transactions fetched successfully',
    //         'data'              => $platform_transaction_datas,
    //         'total_revenue'     => $total_revenue,
    //         'platform_balance'  => $platform_balance,
    //         'withdrawn_balance' => $withdrawn_balance
    //     ]);
    // }

    public function platform_transaction_index(Request $request)
    {
        $selected_currency_id = $request->currency_id ?? Setting::find(6)->value;

        $session_id  = $request->session_id;
        $start_date  = $request->start_date;
        $end_date    = $request->end_date;

        // Fetch transactions with payments + express support
        $transactions = Transaction::with([
            'teacher',
            'course',
            'session',
            'currency',
            'payments',       // normal payments
            'expressPayments' // express payments
        ])
            ->where('selected_currency', $selected_currency_id)
            ->when($session_id, fn($q) => $q->where('session_id', $session_id))
            ->when($start_date, fn($q) => $q->whereDate('created_at', '>=', $start_date))
            ->when($end_date, fn($q) => $q->whereDate('created_at', '<=', $end_date))
            ->latest()
            ->get();

        // Withdrawn balance (platform payouts)
        $withdrawn_balance = TransactionPayout::where('type', 'platform')
            ->where('selected_currency', $selected_currency_id)
            ->when($session_id, fn($q) => $q->where('session_id', $session_id))
            ->sum('paid_amount');

        // Calculate transaction fields and platform balance
        foreach ($transactions as $transaction) {
            // Paid amount = sum of normal + express payments
            $paidAmount = $transaction->payments->sum('paid_amount');

            // Remaining amount
            $remainingAmount = $transaction->total - $paidAmount;

            // Teacher percentage
            $teacherCourse = TeacherCourse::where('teacher_id', $transaction->teacher_id)
                ->where('course_id', $transaction->course_id)
                ->first();

            $teacher_percentage = $teacherCourse->teacher_percentage ?? 0;

            // Teacher share from course fee
            $teacher_share = $transaction->course_fee * ($teacher_percentage / 100);

            // Platform share = course_fee - teacher_share
            $platform_share = $transaction->course_fee - $teacher_share;

            // Inject calculated values into transaction object
            $transaction->paid_amount = $paidAmount;
            $transaction->remaining_amount = $remainingAmount;
            $transaction->teacher_share = $teacher_share;
            $transaction->platform_share = $platform_share;
        }

        // =====================================================
        // Stats WITHOUT Date Filters
        // =====================================================

        // Re-fetching for stats with eager loading
        $statsTransactions = Transaction::with(['payments', 'expressPayments'])
            ->where('selected_currency', $selected_currency_id)
            ->when($session_id, fn($q) => $q->where('session_id', $session_id))
            ->get();

        $total_revenue = $statsTransactions->sum('total');
        $platform_balance = 0;

        foreach ($statsTransactions as $t) {
            $teacherCourse = TeacherCourse::where('teacher_id', $t->teacher_id)
                ->where('course_id', $t->course_id)
                ->first();

            $teacher_percentage = $teacherCourse->teacher_percentage ?? 0;

            // Platform share = course_fee - teacher_share
            $teacher_share = $t->course_fee * ($teacher_percentage / 100);
            $platform_share = $t->course_fee - $teacher_share;

            $platform_balance += $platform_share;
        }

        return response()->json([
            'status'            => 'success',
            'message'           => 'Transactions fetched successfully',
            'data'              => $transactions,
            'total_revenue'     => $total_revenue,
            'platform_balance'  => $platform_balance,
            'withdrawn_balance' => $withdrawn_balance
        ]);
    }











    public function platform_transaction_modal_store(Request $request, $transactionId)
    {
        try {
            $validated = $request->validate([
                'new_paid' => 'required|numeric|min:0',
                'remarks' => 'nullable|string|max:500',
            ]);

            $transaction = Transaction::with('payments')->find($transactionId);

            if (!$transaction) {
                return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
            }

            $newPaid = $validated['new_paid'];
            $remarks = $validated['remarks'] ?? null;
            $alreadyPaid = $transaction->payments->sum('paid_amount');

            $total = $transaction->total;

            if (($alreadyPaid + $newPaid) > $total) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Paid amount exceeds total transaction amount'
                ]);
            }

            // ✅ Update transaction
            $transaction->paid_amount += $newPaid;
            $transaction->save();

            // ✅ Record new payment with type = 'platform'
            Payment::create([
                'transaction_id' => $transaction->id,
                'paid_amount' => $newPaid,
                'type' => 'platform', // ✅ default platform type
                'remarks' => $remarks,
            ]);

            // ✅ Recalculate values (filtered by session + currency)
            $session_id = $transaction->session_id;
            $selected_currency_id = $transaction->selected_currency;

            // Total revenue (sum of total of filtered transactions)
            $total_revenue = Transaction::where('selected_currency', $selected_currency_id)
                ->when($session_id, fn($q) => $q->where('session_id', $session_id))
                ->sum('total');

            // Platform balance
            $transactions = Transaction::where('selected_currency', $selected_currency_id)
                ->when($session_id, fn($q) => $q->where('session_id', $session_id))
                ->get();

            $platform_balance = 0;
            foreach ($transactions as $t) {
                $teacherCourse = TeacherCourse::where('teacher_id', $t->teacher_id)
                    ->where('course_id', $t->course_id)
                    ->first();

                $teacher_percentage = $teacherCourse ? $teacherCourse->teacher_percentage : 0;
                $teacher_share = $t->total * ($teacher_percentage / 100);
                $platform_balance += ($t->total - $teacher_share);
            }

            // ✅ Withdrawn balance (sum of payments of type 'platform')
            $transaction_ids = $transactions->pluck('id');
            $withdrawn_balance = TransactionPayout::where('type', 'platform')
                ->where('selected_currency', $selected_currency_id)
                ->where('session_id', $session_id)   // filter by session
                ->sum('paid_amount');

            // ✅ Get currency name
            $currency = $transaction->currency ? $transaction->currency->currency_name : '';

            // ✅ Load updated transaction (with relations)
            $transaction = Transaction::with('teacher', 'course', 'session')->find($transactionId);

            return response()->json([
                'status' => 'success',
                'message' => 'Transaction & payment saved successfully',
                'transaction' => [
                    'id' => $transaction->id,
                    'teacher' => $transaction->teacher->name ?? '-',
                    'course' => $transaction->course->course_name ?? '-',
                    'session' => $transaction->session->session_name ?? '-',
                    'student_name' => $transaction->student_name,
                    'parent_name' => $transaction->parent_name,
                    'total' => $transaction->total,
                    'paid_amount' => $transaction->paid_amount,
                    'remaining' => max($transaction->total - $transaction->paid_amount, 0),
                    'created_at' => $transaction->created_at->format('Y-m-d H:i:s'),
                ],
                'currency' => $currency,
                'total_revenue' => $total_revenue,
                'platform_balance' => $platform_balance,
                'total_paid' => $withdrawn_balance, // ✅ now only platform payments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }






    public function platform_currency_update(Request $request)
    {
        // Get selected currency id from request
        $selectedCurrencyId = $request->input('default_currency');
        // Set the chosen currency as selected
        $currency = Setting::find(6);
        if ($currency) {
            $currency->value = $selectedCurrencyId;
            $currency->save();
        }

        return response()->json(['success' => true]);
    }




    public function perCourse(Request $request)
    {
        $selected_currency_id = Setting::find(6)->value;
        $sessionId = $request->session_id;

        // Fetch transactions + eager-load relations including payments
        $transactionsQuery = Transaction::with(['teacher', 'course', 'session', 'currency', 'payments'])

            ->where('selected_currency', $selected_currency_id);

        // Filter by session if provided
        if ($sessionId) {
            $transactionsQuery->where('session_id', $sessionId);
        }

        if ($request->start_date) {
            $transactionsQuery->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $transactionsQuery->whereDate('created_at', '<=', $request->end_date);
        }

        $transactions = $transactionsQuery->get();

        // Total withdrawn (UNFILTERED by date, only by session/currency)
        $withdrawn_balance = TransactionPayout::where('type', 'platform')
            ->where('selected_currency', $selected_currency_id)
            ->when($sessionId, fn($q) => $q->where('session_id', $sessionId))
            ->sum('paid_amount');

        // Total revenue (UNFILTERED by date)
        $statsTransactions = Transaction::where('selected_currency', $selected_currency_id)
            ->when($sessionId, fn($q) => $q->where('session_id', $sessionId))
            ->get();

        $total_revenue = $statsTransactions->sum('total');
        $platform_balance = $statsTransactions->sum('platform_amount');

        // ✅ Group by both course_id and teacher_id
        $grouped = $transactions->groupBy(function ($item) {
            return $item->course_id . '_' . $item->teacher_id;
        })->map(function ($items) {

            $course  = $items->first()->course;
            $teacher = $items->first()->teacher;
            $session = $items->first()->session;

            $total_amount = $items->sum('total');

            // 1️⃣ Sum normal platform payments
            $platform_payments = $items->sum(function ($t) {
                return $t->payments->sum('paid_amount');
            });



            // 3️⃣ Combine both
            $total_paid = $platform_payments;

            $platform_amount = $items->sum('platform_amount');

            $total_remaining = $total_paid - $platform_amount;

            return [
                "course_id"          => $items->first()->course_id,
                "course_title"       => $course?->course_title ?? "-",
                "teacher_id"         => $items->first()->teacher_id,
                "teacher_name"       => $teacher?->teacher_name ?? "-",
                "session_title"      => $session?->session_title ?? "-",
                "transactions_count" => $items->count(),
                "total_amount"       => $total_amount,
                "total_paid"         => $total_paid,
                "platform_amount"    => $platform_amount,
                "total_remaining"    => $total_remaining,
            ];
        })->values();


        return response()->json([
            'status'            => 'success',
            'message'           => 'Per-course & teacher transactions fetched successfully',
            'data'              => $grouped,
            'total_revenue'     => $total_revenue,
            'withdrawn_balance' => $withdrawn_balance,
            'platform_balance'  => $platform_balance,
        ]);
    }


    public function perCourseDetails(Request $request)
    {
        $courseId  = $request->course_id;
        $teacherId = $request->teacher_id;
        $sessionId = $request->session_id;

        $selected_currency_id = Setting::find(6)?->value;

        // Fetch all transactions for this course, teacher, session, and currency
        $transactions = Transaction::with(['payments'])
            ->where('course_id', $courseId)
            ->where('teacher_id', $teacherId)
            ->where('session_id', $sessionId)
            ->where('selected_currency', $selected_currency_id)
            ->get();

        $formatted = $transactions->map(function ($t) {
            // Sum platform payments from payments table
            $platform_paid = $t->payments->sum('paid_amount');

            // Add transaction's own paid_amount if it's an express course


            $paid_amount = $platform_paid;
            $remaining_amount = $paid_amount - $t->platform_amount;

            return [
                "id" => $t->id,
                "student_name" => $t->student_name,
                "total" => $t->total,
                "platform_amount" => $t->platform_amount,
                "paid_amount" => $paid_amount,
                "remaining_amount" => $remaining_amount,
            ];
        });

        return response()->json([
            "status" => "success",
            "data"   => $formatted
        ]);
    }















    public function teacherBalances(Request $request)
    {
        $sessionId = $request->session_id;
        $selected_currency_id = Setting::find(6)->value;

        $currency = Currency::find($selected_currency_id);
        $currency_name = $currency ? $currency->currency_name : '';
        $currency_symbol = $currency ? $currency->symbol : '';

        // Fetch transactions grouped by teacher
        $transactions = Transaction::with(['teacher', 'payments'])
            ->where('selected_currency', $selected_currency_id)
            ->when($sessionId, fn($q) => $q->where('session_id', $sessionId))
            ->when($request->start_date, fn($q) => $q->whereDate('created_at', '>=', $request->start_date))
            ->when($request->end_date, fn($q) => $q->whereDate('created_at', '<=', $request->end_date))
            ->get()
            ->groupBy('teacher_id')
            ->map(function ($teacherTransactions, $teacherId) use ($currency_name, $currency_symbol) {

                $teacher = $teacherTransactions->first()->teacher;

                // ✅ Use all transactions now, no filter on payments type
                $platformTransactions = $teacherTransactions;

                $total_revenue = $platformTransactions->sum('total');
                $total_platform_share = $platformTransactions->sum('platform_amount');
                $total_teacher_share = $platformTransactions->sum('teacher_amount');

                // Include payments of all platform transactions + express_course_id not null
                $normal_platform_paid = $platformTransactions->flatMap->payments->sum('paid_amount');

                $express_paid = $teacherTransactions
                    ->filter(fn($t) => !is_null($t->express_course_id))
                    ->flatMap->payments
                    ->sum('paid_amount');

                $total_platform_paid = $normal_platform_paid + $express_paid;

                $total_platform_balance = $total_platform_share - $total_platform_paid;

                // ✅ Sum teacher payouts
                $total_teacher_paid = TransactionPayout::where('teacher_id', $teacherId)
                    ->where('session_id', $teacherTransactions->first()->session_id)
                    ->where('selected_currency', $teacherTransactions->first()->selected_currency)
                    
                    ->sum('paid_amount');

                return [
                    'name' => $teacher->teacher_name,
                    'total_revenue' => (float) $total_revenue,
                    'total_platform_share' => (float) $total_platform_share,
                    'total_platform_paid' => (float) $total_platform_paid,
                    'total_teacher_share' => (float) $total_teacher_share,
                    'total_platform_balance' => (float) $total_platform_balance,
                    'total_teacher_paid' => (float) $total_teacher_paid,
                    'teacher_id' => $teacherId,
                    'email' => $teacher->teacher_email,
                    'currency_name' => $currency_name,
                    'currency_symbol' => $currency_symbol
                ];
            })
            ->values();

        return response()->json([
            'status' => 'success',
            'data' => $transactions,
            'currency_name' => $currency_name,
            'currency_symbol' => $currency_symbol
        ]);
    }






    public function getPayouts(Request $request, $session_id)
    {
        try {
            // Get selected currency ID from request or fall back to settings
            $selected_currency_id = $request->currency_id ?? Setting::find(6)->value;
            // dd($selected_currency_id);

            // Get currency name
            $default_currency = Currency::find($selected_currency_id);
            $currency_name = $default_currency ? $default_currency->currency_name : '';

            // Fetch platform payouts for this session and currency
            $payments = TransactionPayout::where('type', 'platform')
                ->where('session_id', $session_id)
                ->where('selected_currency', $selected_currency_id)
                ->when($request->start_date, fn($q) => $q->whereDate('created_at', '>=', $request->start_date))
                ->when($request->end_date, fn($q) => $q->whereDate('created_at', '<=', $request->end_date))
                ->with(['transaction', 'teacher', 'currency', 'session']) // eager load relations
                ->get();

            return response()->json([
                'success' => true,
                'currency' => $currency_name,
                'payments' => $payments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching payouts: ' . $e->getMessage(),
            ], 500);
        }
    }

    // public function getPayouts($session_id)
    // {
    //     try {
    //         $selected_currency_id = Setting::find(6)->value;
    //         $default_currency = Currency::find($selected_currency_id);
    //         $currency_name = $default_currency ? $default_currency->currency_name : '';

    //         $payments = Payment::where('type', 'platform') // only platform payouts
    //             ->whereHas('transaction', function ($query) use ($session_id, $selected_currency_id) {
    //                 $query->where('session_id', $session_id)
    //                     ->where('selected_currency', $selected_currency_id);
    //             })
    //             ->with([
    //                 'transaction.teacher:id,teacher_name',
    //                 'transaction.course:id,course_title',
    //                 'transaction.session:id,session_title',
    //             ])
    //             ->select('id', 'transaction_id', 'teacher_id', 'paid_amount', 'remarks', 'created_at')
    //             ->orderBy('created_at', 'desc')
    //             ->get();

    //         return response()->json([
    //             'success' => true,
    //             'data' => $payments->map(function ($p) use ($currency_name) {
    //                 $transaction = $p->transaction;
    //                 $teacher = $transaction->teacher ?? null;
    //                 $course = $transaction->course ?? null;
    //                 $session = $transaction->session ?? null;

    //                 return [
    //                     'date_time'    => $p->created_at->format('Y-m-d H:i:s'),
    //                     'teacher_name' => $teacher ? $teacher->teacher_name : '-',
    //                     'course_name'  => $course ? $course->course_title : '-',
    //                     'session_name' => $session ? $session->session_title : '-',
    //                     'student_name' => $transaction ? $transaction->student_name : '-',
    //                     'parent_name'  => $transaction ? $transaction->parent_name : '-',
    //                     'remarks'      => $p->remarks ?? '-',
    //                     'paid_amount'  => $p->paid_amount,
    //                     'currency_name' => $currency_name,
    //                 ];
    //             }),
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error fetching payouts: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }


    public function deletePayout($id)
    {
        try {
            $payment = TransactionPayout::find($id);
            if (!$payment) {
                return response()->json(['success' => false, 'message' => 'Payout not found']);
            }

            $payment->delete();

            return response()->json(['success' => true, 'message' => 'Payout deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }






    public function platform_payout(Request $request)
    {
        // Validate incoming request
        $data = $request->validate([
            'selected_currency_id' => 'required|integer',
            'session_id'           => 'required|integer',
            'paid_amount'          => 'required|numeric',
            'remarks'              => 'nullable|string',
        ]);

        // Create payout record
        $payout = TransactionPayout::create([
            'selected_currency' => $data['selected_currency_id'],
            'session_id'        => $data['session_id'],
            'paid_amount'       => $data['paid_amount'],
            'type'              => 'platform',
            'remarks'           => $data['remarks'] ?? null,
        ]);

        // Load relationships
        $payout->load(['session', 'currency']); // Make sure these relationships exist in your model

        // Return JSON response with relationships
        return response()->json([
            'success' => true,
            'payout'  => [
                'id'                 => $payout->id,
                'selected_currency'  => $payout->currency ? $payout->currency->currency_name : null,
                'session'            => $payout->session ? $payout->session->session_title : null,
                'paid_amount'        => $payout->paid_amount,
                'type'               => $payout->type,
                'remarks'            => $payout->remarks,
                'created_at'         => $payout->created_at->format('Y-m-d H:i:s'),
            ],
            'message' => 'Payout added successfully!'
        ]);
    }

    public function getCoursesByTeacher($teacherId)
    {
        try {
            // Get courses for the selected teacher from the pivot table
            $courses = TeacherCourse::where('teacher_id', $teacherId)
                ->with('course')
                ->get()
                ->pluck('course')
                ->filter() // Remove null values if any
                ->values();

            return response()->json([
                'success' => true,
                'courses' => $courses
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching courses: ' . $e->getMessage()
            ], 500);
        }
    }
}
