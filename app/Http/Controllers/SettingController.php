<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function create()
    {
        return view("settings.index");
    }


    public function edit($id) {}




    public function security_update(Request $request, $id)
    {
        $admin_data = Setting::findOrFail($id);
        $admin_data->value = $request->admin;
        $admin_data->update();

        $session_data = Setting::where('type', 'session_timeout')->first();
        if ($session_data) {
            $session_data->value = $request->session_timeout;
            $session_data->update();
        }

        return response()->json(['success' => true]);
    }



    public function currency_update(Request $request, $id)
    {

        $currency_data = Setting::findOrFail($id);

        $selected_currency = Setting::firstOrCreate(['type' => 'selected_currency']);


        $selected_currency->value = $request->default_currency;
        $selected_currency->update();


        return response()->json(['success' => true]);
    }


    public function notification_settings_update(Request $request)
    {
        try {

            $validated = $request->validate([
                'email_notification' => 'nullable',
                'payment_alert' => 'nullable',
                'low_balance_warning' => 'nullable',
            ]);


            $updates = [
                'email_notification' => $request->has('email_notification') ? '1' : '0',
                'payment_alert' => $request->has('payment_alert') ? '1' : '0',
                'low_balance_warning' => $request->has('low_balance_warning') ? '1' : '0',
            ];

            foreach ($updates as $type => $value) {
                $setting = Setting::where('type', $type)->first();
                if ($setting) {
                    $setting->value = $value;
                    $setting->save();
                } else {

                    Setting::create(['type' => $type, 'value' => $value]);
                }
            }

            return response()->json(['success' => true, 'message' => 'Notification settings updated.']);
        } catch (\Illuminate\Validation\ValidationException $ve) {

            return response()->json([
                'message' => 'Validation failed',
                'errors' => $ve->errors()
            ], 422);
        } catch (\Exception $e) {

            \Log::error('notification update error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
}
