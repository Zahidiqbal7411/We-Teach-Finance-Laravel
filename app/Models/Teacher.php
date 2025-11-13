<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['teacher_name', 'teacher_contact', 'teacher_email', 'teacher_other_info'];

    public function courses()
    {
        return $this->belongsToMany(
            Course::class,
            'teacher_courses', // pivot table
            'teacher_id',      // foreign key on pivot table
            'course_id'        // related key
        )->withPivot('teacher_percentage');
    }

    // Pivot entries (teacher_courses) as a relation so controllers can eager-load
    // pivot rows (with their ID and teacher_percentage) and the related course.
    public function teacherCourses()
    {
        return $this->hasMany(TeacherCourse::class, 'teacher_id');
    }


 public function transactions()
{
    return $this->hasMany(Transaction::class);
}
public function payments()
{
    return $this->hasMany(Payment::class);
}
}
