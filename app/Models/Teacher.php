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


 public function transactions()
{
    return $this->hasMany(Transaction::class);
}
public function payments()
{
    return $this->hasMany(Payment::class);
}
}
