<?php

namespace App\Http\Controllers;

use App\Models\Taxonomies_educational_systems;
use App\Models\Taxonomies_sessions;
use Illuminate\Http\Request;

class Taxonomies_settingController extends Controller
{
    public function create(){
        return view('teacher_setting.index');
    }


//    public function store_educational_systems(Request $request) {

//     $educational_data = $request->validate([
//         'educational_title' => 'required|string|max:255',
//     ]);

    
//     Taxonomies_educational_systems::create([
//         'educational_title' => $educational_data['eduInput'],
//     ]);

    
//     return redirect()->route('settings.index')->with('success', true);
// }
// public function store_educational_systems(Request $request) {

//     $educational_data = $request->validate([
//         'eduInput' => 'required|string|max:255',
//     ]);

//     Taxonomies_educational_systems::create([
//         'educational_title' => $educational_data['eduInput'],
//     ]);

//     // For AJAX, return JSON instead of redirect
//     if ($request->ajax()) {
//         return response()->json(['success' => true, 'title' => $educational_data['eduInput']]);
//     }
// return view('settings.index' ,['#eduList'])->with('success', true);


// }
public function store_educational_systems(Request $request) {

    $educational_data = $request->validate([
        'eduInput' => 'required|string|max:255',
    ]);

    $newItem = Taxonomies_educational_systems::create([
        'educational_title' => $educational_data['eduInput'],
    ]);

    // Return JSON for AJAX
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'id' => $newItem->id,            // return id for safer referencing
            'title' => $newItem->educational_title
        ]);
    }

    return view('settings.index')->with('success', true);
}


public function index_educational_systems(Request $request) {

 $educational_results = taxonomies_educational_systems::all();
 return response()->json($educational_results);
}



public function delete_educational_systems($title)
{
   
    // $item = Taxonomies_educational_systems::where('educational_title', $title)->first();
    $item = Taxonomies_educational_systems::whereRaw('TRIM(LOWER(educational_title)) = ?', [strtolower(trim($title))])->first();


    if($item){
        $item->delete();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false]);
}



    public function store_subjects()
    {

    }


    public function store_examination_boards()
    {

    }



    public function store_sessions()
    {


    }  


   


}
