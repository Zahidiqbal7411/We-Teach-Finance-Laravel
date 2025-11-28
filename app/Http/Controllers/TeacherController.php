<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Currency;
use App\Models\Setting;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Taxonomies_sessions;
use App\Models\Teacher;
use App\Models\TeacherCourse;
use App\Models\TransactionPayout;

class TeacherController extends Controller
{
    public function create()
    {
        $session_datas = Taxonomies_sessions::all();
        $currency_datas = Currency::all();
        $teacher_datas = Teacher::all();

        $subject_datas = Course::all();

        // Get teacher-course relationships
        $teacher_courses = TeacherCourse::with('course')->get();

        $currentCurrency = Currency::find(Setting::find(6)?->value);

        return view('teacher.index', get_defined_vars());
    }


    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:acc_teachers,id',
            'course' => 'required|exists:acc_courses,id',
            'student_name' => 'required|string',
            'student_contact' => 'nullable|string',
            'student_email' => 'nullable|email',
            'parent_name' => 'nullable|string',
            'course_fee' => 'required|numeric',
            'note_fee' => 'required|numeric',
            'total' => 'required|numeric',
            'paid_amount' => 'required|numeric',
            'remaining' => 'required|numeric',
            'session_id' => 'required|exists:acc_taxonomies_sessions,id',
        ]);

        // FEES
        $courseFee = $request->course_fee;
        $noteFee   = $request->note_fee;

        // GET PERCENTAGE
        $teacherPercentage = Course::find($request->course)
            ->teacherCourses()
            ->where('teacher_id', $request->teacher_id)
            ->first()?->teacher_percentage ?? 0;

        // CALCULATIONS
        $teacherShareFromCourse = $courseFee * ($teacherPercentage / 100);
        $teacherAmount = $teacherShareFromCourse + $noteFee;
        $platformAmount = $courseFee - $teacherShareFromCourse;

        // CURRENT CURRENCY
        $currentCurrency = Currency::find(Setting::find(6)?->value);

        // CREATE TRANSACTION
        $transaction = Transaction::create([
            'teacher_id' => $request->teacher_id,
            'course_id' => $request->course,
            'student_name' => $request->student_name,
            'student_contact' => $request->student_contact,
            'student_email' => $request->student_email,
            'parent_name' => $request->parent_name,
            'selected_currency' => $currentCurrency->id,
            'course_fee' => $courseFee,
            'note_fee' => $noteFee,
            'total' => $request->total,
            'paid_amount' => $request->paid_amount,
            'remaining' => $request->remaining,
            'session_id' => $request->session_id,
            'teacher_amount' => $teacherAmount,
            'platform_amount' => $platformAmount,
        ]);

        // CREATE PAYMENT
        Payment::create([
            'teacher_id' => $request->teacher_id,
            'transaction_id' => $transaction->id,
            'type' => 'platform',
            'paid_amount' => $request->paid_amount,
        ]);

        return response()->json([
            'success' => true,
            'transaction' => $transaction,
        ]);
    }






    public function getTeacherData($id)
    {
        $teacher = Teacher::find($id);

        // ✅ Get default currency from Setting (e.g., setting_id = 6)
        $defaultCurrencyId = Setting::find(6)?->value;
        $defaultCurrency = Currency::find($defaultCurrencyId);

        if (!$teacher) {
            return response()->json(['error' => 'Teacher not found'], 404);
        }

        // ✅ Filters from request
        $sessionId = request()->query('session_id');
        $currencyId = request()->query('currency_id');
        $fromDate = request()->query('from_date');
        $toDate = request()->query('to_date');
        $currencyToUse = $currencyId ?? $defaultCurrency?->id;

        // ✅ Base query with relations
        $transactionsQuery = $teacher->transactions()
            ->with(['course', 'session', 'currency']);


        // ✅ Apply dynamic filters
        if ($sessionId) {
            $transactionsQuery->where('session_id', $sessionId);
        }

        if ($currencyId) {
            $transactionsQuery->where('selected_currency', $currencyId);
        }

        // ✅ Apply date filters
        if ($fromDate) {
            $transactionsQuery->whereDate('created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $transactionsQuery->whereDate('created_at', '<=', $toDate);
        }

        $transactions = $transactionsQuery->get();

        // ✅ Calculate Total Earned: sum of all 'teacher_amount' from filtered transactions
        $totalEarned = $transactions->sum(function ($tx) {
            if ($tx->teacher_amount && $tx->teacher_amount > 0) {
                return $tx->teacher_amount;
            }

            // Fallback: Calculate from course teacher percentage
            $teacherPercentage = $tx->course->teacherCourses()
                ->where('teacher_id', $tx->teacher_id)
                ->first()?->teacher_percentage ?? 0;

            return $tx->total * ($teacherPercentage / 100);
        });

        // ✅ Calculate Paid Before: sum of all payouts from TransactionPayout table
        $paidBefore = TransactionPayout::where('teacher_id', $teacher->id)
            ->when($sessionId, fn($q) => $q->where('session_id', $sessionId))
            ->when($currencyToUse, fn($q) => $q->where('selected_currency', $currencyToUse))
            ->sum('paid_amount');

        // ✅ Calculate Current Balance
        $currentBalance = $totalEarned - $paidBefore;

        // ✅ Prepare transactions for response
        $transactionsData = $transactions->map(function ($tx) {
            $total = $tx->total ?? 0;

            // sum of teacher payments for this transaction
            $paid = $tx->payments->sum('paid_amount');
            $remaining = $total - $paid;

            return [
                'id' => $tx->id,
                'teacher_id' => $tx->teacher_id,
                'date' => $tx->created_at ? $tx->created_at->format('M d, Y, h:i A') : 'N/A',
                'course' => $tx->course->course_title ?? 'N/A',
                'session' => $tx->session->session_title ?? 'N/A',
                'student' => $tx->student_name ?? 'N/A',
                'student_contact' => $tx->student_contact ?? 'N/A',
                'student_email' => $tx->student_email ?? 'N/A',
                'parent' => $tx->parent_name ?? 'N/A',
                'currency' => $tx->currency->currency_name ?? 'N/A',
                'total' => $total,
                'paid' => $paid,
                'remaining' => $remaining,
            ];
        });

        // ✅ Calculate totals
        $totals = [
            'total_amount' => $transactionsData->sum('total'),
            'total_paid' => $transactionsData->sum('paid'),
            'total_remaining' => $transactionsData->sum('remaining'),
        ];

        // ✅ Determine display currency
        if ($currencyId) {
            $currency = Currency::find($currencyId);
            $displayCurrency = $currency?->currency_name ?? $defaultCurrency?->currency_name ?? 'N/A';
        } else {
            $displayCurrency = $defaultCurrency?->currency_name ?? 'N/A';
        }

        // ✅ Return formatted JSON response
        return response()->json([
            'teacher' => [
                'id' => $teacher->id,
                'name' => $teacher->teacher_name,
                'email' => $teacher->teacher_email,
            ],
            'filters' => [
                'session_id' => $sessionId,
                'currency_id' => $currencyId,
            ],
            'totals' => [
                'currency' => $displayCurrency,
                'total' => number_format($totals['total_amount'], 2) . ' ' . $displayCurrency,
                'paid' => number_format($totals['total_paid'], 2) . ' ' . $displayCurrency,
                'remaining' => number_format($totals['total_remaining'], 2) . ' ' . $displayCurrency,
                'total_earned' => number_format($totalEarned, 2) . ' ' . $displayCurrency,
                'paid_before' => number_format($paidBefore, 2) . ' ' . $displayCurrency,
                'current_balance' => number_format($currentBalance, 2) . ' ' . $displayCurrency,
            ],
            'transactions' => $transactionsData,
        ]);
    }










    public function getPerCourseTransactions($teacherId, Request $request)
    {
        try {
            $sessionId = $request->query('session_id');
            $currencyId = $request->query('currency_id');
            $fromDate = $request->query('from_date');
            $toDate = $request->query('to_date');

            $defaultCurrencyId = Setting::find(6)?->value;
            $defaultCurrency = Currency::find($defaultCurrencyId);
            if (!$currencyId) $currencyId = $defaultCurrencyId;

            $teacher = Teacher::find($teacherId);
            if (!$teacher) {
                return response()->json(['error' => 'Teacher not found'], 404);
            }

            // Fetch all teacher transactions with payments
            $allTransactions = Transaction::where('teacher_id', $teacherId)

                ->when($sessionId, fn($q) => $q->where('session_id', $sessionId))
                ->when($currencyId, fn($q) => $q->where('selected_currency', $currencyId))
                ->when($fromDate, fn($q) => $q->whereDate('created_at', '>=', $fromDate))
                ->when($toDate, fn($q) => $q->whereDate('created_at', '<=', $toDate))
                ->with(['payments', 'course', 'currency', 'session'])
                ->get();

            // Compute totals
            $totalEarned = $allTransactions->sum(function ($tx) {
                if ($tx->teacher_amount && $tx->teacher_amount > 0) {
                    return $tx->teacher_amount;
                }
                $teacherPercentage = $tx->course?->teacherCourses()
                    ->where('teacher_id', $tx->teacher_id)
                    ->first()?->teacher_percentage ?? 0;

                return ($tx->total ?? 0) * ($teacherPercentage / 100);
            });

            $paidBefore = $allTransactions->sum(fn($tx) => $tx->payments->sum('paid_amount'));
            $currentBalance = $totalEarned - $paidBefore;

            // Fetch courses with transactions - simplified approach
            // Instead of complex nested whereHas, just get unique courses from transactions we already have
            $courseIds = $allTransactions->pluck('course_id')->unique();
            $courses = Course::whereIn('id', $courseIds)->get();

            $coursesData = $courses->map(function ($course) use ($teacherId, $sessionId, $currencyId, $fromDate, $toDate, $defaultCurrency) {
                $transactions = Transaction::where('course_id', $course->id)
                    ->where('teacher_id', $teacherId)
                    ->with(['session', 'currency', 'payments'])

                    ->when($sessionId, fn($q) => $q->where('session_id', $sessionId))
                    ->when($currencyId, fn($q) => $q->where('selected_currency', $currencyId))
                    ->when($fromDate, fn($q) => $q->whereDate('created_at', '>=', $fromDate))
                    ->when($toDate, fn($q) => $q->whereDate('created_at', '<=', $toDate))
                    ->get();

                $total = $transactions->sum(fn($tx) => $tx->total ?? 0);
                $paid = $transactions->sum(fn($tx) => $tx->payments->sum('paid_amount'));
                $remaining = $total - $paid;

                $displayCurrency = $transactions->first()?->currency?->currency_name ?? $defaultCurrency?->currency_name ?? 'N/A';

                return [
                    'id' => $course->id,
                    'name' => $course->course_title ?? 'N/A',
                    'session' => $transactions->first()?->session?->session_title ?? 'N/A',
                    'transactions' => $transactions->count(),
                    'total_amount' => number_format($total, 2) . ' ' . $displayCurrency,
                    'total_paid' => number_format($paid, 2) . ' ' . $displayCurrency,
                    'total_remaining' => number_format($remaining, 2) . ' ' . $displayCurrency,
                    'transactions_details' => $transactions->map(fn($tx) => [
                        'id' => $tx->id,
                        'date' => $tx->created_at?->format('M d, Y, h:i A') ?? 'N/A',
                        'student' => $tx->student_name ?? 'N/A',
                        'student_contact' => $tx->student_contact ?? 'N/A',
                        'student_email' => $tx->student_email ?? 'N/A',
                        'currency' => $tx->currency?->currency_name ?? $defaultCurrency?->currency_name ?? 'N/A',
                        'total' => number_format($tx->total ?? 0, 2),
                        'paid' => number_format($tx->payments->sum('paid_amount'), 2),
                        'remaining' => number_format(($tx->total ?? 0) - $tx->payments->sum('paid_amount'), 2),
                    ]),
                ];
            });

            return response()->json([
                'teacher' => [
                    'id' => $teacher->id,
                    'name' => $teacher->teacher_name ?? 'N/A',
                    'email' => $teacher->teacher_email ?? 'N/A',
                ],
                'filters' => [
                    'session_id' => $sessionId,
                    'currency_id' => $currencyId,
                ],
                'totals' => [
                    'currency' => $defaultCurrency?->currency_name ?? 'N/A',
                    'total_earned' => number_format($totalEarned, 2),
                    'paid_before' => number_format($paidBefore, 2),
                    'current_balance' => number_format($currentBalance, 2),
                ],
                'courses' => $coursesData,
            ]);
        } catch (\Throwable $e) {
            \Log::error('getPerCourseTransactions Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error', 'message' => $e->getMessage()], 500);
        }
    }

    public function restore(Request $request)
    {
        \Log::info('Restore called', $request->all());

        // Validate input
        $validated = $request->validate([
            'transaction_id' => 'required|integer|exists:acc_transactions,id',
            'new_paid' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:255',
        ]);

        try {
            // Find transaction
            $transaction = Transaction::findOrFail($validated['transaction_id']);

            // Verify this is a teacher transaction
            $payment = Payment::where('transaction_id', $transaction->id)
                
                ->first();

            if (!$payment) {
                return response()->json([
                    'success' => false,
                    'message' => 'This transaction is not for a teacher.'
                ], 400);
            }

            // Get payable amount
            $payable = $transaction->total - $transaction->paid_amount;

            if ($payable <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction already fully paid!'
                ], 400);
            }

            // Calculate amount to pay (cannot exceed remaining balance)
            $toPay = min($validated['new_paid'], $payable);

            // IMPORTANT: Update the database
            $transaction->paid_amount = $transaction->paid_amount + $toPay;
            $transaction->save();

            // Persist the payment so totals computed from payments remain correct
            Payment::create([
                'teacher_id' => $transaction->teacher_id,
                'transaction_id' => $transaction->id,
                'type' => 'platform',
                'paid_amount' => $toPay,
                'remarks' => $validated['remarks'] ?? null,
            ]);

            // Refresh from database to ensure we have latest values
            $transaction->refresh();

            $remaining = $transaction->total - $transaction->paid_amount;

            \Log::info('Transaction updated', [
                'id' => $transaction->id,
                'paid_amount' => $transaction->paid_amount,
                'remaining' => $remaining
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Transaction updated successfully',
                'paid' => $transaction->paid_amount,
                'remaining' => $remaining,
                'transaction' => [
                    'id' => $transaction->id,
                    'total' => $transaction->total,
                    'paid' => $transaction->paid_amount,
                    'remaining' => $remaining
                ]
            ], 200);
        } catch (\Exception $err) {
            \Log::error('Restore error: ' . $err->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $err->getMessage()
            ], 500);
        }
    }

    /**
     * Get current balance for a teacher based on session and currency
     * Balance = sum of teacher_amount from transactions where:
     * - session_id matches parameter
     * - selected_currency matches parameter
     * - has payment with type='teacher'
     */
    public function getCurrentBalance($teacherId, Request $request)
    {
        $sessionId = $request->query('session_id');
        $currencyId = $request->query('currency_id');

        if (!$sessionId || !$currencyId) {
            return response()->json([
                'success' => false,
                'message' => 'session_id and currency_id are required'
            ], 400);
        }

        // Get transactions matching filters
        $transactions = Transaction::where('teacher_id', $teacherId)
            ->where('session_id', $sessionId)
            ->where('selected_currency', $currencyId)

            ->with(['course.teacherCourses', 'payments'])
            ->get();

        // Calculate balance: sum teacher_amount (with fallback calculation)
        $totalEarned = $transactions->sum(function ($tx) {
            if ($tx->teacher_amount && $tx->teacher_amount > 0) {
                return $tx->teacher_amount;
            }

            // Fallback: Calculate from course teacher percentage
            $teacherPercentage = $tx->course->teacherCourses()
                ->where('teacher_id', $tx->teacher_id)
                ->first()?->teacher_percentage ?? 0;

            return $tx->total * ($teacherPercentage / 100);
        });

        // ✅ Correct paidBefore calculation using TransactionPayout
        $paidBefore = TransactionPayout::where('teacher_id', $teacherId)
            ->where('session_id', $sessionId)
            ->where('selected_currency', $currencyId)
            ->sum('paid_amount');

        $balance = $totalEarned - $paidBefore;

        $currency = Currency::find($currencyId);
        $currencyName = $currency?->currency_name ?? 'N/A';

        return response()->json([
            'success' => true,
            'current_balance' => round($balance, 2),
            'currency_name' => $currencyName,
            'teacher_id' => $teacherId,
            'paid_before' => $paidBefore,
            'session_id' => $sessionId,
            'currency_id' => $currencyId
        ]);
    }


    /**
     * Restore per-course transaction payment
     */
    public function restorePerCourse(Request $request)
    {
        \Log::info('RestorePerCourse called', $request->all());

        // Validate input
        $validated = $request->validate([
            'transaction_id' => 'required|integer|exists:acc_transactions,id',
            'new_paid' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:255',
        ]);

        try {
            // Find transaction
            $transaction = Transaction::findOrFail($validated['transaction_id']);

            // Verify this is a teacher transaction
            $payment = Payment::where('transaction_id', $transaction->id)
                
                ->first();

            if (!$payment) {
                return response()->json([
                    'success' => false,
                    'message' => 'This transaction is not for a teacher.'
                ], 400);
            }

            // Get payable amount
            $payable = $transaction->total - $transaction->paid_amount;

            if ($payable <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction already fully paid!'
                ], 400);
            }

            // Calculate amount to pay (cannot exceed remaining balance)
            $toPay = min($validated['new_paid'], $payable);

            // IMPORTANT: Update the database
            $transaction->paid_amount = $transaction->paid_amount + $toPay;
            $transaction->save();

            // Persist the payment for per-course restores as well
            Payment::create([
                'teacher_id' => $transaction->teacher_id,
                'transaction_id' => $transaction->id,
                'type' => 'platform',
                'paid_amount' => $toPay,
                'remarks' => $validated['remarks'] ?? null,
            ]);

            // Refresh from database to ensure we have latest values
            $transaction->refresh();

            $remaining = $transaction->total - $transaction->paid_amount;

            \Log::info('Per-course transaction updated', [
                'id' => $transaction->id,
                'paid_amount' => $transaction->paid_amount,
                'remaining' => $remaining
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Per-course transaction updated successfully',
                'paid' => $transaction->paid_amount,
                'remaining' => $remaining,
                'transaction' => [
                    'id' => $transaction->id,
                    'total' => $transaction->total,
                    'paid' => $transaction->paid_amount,
                    'remaining' => $remaining
                ]
            ], 200);
        } catch (\Exception $err) {
            \Log::error('RestorePerCourse error: ' . $err->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $err->getMessage()
            ], 500);
        }
    }

    /**
     * Get teacher payouts data based on session and currency
     */
    public function getPayouts($session_id, Request $request)
    {
        try {
            // Get default currency
            $setting = Setting::find(6);
            $default_currency_id = $setting ? $setting->value : null;

            // Get currency from request or use default
            $currency_id = $request->query('currency_id') ?? $default_currency_id;
            $currency = $currency_id ? Currency::find($currency_id) : null;
            $currency_name = $currency ? $currency->currency_name : '';

            // DEBUG LOGGING
            \Log::info('=== PAYOUT QUERY DEBUG ===');
            \Log::info('Session ID: ' . $session_id);
            \Log::info('Requested Currency ID: ' . $currency_id);
            \Log::info('Currency Name: ' . $currency_name);

            // Get date filters
            $fromDate = $request->query('from_date');
            $toDate = $request->query('to_date');

            // Build the query
            $query = TransactionPayout::where('session_id', $session_id);

            if ($currency_id) {
                $query->where('selected_currency', $currency_id);
                \Log::info('Filtering by currency: ' . $currency_id);
            }

            // Apply date filters
            if ($fromDate) {
                $query->whereDate('created_at', '>=', $fromDate);
            }

            if ($toDate) {
                $query->whereDate('created_at', '<=', $toDate);
            }

            // Eager load relationships
            $payments = $query->with(['teacher', 'course', 'session', 'transaction', 'currency'])
                ->orderBy('created_at', 'desc')
                ->get();

            \Log::info('Total payouts found: ' . $payments->count());
            foreach ($payments as $p) {
                \Log::info('Payout ID: ' . $p->id . ', selected_currency: ' . $p->selected_currency . ', amount: ' . $p->paid_amount);
            }
            \Log::info('========================');

            // Transform the data
            $data = $payments->map(function ($p) use ($currency_name) {
                $teacher = $p->teacher;
                $course = $p->course;
                $session = $p->session;
                $transaction = $p->transaction;

                return [
                    'id'            => $p->id,
                    'date_time'     => $p->created_at->format('Y-m-d H:i:s'),
                    'teacher_name'  => $teacher ? $teacher->teacher_name : '-',
                    'course_name'   => $course ? $course->course_title : '-',
                    'session_name'  => $session ? $session->session_title : '-',
                    'student_name'  => $transaction ? $transaction->student_name : '-',
                    'parent_name'   => $transaction ? $transaction->parent_name : '-',
                    'remarks'       => $p->remarks ?? '-',
                    'paid_amount'   => $p->paid_amount,
                    'currency_name' => $p->currency ? $p->currency->currency_name : $currency_name,
                ];
            });

            return response()->json([
                'success' => true,
                'payments' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching payouts: ' . $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Delete a transaction
     */
    public function deleteTransaction($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);

            // Delete associated payments first
            Payment::where('transaction_id', $id)->delete();

            // Delete the transaction
            $transaction->delete();

            return response()->json([
                'success' => true,
                'message' => 'Transaction deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting transaction: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a payout (payment record)
     */
    public function deletePayout($id)
    {
        try {
            $payment = TransactionPayout::findOrFail($id);

            // Get the transaction to update paid_amount




            // Delete the payment
            $payment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Payout deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting payout: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateCurrency(Request $request)
    {
        // Validate input
        $request->validate([
            'currency_id' => 'required|integer|exists:currencies,id',
        ]);

        $currencyId = $request->input('currency_id');

        // Find the currency
        $currency = Currency::find($currencyId);

        if (!$currency) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid currency ID'
            ], 400);
        }

        // Update the default currency setting
        $setting = Setting::where('type', 'default_currency')->first();

        if (!$setting) {
            return response()->json([
                'status' => 'error',
                'message' => 'Default currency setting not found'
            ], 404);
        }

        $setting->value = $currencyId;
        $setting->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Currency updated successfully',
            'currency' => $currency->currency_name
        ]);
    }


    public function storePayout(Request $request)
    {
        $request->validate([
            'session_id' => 'required|integer',
            'selected_currency' => 'required|integer',
            'teacher_id' => 'required|integer',
            'course_id' => 'nullable|integer',
            'paid_amount' => 'required|numeric',
            'remarks' => 'nullable|string',
        ]);

        $payout = TransactionPayout::create([
            'transaction_id' => null,           // leave empty
            'type' => 'platform',                // set type to teacher
            'session_id' => $request->session_id,
            'selected_currency' => $request->selected_currency,
            'teacher_id' => $request->teacher_id,
            'course_id' => $request->course_id,
            'paid_amount' => $request->paid_amount,
            'remarks' => $request->remarks,
        ]);

        // Load related models for proper display
        $payout->load(['teacher', 'course', 'session', 'currency']);

        return response()->json([
            'success' => true,
            'payout' => $payout
        ]);
    }
}
