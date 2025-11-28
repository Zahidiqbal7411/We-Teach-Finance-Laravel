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
    try {
        $teachers = Teacher::with([
            'courses.course.subject',
            'courses.course.examBoard',
            'courses.course.eduSystem'
        ])->get();

        // Filter out teacherCourses with missing courses
        $teachers->each(function($teacher) {
            $teacher->courses = $teacher->courses->filter(fn($tc) => $tc->course != null)->values();
        });

        return response()->json([
            'success' => true,
            'data' => $teachers
        ]);
    } catch (\Exception $e) {
        \Log::error('Failed to load teachers: '.$e->getMessage());

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ], 500);
    }
}


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
                'teacherId' => 'required',
                'courseId' => 'required|unique:teacher_courses,course_id,NULL,id,teacher_id,' . $request->teacherId,
                'teacherPercentage' => 'required'
            ]);
        } catch (ValidationException $e) {

            $errors = $e->errors();

            if (isset($errors['courseId'])) {
                $errors['courseId'] = ['This course is already assigned to this teacher.'];
            }

            return response()->json([
                'success' => false,
                'errors' => $errors
            ], 422);
        }

        // Create new record
        $teacherCourse = TeacherCourse::create([
            'teacher_id' => $validated['teacherId'],
            'course_id' => $validated['courseId'],
            'teacher_percentage' => $validated['teacherPercentage'],
        ]);

        // Load relations (teacher + course + subject)
        $teacherCourse->load([
            'teacher:id,teacher_name',
            'course:id,course_title,subject_id',
            'course.subject:id,subject_title'
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $teacherCourse->id,
                'teacher_name' => $teacherCourse->teacher->teacher_name,
                'course_title' => $teacherCourse->course->course_title,
                'subject_title' => $teacherCourse->course->subject->subject_title ?? 'N/A',
                'teacher_percentage' => $teacherCourse->teacher_percentage,
                'platform_percentage' => 100 - $teacherCourse->teacher_percentage,
            ]
        ]);
    }
}
