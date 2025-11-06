<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Setting;
use Illuminate\Http\Request;

class System_settingController extends Controller
{
    public function create()
    {
        return view('layouts.app');
    }



    public function edit($id) {}




    public function security_update(Request $request, $id)
    {
        // Update admin PIN
        $admin_data = Setting::findOrFail($id);
        $admin_data->value = $request->admin;
        $admin_data->update();

        // Update session timeout separately
        $session_data = Setting::where('type', 'session_timeout')->first();
        if ($session_data) {
            $session_data->value = $request->session_timeout;
            $session_data->update();
        }

        return response()->json(['message' => 'Security settings updated successfully.']);
    }




    public function currency_update(Request $request)
    {
        $id = $request->input('default_currency'); // Get the selected currency ID

        // Reset all currencies
        Currency::query()->update(['selected_currency' => 0]);

        // Set the selected currency
        Currency::where('id', $id)->update(['selected_currency' => 1]);

        return response()->json([
            'success' => true,
            'message' => 'Default currency updated successfully!',
        ]);
    }



    public function notification_settings_update(Request $request)
    {
        try {
            // ✅ Define checkbox updates
            $updates = [
                'email_notification' => $request->has('email_notification') ? '1' : '0',
                'payment_alert' => $request->has('payment_alert') ? '1' : '0',
                'low_balance_warning' => $request->has('low_balance_warning') ? '1' : '0',
            ];

            foreach ($updates as $type => $value) {
                // ✅ Update existing or create new
                Setting::updateOrCreate(
                    ['type' => $type],      // condition
                    ['value' => $value]      // values to update
                );
            }

            return response()->json(['success' => true, 'message' => 'Notification settings updated successfully.']);
        } catch (\Exception $e) {
            \Log::error('Notification update error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
}
