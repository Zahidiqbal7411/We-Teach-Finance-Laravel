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

class TeacherController extends Controller
{
    public function create()
    {
        $session_datas = Taxonomies_sessions::all();
        $currency_datas = Currency::all();
        $teacher_datas = Teacher::all();

        $subject_datas = Course::all();
        $teacher_datas = Teacher::all();
        $currentCurrency = Currency::find(Setting::find(6)?->value);

        return view('teacher.index', get_defined_vars());
    }


    public function store(Request $request)
    {

        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'course' => 'required|exists:courses,id',
            'student_name' => 'required|string',
            'parent_name' => 'nullable|string',
            'total' => 'required|numeric',
            'paid_amount' => 'required|numeric',
            'remaining' => 'required|numeric',
            'session_id' => 'required|exists:taxonomies_sessions,id',

        ]);
        $currentCurrency = Currency::find(Setting::find(6)?->value);
        $transaction = Transaction::create([
            'teacher_id' => $request->teacher_id,
            'course_id' => $request->course,
            'student_name' => $request->student_name,
            'parent_name' => $request->parent_name,
            'selected_currency'  => $currentCurrency->id,
            'total' => $request->total,
            'paid_amount' => $request->paid_amount,
            'remaining' => $request->remaining,
            'session_id' => $request->session_id,
        ]);
        Payment::create([
            'teacher_id' => $request->teacher_id,
            'transaction_id' => $transaction->id,
            'type' => 'teacher',
            'paid_amount' => $request->paid_amount,  // Add this
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

        // ✅ Filters
        $sessionId = request()->query('session_id');
        $currencyId = request()->query('currency_id');

        // ✅ Base query with relations
        $transactionsQuery = $teacher->transactions()
            ->with(['course', 'session', 'payments', 'currency'])
            ->whereHas('payments', function ($query) {
                $query->where('type', 'teacher');
            });

        // ✅ Apply dynamic filters
        if ($sessionId) {
            $transactionsQuery->where('session_id', $sessionId);
        }

        if ($currencyId) {
            $transactionsQuery->where('selected_currency', $currencyId);
        }

        $transactions = $transactionsQuery->get();

        // ✅ Prepare transactions
        $transactionsData = $transactions->map(function ($tx) {
            $total = $tx->total ?? 0;
            $paid = $tx->payments->where('type', 'teacher')->sum('paid_amount');
            $remaining = $total - $paid;

            return [
                'id' => $tx->id,
                'teacher_id' => $tx->teacher_id,
                'date' => $tx->created_at ? $tx->created_at->format('d/m/Y, h:i:s A') : 'N/A',
                'course' => $tx->course->course_title ?? 'N/A',
                'session' => $tx->session->session_title ?? 'N/A',
                'student' => $tx->student_name ?? 'N/A',
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

        // ✅ Determine which currency to show with totals
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
            ],



            'transactions' => $transactionsData,
        ]);
    }








    public function getPerCourseTransactions($teacherId, Request $request)
    {
        $sessionId = $request->query('session_id');
        $currencyId = $request->query('currency_id');

        // Default currency
        $defaultCurrencyId = Setting::find(6)?->value;
        $defaultCurrency = Currency::find($defaultCurrencyId);
        if (!$currencyId) $currencyId = $defaultCurrencyId;

        $teacher = Teacher::find($teacherId);
        if (!$teacher) {
            return response()->json(['error' => 'Teacher not found'], 404);
        }

        // Get teacher courses that have transactions for the selected session
        // Use a database-level query (whereHas) rather than filtering an in-memory
        // collection. This is more reliable and efficient for large datasets.
        $courses = Course::whereHas('transactions', function ($q) use ($teacherId, $sessionId, $currencyId) {
            $q->where('teacher_id', $teacherId)
                ->when($sessionId, fn($q2) => $q2->where('session_id', $sessionId))
                ->when($currencyId, fn($q2) => $q2->where('selected_currency', $currencyId))
                ->whereHas('payments', fn($q3) => $q3->where('type', 'teacher'));
        })->get();

        // Map courses to compute totals
        $coursesData = $courses->map(function ($course) use ($sessionId, $currencyId, $defaultCurrency) {
            $transactions = $course->transactions()
                ->with(['session', 'currency', 'payments'])
                ->whereHas('payments', function ($q) {
                    $q->where('type', 'teacher');
                })
                ->when($sessionId, fn($q) => $q->where('session_id', $sessionId))
                ->when($currencyId, fn($q) => $q->where('selected_currency', $currencyId))
                ->get();

            $total = $transactions->sum('total');
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
                'transactions_details' => $transactions->map(function ($tx) use ($defaultCurrency) {
                    $txPaid = $tx->payments->sum('paid_amount');
                    $displayCurrency = $tx->currency?->currency_name ?? $defaultCurrency?->currency_name ?? 'N/A';
                    return [
                        'id' => $tx->id,
                        'date' => $tx->created_at?->format('d/m/Y, g:i:s A') ?? 'N/A',
                        'student' => $tx->student_name ?? 'N/A',
                        'currency' => $displayCurrency,
                        'total' => number_format($tx->total ?? 0, 2) . ' ' . $displayCurrency,
                        'paid' => number_format($txPaid, 2) . ' ' . $displayCurrency,
                        'remaining' => number_format(($tx->total - $txPaid) ?? 0, 2) . ' ' . $displayCurrency,
                    ];
                }),
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
            'courses' => $coursesData,
        ]);
    }

    // Restore recent transaction
    // Restore recent transaction



    // public function restore(Request $request)
    // {

       
    //     $request->validate([
    //         'transaction_id' => 'required|integer|exists:transactions,id',
    //         'new_paid' => 'required|numeric|min:0',
    //     ]);

    //     $transaction = Transaction::findOrFail($request->transaction_id);

    //     // Check if this transaction is for a teacher
    //     $payment = Payment::where('transaction_id', $transaction->id)
    //         ->where('type', 'teacher')
    //         ->first();

    //     if (!$payment) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'This transaction is not for a teacher.'
    //         ]);
    //     }

    //     // Prevent fully paid
    //     // if ($transaction->paid_amount = $transaction->total) {
    //     //     return response()->json([
    //     //         'success' => false,
    //     //         'message' => 'Transaction already fully paid!'
    //     //     ]);
    //     // }

    //     $payable = $transaction->total - $transaction->paid_amount;
    //     $toPay = min($request->new_paid, $payable);
     
    //     $transaction->paid_amount += $toPay;
    //     $transaction->save();

    //     $remaining = $transaction->total - $transaction->paid_amount;

    //     return response()->json([
    //         'success' => true,
    //         'paid' => $transaction->paid_amount,
    //         'remaining' => $remaining
    //     ]);
    // }

    // public function restorePerCourse(Request $request)
    // {
    
    //     $request->validate([
    //         'transaction_id' => 'required|integer|exists:transactions,id',
    //         'new_paid' => 'required|numeric|min:0',
    //     ]);

    //     $transaction = Transaction::findOrFail($request->transaction_id);

    //     $payment = Payment::where('transaction_id', $transaction->id)
    //         ->where('type', 'teacher')
    //         ->first();

    //     if (!$payment) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'This transaction is not for a teacher.'
    //         ]);
    //     }

    //     // if ($transaction->paid_amount = $transaction->total) {
    //     //     return response()->json([
    //     //         'success' => false,
    //     //         'message' => 'Transaction already fully paid!'
    //     //     ]);
    //     // }

    //     $payable = $transaction->total - $transaction->paid_amount;
    //     $toPay = min($request->new_paid, $payable);

    //     $transaction->paid_amount += $toPay;
    //     $transaction->save();

    //     $remaining = $transaction->total - $transaction->paid_amount;

    //     return response()->json([
    //         'success' => true,
    //         'paid' => $transaction->paid_amount,
    //         'remaining' => $remaining
    //     ]);
    // }
 public function restore(Request $request)
    {
        \Log::info('Restore called', $request->all());

        // Validate input
        $validated = $request->validate([
            'transaction_id' => 'required|integer|exists:transactions,id',
            'new_paid' => 'required|numeric|min:0',
        ]);

        try {
            // Find transaction
            $transaction = Transaction::findOrFail($validated['transaction_id']);

            // Verify this is a teacher transaction
            $payment = Payment::where('transaction_id', $transaction->id)
                ->where('type', 'teacher')
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
                'type' => 'teacher',
                'paid_amount' => $toPay,
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
     * Restore per-course transaction payment
     */
    public function restorePerCourse(Request $request)
    {
        \Log::info('RestorePerCourse called', $request->all());

        // Validate input
        $validated = $request->validate([
            'transaction_id' => 'required|integer|exists:transactions,id',
            'new_paid' => 'required|numeric|min:0',
        ]);

        try {
            // Find transaction
            $transaction = Transaction::findOrFail($validated['transaction_id']);

            // Verify this is a teacher transaction
            $payment = Payment::where('transaction_id', $transaction->id)
                ->where('type', 'teacher')
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
                'type' => 'teacher',
                'paid_amount' => $toPay,
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
}
