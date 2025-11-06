<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


// {
//     protected $fillable = [
//         'teacher_id',
//         'course_id',
//         'session_id',
//         'student_name',
//         'parent_name',
//         'total',
//         'paid_amount',
      
//     ];
//     public function payments()
// {
//     return $this->hasMany(Payment::class, 'transaction_id');
// }

//    public function course()
// {
//     return $this->belongsTo(Course::class, 'course_id');
// }
//    public function session()
// {
//     return $this->belongsTo(Taxonomies_sessions::class, 'session_id');
    
// }
//    public function teacher()
// {
//     return $this->belongsTo(Teacher::class, 'teacher_id');
// }
// }
class Transaction extends Model
{
    protected $fillable = [
        'teacher_id', 'course_id', 'session_id',
        'student_name', 'parent_name', 'total', 'paid_amount'
    ];

    public function teacher() {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function course() {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function session() {
        return $this->belongsTo(Taxonomies_sessions::class, 'session_id');
    }

    public function payments() {
        return $this->hasMany(Payment::class, 'transaction_id');
    }
}
