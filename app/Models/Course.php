<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['course_title' , 'edu_system_id', 'exam_board_id' ,'subject_id'];

    public function teacherCourses() {
    return $this->hasMany(TeacherCourse::class, 'course_id');
}


    public function eduSystem()
    {
        return $this->belongsTo(Taxonomies_educational_systems::class, 'edu_system_id');
    }

    public function subject()
    {
        return $this->belongsTo(Taxonomies_subjects::class, 'subject_id');
    }

    public function examBoard()
    {
        return $this->belongsTo(Taxonomies_examination_boards::class, 'exam_board_id');
    }
}


