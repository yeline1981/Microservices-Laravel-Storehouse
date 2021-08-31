<?php

namespace App\Repositories;

use App\Models\Purchase;
use App\Models\StoreHouse;

class PurchaseRepository {

    public function list(){ 
                         
        return Purchase::orderByDesc('created_at')->get();                   
    } 

    public function store(array $purchase){

        $storehouse = StoreHouse::findOrFail($purchase['ingredient']);

        $storehouse->units = $storehouse->units + $purchase['units'];
        $storehouse->save();

        return Purchase::create(['units' => $purchase->units,
                                 'ingredients_id' => $storehouse->id]);        
    }

}