<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Taxonomies_educational_systems;
use App\Models\Taxonomies_examination_boards;
use App\Models\Taxonomies_sessions;
use App\Models\Taxonomies_subjects;
use App\Models\Currency;
use App\Models\Setting;

class SettingController extends Controller
{
    public function create()
    {
        $course_edu_system_datas = Taxonomies_educational_systems::all();
        $course_exam_board_datas = Taxonomies_examination_boards::all();
        $course_subject_datas = Taxonomies_subjects::all();
        $currency_datas = Currency::all();
        $sessions_datas = Taxonomies_sessions::all();

        // Get the default selected currency from settings
        $default_currency_id = Setting::find(6)->value ?? null;

        return view('settings.index', compact(
            'course_edu_system_datas',
            'course_exam_board_datas',
            'course_subject_datas',
            'currency_datas',
            'sessions_datas',
            'default_currency_id'
        ));
    }

}
