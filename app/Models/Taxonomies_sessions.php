<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxonomies_sessions extends Model
{
    protected $fillable = ['session_title'];
    protected $table = 'acc_taxonomies_sessions';

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'session_id');
    }
    public function transactionPayouts()
    {
        return $this->hasMany(TransactionPayout::class, 'session_id');
    }
}
