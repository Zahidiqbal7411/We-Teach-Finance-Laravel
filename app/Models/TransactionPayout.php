<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionPayout extends Model
{
    protected $table = 'acc_transaction_payouts';

    protected $fillable = [
        'transaction_id',
        'selected_currency',
        'session_id',
        'course_id',
        'teacher_id',
        'paid_amount',
        'type',
        'remarks',
        'created_at',
        'updated_at'
    ];

    // Relation to Transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    // Relation to Currency
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'selected_currency');
    }

    // Relation to Session
    public function session()
    {
        return $this->belongsTo(Taxonomies_sessions::class, 'session_id');
    }

    // Relation to Teacher (if you have a Teacher model)
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
