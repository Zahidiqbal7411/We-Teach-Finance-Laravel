<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['teacher_name', 'teacher_contact', 'teacher_email', 'teacher_other_info'];

}
