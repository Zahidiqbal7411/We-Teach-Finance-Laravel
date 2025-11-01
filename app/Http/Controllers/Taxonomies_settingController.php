<?php

namespace App\Http\Controllers;

use App\Models\Taxonomies_educational_systems;
use App\Models\Taxonomies_examination_boards;
use App\Models\Taxonomies_sessions;
use App\Models\Taxonomies_subjects;
use App\Models\Course;
use Illuminate\Http\Request;

class Taxonomies_settingController extends Controller
{
//  public function create()
//     {
//         return view("taxonomies_setting.index");
//     } 


    public function store_educational_systems(Request $request)
    {
        $validated = $request->validate([
            'eduInput' => 'required|string|max:255',
        ]);

        $educational_results = Taxonomies_educational_systems::create([
            'educational_title' => $validated['eduInput'],
        ]);

        // ✅ Force JSON always — no view return
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'id' => $educational_results->id,
                'title' => $educational_results->educational_title
            ]);
        }

        return response()->json(['success' => true]); // fallback
    }




    public function index_educational_systems(Request $request)
    {
        // Only fetch required fields for efficiency
        $educational_result = Taxonomies_educational_systems::select('id', 'educational_title')->get();

        // Return as JSON for AJAX
        return response()->json($educational_result);
    }


    public function delete_educational_systems(Request $request, $id)
    {

        $item = Taxonomies_educational_systems::where('id', $id)->first();



        if ($item) {
            $item->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }



    public function store_subjects(Request $request)
    {


        $validated = $request->validate(
            [
                'subjectInput' => 'required|string|max:255'
            ]
        );

        $subject_data = Taxonomies_subjects::create([
            'subject_title' => $validated['subjectInput'],
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'id' => $subject_data->id,
                'title' => $subject_data->subject_title,
            ]);
        }
    }

    public function index_subjects(Request $request)
    {
        $subject_result = Taxonomies_subjects::select('id', 'subject_title')->get();
        return response()->json($subject_result);
    }
    public function delete_subjects(Request $request, $id)
    {

        $subject_item = Taxonomies_subjects::where('id', $id)->first();
        if ($subject_item) {
            $subject_item->delete();
            return response()->json(['success' => true]);
        }
    }






    public function store_examination_board(Request $request)
    {
        $validated = $request->validate([
            'boardInput' => 'required|string|max:255',
        ]);

        // ✅ Use correct model name and correct field name
        $board = Taxonomies_examination_boards::create([
            'examination_board_title' => $validated['boardInput'],
        ]);

        return response()->json([
            'success' => true,
            'id' => $board->id,
            'title' => $board->examination_board_title,
        ]);
    }

    public function index_examination_board()
    {
        // ✅ Fix incorrect chaining
        $boards = Taxonomies_examination_boards::select('id', 'examination_board_title')->get();
        return response()->json($boards);
    }

    public function delete_examination_board($id)
    {
        // ✅ Use correct model name
        $board = Taxonomies_examination_boards::find($id);
        if ($board) {
            $board->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function store_sessions(Request $request)
    {
        $validated = $request->validate([
            'sessionList' => 'required|string|max:255',
        ]);

        // ✅ Use correct model & field
        $session = Taxonomies_sessions::create([
            'session_title' => $validated['sessionList'],
        ]);

        return response()->json([
            'success' => true,
            'id' => $session->id,
            'title' => $session->session_title,
        ]);
    }

    public function index_sessions()
    {
        $sessions = Taxonomies_sessions::select('id', 'session_title')->get();
        return response()->json($sessions);
    }

    public function delete_sessions($id)
    {
        $session = Taxonomies_sessions::find($id);
        if ($session) {
            $session->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }


public function store_course(Request $request)
{
    $request->validate([
        'course_title'   => 'required|string|max:255',
        'edu_system_id'  => 'required|exists:taxonomies_educational_systems,id',
        'subject_id'     => 'required|exists:taxonomies_subjects,id',
        'exam_board_id'  => 'required|exists:taxonomies_examination_boards,id',
    ]);

    Course::create([
        'course_title'  => $request->course_title,
        'edu_system_id' => $request->edu_system_id,
        'subject_id'    => $request->subject_id,
        'exam_board_id' => $request->exam_board_id,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Course added successfully ✅'
    ]);
}
 public function index()
    {
        $courses = Course::with(['eduSystem', 'subject', 'examBoard'])->get();

        $data = $courses->map(function($course) {
            return [
                'id' => $course->id,
                'course_title' => $course->course_title,
                'edu_system_title' => $course->eduSystem->educational_title ?? 'N/A',
                'subject_title' => $course->subject->subject_title ?? 'N/A',
                'exam_board_title' => $course->examBoard->examination_board_title ?? 'N/A',
            ];
        });

        return response()->json($data);
    }

    // 🔹 Delete a course
    public function destroy($id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found'
            ], 404);
        }

        $course->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully'
        ]);
    }

}
