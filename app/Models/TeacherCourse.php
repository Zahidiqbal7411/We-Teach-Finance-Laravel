<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherCourse extends Model
{
  protected $fillable =['course_id','teacher_id', 'teacher_percentage'];
  
  public function teacher()
{
    return $this->belongsTo(Teacher::class, 'teacher_id');
}

public function course()
{
    return $this->belongsTo(Course::class, 'course_id');
}

}
