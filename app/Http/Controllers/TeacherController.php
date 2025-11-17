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
use App\Models\TeacherCourse;

class TeacherController extends Controller
{
    public function create(){
        return view('teacher.index');
    }
}
