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

class PlatformController extends Controller
{
    public function create()
    {
        // Fetch default currency
        $currency_data = Setting::find(6);
        $selected_currency_id = $currency_data ? intval($currency_data->value) : null;

        // Fetch related data
        $subject_datas = Course::all();
        $teacher_datas = Teacher::all();
        $session_datas = Taxonomies_sessions::all();
        $currency_datas = Currency::all();
        $selectedCurrency = Currency::find($selected_currency_id);

        // Total revenue for selected currency
        $total_revenue = Transaction::where('selected_currency', $selected_currency_id)->sum('total');

        // Calculate platform balance
        $transactions = Transaction::where('selected_currency', $selected_currency_id)->get();
        $platform_balance = 0;

        foreach ($transactions as $transaction) {
            // Get teacher percentage for this course
            $teacherCourse = TeacherCourse::where('teacher_id', $transaction->teacher_id)
                ->where('course_id', $transaction->course_id)
                ->first();

            $teacher_percentage = $teacherCourse ? $teacherCourse->teacher_percentage : 0;

            // Teacher share
            $teacher_share = $transaction->total * ($teacher_percentage / 100);

            // Platform balance = total - teacher share
            $platform_balance += ($transaction->total - $teacher_share);
        }

        // Pass all variables to the view
        return view('platform.index', get_defined_vars());
    }









    public function platform_transaction_store(Request $request)
    {
        // Get default currency from settings
        $selected_currency_id = Setting::find(6)?->value ?? 0;

        try {
            // Validate request
            $validated = $request->validate([
                'teacher'             => 'required|exists:teachers,id',
                'course'              => 'required|exists:courses,id',
                'session'             => 'required|exists:taxonomies_sessions,id',
                'student_name'        => 'required|string|max:255',
                'parent_name'         => 'nullable|string|max:255',
                'total'               => 'required|numeric|min:0',
                'paid_amount'         => 'required|numeric|min:0',
                'selected_currency_id' => 'required|exists:currencies,id',
            ]);

            // Get teacher percentage for this course
            $teacherPercentage = Course::find($validated['course'])
                ->teacherCourses()
                ->where('teacher_id', $validated['teacher'])
                ->first()?->teacher_percentage ?? 0;

            // Calculate amounts
            $teacherAmount = $validated['total'] * ($teacherPercentage / 100);
            $platformAmount = $validated['total'] - $teacherAmount;

            // Create transaction
            $transaction = Transaction::create([
                'teacher_id'        => $validated['teacher'],
                'course_id'         => $validated['course'],
                'session_id'        => $validated['session'],
                'student_name'      => $validated['student_name'],
                'parent_name'       => $validated['parent_name'] ?? null,
                'total'             => $validated['total'],
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

            // Calculate total revenue
            $total_revenue = Transaction::where('selected_currency', $selected_currency_id)
                ->sum('total');

            // Calculate platform balance
            $platform_balance = Transaction::where('selected_currency', $selected_currency_id)
                ->sum('platform_amount');

            // Return response
            return response()->json([
                'status' => 'success',
                'message' => 'Transaction & payment saved successfully',
                'transaction' => [
                    'id'               => $transaction->id,
                    'teacher'          => $transaction->teacher->teacher_name ?? '',
                    'course'           => $transaction->course->course_title ?? '',
                    'session'          => $transaction->session->session_title ?? '',
                    'student_name'     => $transaction->student_name,
                    'parent_name'      => $transaction->parent_name,
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


    public function platform_transaction_index(Request $request)
    {
        $session_id = $request->session_id;
        $selected_currency_id = Setting::find(6)?->value ?? 0;

        // ✅ Fetch transactions with platform payments
        $platform_transaction_datas = Transaction::with([
            'teacher',
            'course',
            'session',
            'currency',
            'payments' => fn($q) => $q->where('type', 'platform') // only platform payments
        ])
            ->where('selected_currency', $selected_currency_id)
            ->when($session_id, fn($q) => $q->where('session_id', $session_id))
            ->whereHas('payments', fn($q) => $q->where('type', 'platform')) // only transactions with platform payments
            ->latest()
            ->get();

        // ✅ Total revenue from all transactions
        $total_revenue = $platform_transaction_datas->sum('total');

        // ✅ Collect transaction IDs
        $transaction_ids = $platform_transaction_datas->pluck('id');

        // ✅ Withdrawn balance = sum of actual paid_amount from payments table
        $withdrawn_balance = Payment::whereIn('transaction_id', $transaction_ids)
            ->where('type', 'platform')
            ->sum('paid_amount');

        // ✅ this is what you requested

        // ✅ Platform balance calculation per transaction
        $platform_balance = 0;
        foreach ($platform_transaction_datas as $transaction) {
            $teacherCourse = TeacherCourse::where('teacher_id', $transaction->teacher_id)
                ->where('course_id', $transaction->course_id)
                ->first();

            $teacher_percentage = $teacherCourse ? $teacherCourse->teacher_percentage : 0;
            $teacher_share = $transaction->total * ($teacher_percentage / 100);
            $platform_balance += ($transaction->total - $teacher_share);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Transactions fetched successfully',
            'data' => $platform_transaction_datas,
            'total_revenue' => $total_revenue,
            'platform_balance' => $platform_balance,
            'withdrawn_balance' => $withdrawn_balance, // ✅ sum of payments.paid_amount
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
            $withdrawn_balance = Payment::whereIn('transaction_id', $transaction_ids)
                ->where('type', 'platform')
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
        $selected_currency_id = Setting::find(6)?->value ?? 0;
        $sessionId = $request->session_id;

        // ✅ Fetch transactions + eager-load relations including payments
        $transactionsQuery = Transaction::with(['teacher', 'course', 'session', 'currency', 'payments'])
            ->whereHas('payments', function ($q) {
                $q->where('type', 'platform'); // Only payments where type is 'platform'
            })
            ->where('selected_currency', $selected_currency_id);

        // Filter by session if provided
        if ($sessionId) {
            $transactionsQuery->where('session_id', $sessionId);
        }

        $transactions = $transactionsQuery->get();

        // ✅ Total revenue (sum of total of all transactions)
        $total_revenue = $transactions->sum('total');

        // ✅ Total withdrawn (sum of all platform payments of all transactions)
        $withdrawn_balance = $transactions->sum(function ($t) {
            return $t->payments->where('type', 'platform')->sum('paid_amount');
        });

        // ✅ Platform balance as sum of platform_amount column
        $platform_balance = $transactions->sum('platform_amount');

        // ✅ Group-by course_id and calculate sums using platform payments
        $grouped = $transactions->groupBy('course_id')->map(function ($items) {
            $course = $items->first()->course;
            $session = $items->first()->session;

            $total_amount = $items->sum('total');

            // Sum only platform payments per transaction in this group
            $total_paid = $items->sum(function ($t) {
                return $t->payments->where('type', 'platform')->sum('paid_amount');
            });

            // ✅ Platform amount per course
            $platform_amount = $items->sum('platform_amount');

            // Remaining = total_paid - platform_amount
            $total_remaining = $total_paid - $platform_amount;

            return [
                "course_id"          => $items->first()->course_id,
                "course_title"       => $course ? $course->course_title : "-",
                "session_title"      => $session ? $session->session_title : "-",
                "transactions_count" => $items->count(),
                "total_amount"       => $total_amount,
                "total_paid"         => $total_paid,
                "platform_amount"    => $platform_amount,
                "total_remaining"    => $total_remaining,
            ];
        })->values();


        return response()->json([
            'status'            => 'success',
            'message'           => 'Per-course transactions fetched successfully',
            'data'              => $grouped,
            'total_revenue'     => $total_revenue,
            'withdrawn_balance' => $withdrawn_balance,
            'platform_balance'  => $platform_balance, // now sum of platform_amount
        ]);
    }
















    public function teacherBalances(Request $request)
    {
        $sessionId = $request->session_id;
        $selected_currency_id = Setting::find(6)?->value ?? 0;
        $currency = Currency::find($selected_currency_id);
        $currency_name = $currency ? $currency->currency_name : '';
        $currency_symbol = $currency ? $currency->symbol : '';

        $transactions = Transaction::with(['teacher', 'payments'])
            ->where('selected_currency', $selected_currency_id)
            ->when($sessionId, fn($q) => $q->where('session_id', $sessionId))
            ->get()
            ->groupBy('teacher_id')
            ->map(function ($teacherTransactions, $teacherId) use ($currency_name, $currency_symbol) {
                $teacher = $teacherTransactions->first()->teacher;

                // ✅ Only include transactions with a payment of type 'platform'
                $platformTransactions = $teacherTransactions->filter(fn($t) => $t->payments->where('type', 'platform')->count() > 0);

                // Sum totals only for those transactions
                $total_revenue = $platformTransactions->sum('total');
                $total_platform_share = $platformTransactions->sum('platform_amount');
                $total_platform_paid = $platformTransactions->flatMap->payments
                    ->where('type', 'platform')
                    ->sum('paid_amount');
                $total_platform_balance = $total_platform_share - $total_platform_paid;

                return [
                    'name' => $teacher->teacher_name,
                    'total_revenue' => (float) $total_revenue,
                    'total_platform_share' => (float) $total_platform_share,
                    'total_platform_paid' => (float) $total_platform_paid,
                    'total_platform_balance' => (float) $total_platform_balance,
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




    public function getPayouts($session_id)
    {
        try {
            $selected_currency_id = Setting::find(6)->value;
            $default_currency = Currency::find($selected_currency_id);
            $currency_name = $default_currency ? $default_currency->currency_name : '';

            $payments = Payment::where('type', 'platform') // only platform payouts
                ->whereHas('transaction', function ($query) use ($session_id, $selected_currency_id) {
                    $query->where('session_id', $session_id)
                        ->where('selected_currency', $selected_currency_id);
                })
                ->with([
                    'transaction.teacher:id,teacher_name',
                    'transaction.course:id,course_title',
                    'transaction.session:id,session_title',
                ])
                ->select('id', 'transaction_id', 'teacher_id', 'paid_amount', 'remarks', 'created_at')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $payments->map(function ($p) use ($currency_name) {
                    $transaction = $p->transaction;
                    $teacher = $transaction->teacher ?? null;
                    $course = $transaction->course ?? null;
                    $session = $transaction->session ?? null;

                    return [
                        'date_time'    => $p->created_at->format('Y-m-d H:i:s'),
                        'teacher_name' => $teacher ? $teacher->teacher_name : '-',
                        'course_name'  => $course ? $course->course_title : '-',
                        'session_name' => $session ? $session->session_title : '-',
                        'student_name' => $transaction ? $transaction->student_name : '-',
                        'parent_name'  => $transaction ? $transaction->parent_name : '-',
                        'remarks'      => $p->remarks ?? '-',
                        'paid_amount'  => $p->paid_amount,
                        'currency_name' => $currency_name,
                    ];
                }),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching payouts: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function deletePayout($id)
    {
        try {
            $payment = Payment::find($id);
            if (!$payment) {
                return response()->json(['success' => false, 'message' => 'Payout not found']);
            }

            $payment->delete();

            return response()->json(['success' => true, 'message' => 'Payout deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
