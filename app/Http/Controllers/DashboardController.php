<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Currency;
use App\Models\Setting;
use App\Models\Taxonomies_sessions;
use App\Models\Teacher;
use App\Models\Payment;
use App\Models\TeacherCourse;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get saved currency
        $currency_data = Setting::find(6);
        $selected_currency_id = $currency_data ? intval($currency_data->value) : null;
        $selectedCurrency = Currency::find($selected_currency_id);

        // Load dropdown data
        $sessions = Taxonomies_sessions::all();
        $currencies = Currency::all();

        return view("dashboard.index", get_defined_vars());
    }

    public function update_currency(Request $request)
    {
        $currencyId = $request->currency_id;

        // Validate currency
        $currency = Currency::find($currencyId);
        if (!$currency) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid currency ID'
            ], 400);
        }

        // Update setting (type = default_currency)
        $setting = Setting::where('type', 'default_currency')->first();

        if ($setting) {
            $setting->value = $currencyId;
            $setting->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Currency updated successfully',
                'currency' => $currency->currency_name
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Setting not found'
        ], 404);
    }

    public function update_session(Request $request)
    {
        $sessionId = $request->session_id;
        $currencyId = $request->currency_id;

        // Get selected currency
        $currency_data = Setting::find(6);
        $selected_currency_id = $currency_data
            ? intval($currency_data->value)
            : $currencyId;

        $selectedCurrency = Currency::find($selected_currency_id);

        // ---------------------------
        // DASHBOARD CALCULATIONS
        // ---------------------------

        // Today's inflow
        $today_inflow = Payment::whereHas('transaction', function ($query) use ($sessionId, $selected_currency_id) {
            $query->where('session_id', $sessionId)
                  ->where('selected_currency', $selected_currency_id);
        })
        ->whereDate('created_at', Carbon::today())
        ->sum('paid_amount');

        // MTD inflow
        $mtd_inflow = Transaction::where('session_id', $sessionId)
            ->where('selected_currency', $selected_currency_id)
            ->whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()
            ])
            ->sum('total');

        // Teacher payouts (MTD)
        $mtd_teacher_payouts = Payment::where('type', 'teacher')
            ->whereHas('transaction', function ($query) use ($sessionId, $selected_currency_id) {
                $query->where('session_id', $sessionId)
                      ->where('selected_currency', $selected_currency_id);
            })
            ->whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()
            ])
            ->sum('paid_amount');

        // Total teacher amount
        $total_teacher_amount = Transaction::where('session_id', $sessionId)
            ->where('selected_currency', $selected_currency_id)
            ->whereHas('payments', function ($q) {
                $q->where('type', 'teacher');
            })
            ->sum('teacher_amount');

        // Paid teacher amount
        $paid_teacher_amount = Payment::where('type', 'teacher')
            ->whereHas('transaction', function ($q) use ($sessionId, $selected_currency_id) {
                $q->where('session_id', $sessionId)
                  ->where('selected_currency', $selected_currency_id);
            })
            ->sum('paid_amount');

        // Pending
        $pending_teacher_balance = $total_teacher_amount - $paid_teacher_amount;

        return response()->json([
            'status' => 'success',
            'today_inflow' => $today_inflow,
            'mtd_inflow' => $mtd_inflow,
            'mtd_teacher_payouts' => $mtd_teacher_payouts,
            'pending_teacher_balance' => $pending_teacher_balance,
            'selected_currency' => $selectedCurrency ? $selectedCurrency->currency_name : null
        ]);
    }
}
