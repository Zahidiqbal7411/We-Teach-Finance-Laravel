<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Taxonomies_educational_systems;
use App\Models\Taxonomies_examination_boards;
use App\Models\Taxonomies_sessions;
use App\Models\Currency;
use App\Models\Taxonomies_subjects;

class SettingController extends Controller
{
  public function create()
    {
       $course_edu_system_datas=Taxonomies_educational_systems::all();
        $course_exam_board_datas=Taxonomies_examination_boards::all();
        $course_subject_datas=Taxonomies_subjects::all();
         $currency_datas = Currency::all();
        ;
        
        
        
        return view('settings.index' , get_defined_vars());
    }  
}
