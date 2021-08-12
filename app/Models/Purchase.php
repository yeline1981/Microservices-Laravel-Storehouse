<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchases';

    protected $fillable = ['ingredient_id', 'units'];

    protected $hidden = ['created_at', 'updated_at'];
}
