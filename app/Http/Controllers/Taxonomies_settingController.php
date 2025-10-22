<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Taxonomies_settingController extends Controller
{
    public function create(){
        return view('teacher_setting.index');
    }
}
