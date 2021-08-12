<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreHouse extends Model
{
    protected $table = 'storehouse';

    protected $fillable = ['ingredient', 'units'];

    protected $hidden = ['created_at', 'updated_at'];
}
