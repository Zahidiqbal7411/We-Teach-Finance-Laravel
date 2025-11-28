<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'acc_transactions';

    protected $fillable = [
        'teacher_id',
        'course_id',
        'session_id',
        'student_name',
        'parent_name',
        'student_contact',
        'student_email',
        'course_fee',
        'note_fee',
        'total',
        'paid_amount',
        'selected_currency',
        'teacher_amount',
        'platform_amount',
        'express_course_id',
    ];

    // -----------------------------
    // RELATIONSHIPS
    // -----------------------------

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function session()
    {
        return $this->belongsTo(Taxonomies_sessions::class, 'session_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'selected_currency', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'transaction_id');
    }

    // Express Course relation
    public function expressCourse()
    {
        return $this->belongsTo(ExpressCourse::class, 'express_course_id', 'id');
    }

    // 🎯 CORRECT EXPRESS PAYMENT RELATION
    public function expressPayments()
    {
        return $this->hasMany(ExpressCoursePayment::class, 'id', 'express_course_id');
    }

    // -----------------------------
    // ACCESSORS
    // -----------------------------

}
