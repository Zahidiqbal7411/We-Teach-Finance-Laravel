<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Course;

class TeacherCourse extends Model
{
    protected $fillable = ['course_id', 'teacher_id', 'teacher_percentage'];
    protected $table = 'acc_teacher_courses';

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id')->withDefault();
    }
}
