<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherCourse extends Model
{
  public function teacher()
{
    return $this->belongsTo(Teacher::class, 'teacher_id');
}

public function course()
{
    return $this->belongsTo(Course::class, 'course_id');
}

}
