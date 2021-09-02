<?php

namespace App\Repositories;

use App\Models\Purchase;
use App\Models\StoreHouse;
use Illuminate\Support\Facades\DB;

class PurchaseRepository {

    public function list(){ 
        
        $purchases = DB::table('purchases')
            ->join('storehouse', 'storehouse.id', '=', 'purchases.ingredient_id')
            ->select('purchases.id', 'ingredient', 'purchases.units', 'purchases.created_at as date')
            ->orderBy('purchases.id', 'desc')
            ->get();

        return $purchases;
    } 

    public function store(array $purchase){

        $storehouse = StoreHouse::findOrFail($purchase['ingredient']);

        $storehouse->units = $storehouse->units + $purchase['units'];
        $storehouse->save();

        return Purchase::create(['units' => $purchase->units,
                                 'ingredients_id' => $storehouse->id]);        
    }

}