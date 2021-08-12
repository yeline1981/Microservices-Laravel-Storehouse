<?php

namespace App\Repositories;

use App\Models\StoreHouse;

use App\Jobs\AttendIngredientsJob; 

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StorehouseRepository {

    public function list(){
                  
        return StoreHouse::all();       
            
    }
    
    public function update(array $params, int $id){

        $storehouse = StoreHouse::findOrFail($id);

        $storehouse->fill($params);        

        $storehouse->save();

        return $storehouse;

    }

    

}