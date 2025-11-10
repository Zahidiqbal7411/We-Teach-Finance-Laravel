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
        // Use find() for numeric ID or findByUuid() / where('id', $id) for string IDs
        $teacher = Teacher::with('transactions')->where('id', $id)->first();

        if (!$teacher) {
            return response()->json(['error' => 'Teacher not found'], 404);
        }

        return response()->json([
            'id' => $teacher->id,
            'name' => $teacher->teacher_name,
            'email' => $teacher->teacher_email,
            'current_balance' => 'LE ' . number_format($teacher->current_balance, 2),
            'total_paid' => 'LE ' . number_format($teacher->total_paid, 2),
            'total_earned' => 'LE ' . number_format($teacher->total_earned, 2),
            'transactions' => $teacher->transactions->map(function ($tx) {
                return [
                    'id' => $tx->id,
                    'date' => $tx->created_at->format('d/m/Y, h:i:s A'),
                    'course' => $tx->course_name,
                    'session' => $tx->session_name,
                    'student' => $tx->student_name,
                    'parent' => $tx->parent_name,
                    'total' => 'LE ' . $tx->total_amount,
                    'paid' => 'LE ' . $tx->paid_amount,
                    'remaining' => 'LE ' . $tx->remaining_amount,
                ];
            }),
        ]);
    }
}
