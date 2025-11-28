<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxonomies_examination_boards extends Model
{
    protected $fillable = ['examination_board_title'];
    protected $table = 'acc_taxonomies_examination_boards';
}
