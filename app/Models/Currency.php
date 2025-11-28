<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'currency_name',
        'exchange_rate',
    ];
    protected $table = 'acc_currencies';

    // Relationship with Transaction model
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'selected_currency', 'id');
    }

    // Relationship with TransactionPayout model
    public function transactionPayouts()
    {
        return $this->hasMany(TransactionPayout::class, 'selected_currency', 'id');
    }
}
