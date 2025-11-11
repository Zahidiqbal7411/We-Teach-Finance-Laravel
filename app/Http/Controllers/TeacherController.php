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

        // ✅ Find teacher
        $teacher = Teacher::find($teacherId);
        if (!$teacher) {
            return response()->json(['error' => 'Teacher not found'], 404);
        }

        // ✅ Get teacher courses with filtered transactions
        $courses = $teacher->courses()
            ->with(['transactions' => function ($query) use ($sessionId, $currencyId) {
                $query->with(['session', 'currency'])
                    ->whereHas('payments', function ($q) {
                        $q->where('type', 'teacher'); // Only include transactions where teacher is paid
                    });

                if ($sessionId) {
                    $query->where('session_id', $sessionId);
                }

                if ($currencyId) {
                    $query->where('selected_currency', $currencyId);
                }
            }])
            ->get();

        // ✅ Compute totals per course
        $coursesData = $courses->map(function ($course) {
            $transactions = $course->transactions;

            $total = $transactions->sum('total');
            $paid = $transactions->sum('paid_amount');
            $remaining = $transactions->sum(fn($tx) => $tx->total - $tx->paid_amount);

            return [
                'id' => $course->id,
                'name' => $course->course_title ?? 'N/A',
                'session' => $transactions->first()?->session?->session_title ?? 'N/A',
                'transactions' => $transactions->count(),
                'total_amount' => number_format($total, 2),
                'total_paid' => number_format($paid, 2),
                'total_remaining' => number_format($remaining, 2),
                'transactions_details' => $transactions->map(function ($tx) {
                    return [
                        'id' => $tx->id,
                        'date' => $tx->created_at?->format('d/m/Y, g:i:s A') ?? 'N/A',
                        'student' => $tx->student_name ?? 'N/A',
                        'currency' => $tx->currency?->currency_name ?? 'N/A',
                        'total' => number_format($tx->total ?? 0, 2),
                        'paid' => number_format($tx->paid_amount ?? 0, 2),
                        'remaining' => number_format(($tx->total - $tx->paid_amount) ?? 0, 2),
                    ];
                }),
            ];
        });

        // ✅ Return clean JSON
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
}
