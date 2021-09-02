<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchases';

    protected $fillable = ['ingredient_id', 'units'];

    protected $hidden = ['updated_at'];

    public function ingredient()
    {
        return $this->belongsTo(StoreHouse::class);
    }
}
