<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['course_title' , 'edu_system_id', 'exam_board_id' ,'subject_id'];

    // Relation to pivot table TeacherCourse
     public function teachers()
    {
        return $this->belongsToMany(
            Teacher::class,
            'teacher_courses',
            'course_id',
            'teacher_id'
        )->withPivot('teacher_percentage');
    }

    // Relation to transactions
    public function transactions() {
        return $this->hasMany(Transaction::class, 'course_id');
    }

    // Optional: relation to teacher through pivot table
    

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
