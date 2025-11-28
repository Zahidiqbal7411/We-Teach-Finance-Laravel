<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TeacherCourse;
use App\Models\Payment;
use App\Models\Transaction;

class Teacher extends Model
{
    protected $fillable = ['teacher_name', 'teacher_contact', 'teacher_email', 'teacher_other_info'];
    protected $table = 'acc_teachers';
    public function courses()
    {
        return $this->hasMany(TeacherCourse::class, 'teacher_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'teacher_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'teacher_id');
    }
}
