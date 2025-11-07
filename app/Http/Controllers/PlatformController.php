<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Currency;
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
        $session_datas = Taxonomies_sessions::all();
        $currency_datas = Currency::all();
        $currentCurrency = Currency::find(Setting::find(6)?->value);


        // Prepare currency options

        // Pass to view
        return view('platform.index', get_defined_vars());
    }








    public function platform_transaction_store(Request $request)
    {
        // Debug: Log all incoming data
        \Log::info('Transaction Store Attempt:', [
            'request_data' => $request->all(),
            'method' => $request->method(),
            'url' => $request->url()
        ]);

        try {
            // Validate request
            $validated = $request->validate([
                'teacher'       => 'required|exists:teachers,id',
                'course'        => 'required|exists:courses,id',
                'session'       => 'required|exists:taxonomies_sessions,id',
                'student_name'  => 'required|string|max:255',
                'parent_name'   => 'nullable|string|max:255',
                'total'         => 'required|numeric|min:0',
                'paid_amount'   => 'required|numeric|min:0',
                'selected_currency_id' => 'required|exists:currencies,id',
            ]);

            \Log::info('Validation passed');

            // Create transaction
            $transaction = Transaction::create([
                'teacher_id'    => $validated['teacher'],
                'course_id'     => $validated['course'],
                'session_id'    => $validated['session'],
                'student_name'  => $validated['student_name'],
                'parent_name'   => $validated['parent_name'] ?? null,
                'total'         => $validated['total'],
                'paid_amount'   => $validated['paid_amount'],
                'selected_currency' => $validated['selected_currency_id'],
            ]);

            \Log::info('Transaction created with ID: ' . $transaction->id);

            // Create payment
            $payment = $transaction->payments()->create([
                'paid_amount' => $validated['paid_amount'],
            ]);

            \Log::info('Payment created with ID: ' . $payment->id);

            // Load relationships for display
            $transaction->load('teacher', 'course', 'session');

            $response = [
                'status' => 'success',
                'message' => 'Transaction & payment saved successfully',
                'transaction' => [
                    'id' => $transaction->id,
                    'teacher' => $transaction->teacher->teacher_name ?? '',
                    'course' => $transaction->course->course_title ?? '',
                    'session' => $transaction->session->session_title ?? '',
                    'student_name' => $transaction->student_name,
                    'parent_name' => $transaction->parent_name,
                    'total' => $transaction->total,
                    'paid_amount' => $transaction->paid_amount,
                    'remaining' => $transaction->total - $transaction->paid_amount,
                    'selected_currency' => $transaction->currency->currency_name ?? '', // Added
                    'created_at' => $transaction->created_at->format('Y-m-d H:i:s'),
                ]
            ];


            \Log::info('Returning success response');
            return response()->json($response);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Error:', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
                'message' => 'Validation failed'
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Transaction Store Error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

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
        $platform_transaction_datas = Transaction::with(['teacher', 'course', 'session'])
            ->latest()
            ->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Transactions fetched successfully',
            'data'    => $platform_transaction_datas
        ]);
    }



    // public function platform_transaction_modal_store(Request $request, $transactionId)
    // {
    //     $validated = $request->validate([
    //         'new_paid' => 'required|numeric|min:0',
    //     ]);

    //     $transaction = Transaction::find($transactionId);
    //     if (!$transaction) {
    //         return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
    //     }

    //     $newPaid = $validated['new_paid'];
    //     $alreadyPaid = $transaction->paid_amount;
    //     $total = $transaction->total;

    //     if (($alreadyPaid + $newPaid) > $total) {
    //         return response()->json(['status' => 'error', 'message' => 'Paid amount exceeds total transaction amount']);
    //     }

    //     // ✅ Update transactions
    //     $transaction->paid_amount += $newPaid;
    //     $transaction->save();

    //     // ✅ Insert into payments table
    //     Payment::create([
    //         'transaction_id' => $transaction->id,
    //         'paid_amount' => $newPaid,
    //     ]);

    //     // ✅ Return the updated transaction
    //     $transaction = Transaction::with('teacher', 'course', 'session')->find($transactionId);

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Transaction updated and payment recorded successfully',
    //         'data' => $transaction
    //     ]);
    // }

    public function platform_transaction_modal_store(Request $request, $transactionId)
    {
        // ✅ Validate inputs
        $validated = $request->validate([
            'new_paid' => 'required|numeric|min:0',
            'current_currency' => 'nullable|exists:currencies,id',
        ]);

        // ✅ Find transaction
        $transaction = Transaction::find($transactionId);
        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction not found'
            ], 404);
        }

        $newPaid = $validated['new_paid'];
        $alreadyPaid = $transaction->paid_amount;
        $total = $transaction->total;

        // ✅ Prevent overpayment
        if (($alreadyPaid + $newPaid) > $total) {
            return response()->json([
                'status' => 'error',
                'message' => 'Paid amount exceeds total transaction amount'
            ]);
        }

        // ✅ Update transaction
        $transaction->paid_amount += $newPaid;

        // ✅ Optionally update currency
        if (!empty($validated['current_currency'])) {
            $transaction->currency_id = $validated['current_currency'];
        }

        $transaction->save();

        // ✅ Record payment
        Payment::create([
            'transaction_id' => $transaction->id,
            'paid_amount' => $newPaid,
            'currency_id' => $validated['current_currency'] ?? null,
        ]);

        // ✅ Reload with relationships
        $transaction = Transaction::with('teacher', 'course', 'session')->find($transactionId);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction updated and payment recorded successfully',
            'data' => $transaction
        ]);
    }




    public function platform_currency_update(Request $request)
    {
        try {
            $currencyId = $request->input('default_currency');

            if (!$currencyId) {
                return response()->json([
                    'success' => false,
                    'message' => 'No currency selected.'
                ]);
            }

            // ✅ Update only the row with ID = 6
            $setting = Setting::find(6);

            if (!$setting) {
                // Optional: auto-create the record if it doesn’t exist
                $setting = Setting::create([
                    'type' => 'default_currency',
                    'value' => $currencyId,
                ]);
            } else {
                $setting->value = $currencyId;
                $setting->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Default currency updated successfully!'
            ]);
        } catch (\Throwable $e) {
            \Log::error('Currency update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }
}
