<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['transaction_id', 'paid_amount','type' ,'teacher_id'];

    public function transaction() {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
