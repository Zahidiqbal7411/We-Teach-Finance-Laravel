<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpressCourse;
use App\Models\Transaction;

class Express_courseController extends Controller
{
  public function create(){
    return view('express_course.index');
  }
  
   public function index()
{
    try {
        $transactions = Transaction::whereNotNull('express_course_id')
            ->with('expressCourse')
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

}
