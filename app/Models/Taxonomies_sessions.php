<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxonomies_sessions extends Model
{
   protected $fillable = ['session_title'];
   
   public function transaction(){
      return $this->belongsTo(Transaction::class,'session_id');
   }
   public function transactions() {
    return $this->hasMany(Transaction::class, 'session_id');
}

}
