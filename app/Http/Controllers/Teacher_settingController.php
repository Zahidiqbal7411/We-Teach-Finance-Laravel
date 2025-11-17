<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TeacherCourse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Teacher_settingController extends Controller
{
    public function create()
    {
        return view("teacher_setting.index");
    }




    public function store_teacher(Request $request)
    {
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



    public function index_teacher(Request $request)
    {
        $teachers = Teacher::with(['courses.course.subject'])->get();

        return response()->json([
            'success' => true,
            'data' => $teachers
        ]);
    }








    // public function teacher_course_store(Request $request)
    // {
    //     try {
    //         $validated = $request->validate([
    //             'teacherId' => 'required|unique:teacher_courses,teacher_id,NULL,id,course_id,' . $request->courseId,
    //             'courseId' => 'required|unique:teacher_courses,course_id,NULL,id,teacher_id,' . $request->teacherId,
    //             'teacherPercentage' => 'required'
    //         ]);
    //     } catch (ValidationException $e) {
    //         // Return JSON response on validation failure
    //         return response()->json([
    //             'success' => false,
    //             'errors' => $e->errors()
    //         ], 422);
    //     }

    //     TeacherCourse::create([
    //         'teacher_id' => $validated['teacherId'],
    //         'course_id' => $validated['courseId'],
    //         'teacher_percentage' => $validated['teacherPercentage'],
    //     ]);

    //     return response()->json(['success' => true]);
    // }

    public function teacher_course_delete($id)
    {
        try {
            $teacherCourse = TeacherCourse::findOrFail($id); // find the pivot record by ID
            $teacherCourse->delete(); // delete from DB

            return response()->json([
                'success' => true,
                'message' => 'Course assignment deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete course assignment'
            ], 500);
        }
    }


    public function teacher_course_store(Request $request)
    {
        try {
            $validated = $request->validate([
                'teacherId' => 'required', // no uniqueness here
                'courseId' => 'required|unique:teacher_courses,course_id,NULL,id,teacher_id,' . $request->teacherId,
                'teacherPercentage' => 'required'
            ]);
        } catch (ValidationException $e) {
            // Customize the message for course duplication
            $errors = $e->errors();

            if (isset($errors['courseId'])) {
                $errors['courseId'] = ['This course is already assigned to this teacher.'];
            }

            return response()->json([
                'success' => false,
                'errors' => $errors
            ], 422);
        }

        TeacherCourse::create([
            'teacher_id' => $validated['teacherId'],
            'course_id' => $validated['courseId'],
            'teacher_percentage' => $validated['teacherPercentage'],
        ]);

        return response()->json(['success' => true]);
    }
}
