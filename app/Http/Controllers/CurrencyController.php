<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function create()
    {
        return view('currency.index');
    }
    public function index()
    {
        return response()->json([
            "status" => "success",
            "data" => Currency::orderBy('id', 'DESC')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'currency_name' => 'required|string|max:50',
            'exchange_rate' => 'required|numeric',
        ]);

        Currency::create($request->all());

        return response()->json(["status" => "success"]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'currency_name' => 'required|string|max:50',
            'exchange_rate' => 'required|numeric',
        ]);

        Currency::findOrFail($id)->update($request->all());

        return response()->json(["status" => "success"]);
    }

    public function destroy($id)
    {
        Currency::findOrFail($id)->delete();

        return response()->json(["status" => "success"]);
    }
}
