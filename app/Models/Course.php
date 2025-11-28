<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TeacherCourse;
use App\Models\Taxonomies_educational_systems;
use App\Models\Taxonomies_subjects;
use App\Models\Taxonomies_examination_boards;
use App\Models\Transaction;

class Course extends Model
{
    protected $fillable = ['course_title', 'edu_system_id', 'exam_board_id', 'subject_id'];
    protected $table = 'acc_courses';

    public function teacherCourses()
    {
        return $this->hasMany(TeacherCourse::class, 'course_id');
    }

    public function eduSystem()
    {
        return $this->belongsTo(Taxonomies_educational_systems::class, 'edu_system_id')->withDefault();
    }

    public function subject()
    {
        return $this->belongsTo(Taxonomies_subjects::class, 'subject_id')->withDefault();
    }

    public function examBoard()
    {
        return $this->belongsTo(Taxonomies_examination_boards::class, 'exam_board_id')->withDefault();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'course_id');
    }
}
