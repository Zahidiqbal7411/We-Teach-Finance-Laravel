<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
   protected $fillable = ['currency_name'];
   public function transactions(){
      return $this->hasMany(Transaction::class , 'selected_currency');
   }
}
