<?php

namespace App\Http\Controllers;
use App\Models\Teacher;

use Illuminate\Http\Request;

class Teacher_settingController extends Controller
{
    public function create(){
        return view("teacher_setting.index");
    }




public function store_teacher(Request $request){
    $validated = $request->validate([
        'teacherName' => 'required|string|max:255',
        'teacherContact' => 'required|string|max:255',
        'teacherEmail' => 'required|string|max:255',
        'teacherOtherinfo' => 'nullable|string|max:255',
    ]);

    Teacher::create([
        'teacher_name' => $validated['teacherName'],
        'teacher_contact' => $validated['teacherContact'],
        'teacher_email' => $validated['teacherEmail'],
        'teacher_other_info' => $validated['teacherOtherinfo'] ?? null,
    ]);

     return response()->json([
            'success' => true,
              // ✅ IMPORTANT FIELD
        ]);

}

// public function index_teacher(Request $request){
//     $teacher_datas = Teacher::all();
//     return view('settings.index', compact('teacher_datas'));
// }
public function index_teacher(Request $request)
{
    $teacher_datas = Teacher::all();

    return response()->json([
        'success' => true,
        'data' => $teacher_datas
    ]);
}


}

