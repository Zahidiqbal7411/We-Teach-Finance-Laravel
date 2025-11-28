<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\ExpressCourse;
use App\Models\ExpressCoursePayment;
use App\Models\Setting;
use App\Models\Taxonomies_sessions;
use App\Models\Teacher;
use App\Models\Transaction;
use App\Models\Payment;

class Express_courseController extends Controller
{
    public function create()
    {

        $currency_data = Setting::find(6);
        $selected_currency_id = $currency_data ? intval($currency_data->value) : null;

        // Fetch related data
        $courses = Course::all();
        $teacher_datas = Teacher::all();
        $session_datas = Taxonomies_sessions::all();
        $currency_datas = Currency::all();
        $selectedCurrency = Currency::find($selected_currency_id);
        $expressCourses = ExpressCourse::with(['payments', 'transactions' => function ($q) {
            $q->latest(); // order transactions if needed
        }])
            ->whereNotNull('origional_price_amount')
            ->where('origional_price_amount', '!=', '')
            ->whereRaw("origional_price_amount REGEXP '^[0-9]+(\.[0-9]+)?$'") // only numbers, optional decimal
            ->get();

        // Add a helper attribute to each course
        $expressCourses->each(function ($course) {
            $course->has_transaction = $course->transactions->isNotEmpty();
        });


        // or ->where('original_price', '!=', '')


        return view('express_course.index', get_defined_vars());
    }

    public function index()
    {
        try {
            $transactions = Transaction::whereNotNull('express_course_id')
                ->whereHas('expressCourse', function ($query) {
                    $query->whereNotNull('origional_price'); // or ->where('original_price', '!=', '')
                })
                ->with(['expressCourse' => function ($query) {
                    $query->whereNotNull('origional_price'); // optional, to only load relevant expressCourses
                }])
                ->with('course')
                ->get();


            return response()->json([
                'status' => 'success',
                'data' => $transactions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }






    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'teacher_id'        => 'required|exists:acc_teachers,id',
            'course'            => 'required|exists:acc_courses,id',
            'session_id'        => 'required|exists:acc_taxonomies_sessions,id',
            'student_name'      => 'required|string|max:255',
            'student_contact'   => 'nullable|string|max:255',
            'student_email'     => 'nullable|email|max:255',
            'parent_name'       => 'nullable|string|max:255',
            'total'             => 'required|numeric|min:0',
            'paid_amount'       => 'required|numeric|min:0',
            'selected_currency_id' => 'required|exists:acc_currencies,id',
            'course_fee'        => 'nullable|numeric|min:0',
            'note_fee'          => 'nullable|numeric|min:0',
            'expressCourse_id'  => 'nullable|exists:jwy_express_courses,id',
            'remarks'           => 'nullable|string|max:255',
            'payment_type'      => 'nullable|string|max:50', // online/manual/card/etc
        ]);

        // Prevent duplicate transaction for express course
        if ($request->expressCourse_id) {
            $existingTransaction = Transaction::where('express_course_id', $request->expressCourse_id)->first();
            if ($existingTransaction) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'A transaction already exists for this express course.'
                ], 422);
            }
        }

        // Fees
        $courseFee = $request->course_fee ?? 0;
        $noteFee   = $request->note_fee ?? 0;
        $total     = $courseFee + $noteFee;

        // Teacher percentage
        $teacherPercentage = Course::find($request->course)
            ->teacherCourses()
            ->where('teacher_id', $request->teacher_id)
            ->first()?->teacher_percentage ?? 0;

        // Amount calculations
        $teacherShareFromCourse = $courseFee * ($teacherPercentage / 100);
        $teacherAmount = $teacherShareFromCourse + $noteFee;
        $platformAmount = $courseFee - $teacherShareFromCourse;

        // Create main transaction
        $transaction = Transaction::create([
            'teacher_id'      => $request->teacher_id,
            'course_id'       => $request->course,
            'session_id'      => $request->session_id,
            'student_name'    => $request->student_name,
            'student_contact' => $request->student_contact ?? null,
            'student_email'   => $request->student_email ?? null,
            'parent_name'     => $request->parent_name ?? null,
            'course_fee'      => $courseFee,
            'note_fee'        => $noteFee,
            'total'           => $total,
            'paid_amount'     => $request->paid_amount,
            'selected_currency' => $request->selected_currency_id,
            'teacher_amount'  => $teacherAmount,
            'platform_amount' => $platformAmount,
            'express_course_id' => $request->expressCourse_id ?? null,
        ]);

        // -------------------------------------------------------------
        // ✅ INSERT PAYMENT INTO acc_transaction_payments
        // -------------------------------------------------------------
        Payment::create([
            'transaction_id' => $transaction->id,
            'teacher_id'     => $request->teacher_id,
            'paid_amount'    => $request->paid_amount,
            'type'           => 'platform',
            'remarks'        => $request->remarks ?? null,
        ]);

        return response()->json([
            'status' => 'success',
            'data'   => $transaction
        ]);
    }
}
