<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Setting;
use App\Models\Taxonomies_sessions; // Make sure class name matches file
use App\Models\Teacher;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Transaction;

class PlatformController extends Controller
{
    public function create()
    {
        // Fetch currency
        $currency_data = Setting::find(3);
        $subject_datas = Course::all();
        $teacher_datas = Teacher::all();
        // Fetch sessions
        $session_datas = Taxonomies_sessions::all(); // safer than get()

        // Prepare currency options
        $currency_options = [];
        if ($currency_data && !empty($currency_data->value)) {
            $clean_value = str_replace(['[', ']'], '', $currency_data->value);
            $currency_options = array_map('trim', explode(',', $clean_value));
        }

        // Pass to view
        return view('platform.index', get_defined_vars());
    }







    // public function platform_transaction_store(Request $request)
    // {


    //     $request->validate([
    //         'teacher'   => 'required|exists:teachers,id',
    //         'course'    => 'required|exists:courses,id',
    //         'session'   => 'required|exists:taxonomies_sessions,id',
    //         'student_name'   => 'required|string|max:255',
    //         'parent_name'    => 'nullable|string|max:255',
    //         'total'     => 'required|numeric|min:0',
    //         'paid_amount'      => 'required|numeric|min:0',

    //     ]);

    //     Transaction::create([
    //         'teacher_id' => $request->teacher,
    //         'course_id'  => $request->course,
    //         'session_id' => $request->session,
    //         'student_name'    => $request->student_name,
    //         'parent_name'     => $request->parent_name,
    //         'total'      => $request->total,
    //         'paid_amount'       => $request->paid_amount,

    //     ]);

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Transaction saved successfully'
    //     ]);
    // }
    public function platform_transaction_store(Request $request)
    {
        $request->validate([
            'teacher'       => 'required|exists:teachers,id',
            'course'        => 'required|exists:courses,id',
            'session'       => 'required|exists:taxonomies_sessions,id',
            'student_name'  => 'required|string|max:255',
            'parent_name'   => 'nullable|string|max:255',
            'total'         => 'required|numeric|min:0',
            'paid_amount'   => 'required|numeric|min:0',
        ]);

        // ✅ Create Transaction
        $transaction = Transaction::create([
            'teacher_id'     => $request->teacher,
            'course_id'      => $request->course,
            'session_id'     => $request->session,
            'student_name'   => $request->student_name,
            'parent_name'    => $request->parent_name,
            'total'          => $request->total,
            'paid_amount'    => $request->paid_amount,

        ]);

        // ✅ Store payment through relationship
        $transaction->payments()->create([
            'paid_amount' => $request->paid_amount,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction & payment saved successfully'
        ]);
    }
    public function platform_transaction_index(Request $request)
    {
        $platform_transaction_datas = Transaction::with(['teacher', 'course', 'session'])
            ->latest()
            ->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Transactions fetched successfully',
            'data'    => $platform_transaction_datas
        ]);
    }
   

public function platform_transaction_modal_store(Request $request, $transactionId)
{
    $validated = $request->validate([
        'new_paid' => 'required|numeric|min:0',
    ]);

    $transaction = Transaction::find($transactionId);
    if (!$transaction) {
        return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
    }

    $newPaid = $validated['new_paid'];
    $alreadyPaid = $transaction->paid_amount;
    $total = $transaction->total;

    if (($alreadyPaid + $newPaid) > $total) {
        return response()->json(['status' => 'error', 'message' => 'Paid amount exceeds total transaction amount']);
    }

    // ✅ Update transactions
    $transaction->paid_amount += $newPaid;
    $transaction->save();

    // ✅ Insert into payments table
    Payment::create([
        'transaction_id' => $transaction->id,
        'paid_amount' => $newPaid,
    ]);

    // ✅ Return the updated transaction
    $transaction = Transaction::with('teacher', 'course', 'session')->find($transactionId);

    return response()->json([
        'status' => 'success',
        'message' => 'Transaction updated and payment recorded successfully',
        'data' => $transaction
    ]);
}

}
