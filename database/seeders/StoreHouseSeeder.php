<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StoreHouse;

class StoreHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tomato = StoreHouse::create(['ingredient' => 'tomato', 'units' => 5]);
        $lemon = StoreHouse::create(['ingredient' => 'lemon', 'units' => 5]);
        $potato = StoreHouse::create(['ingredient' => 'potato', 'units' => 5]);
        $rice = StoreHouse::create(['ingredient' => 'rice', 'units' => 5]);
        $ketchup = StoreHouse::create(['ingredient' => 'ketchup', 'units' => 5]);
        $lettuce = StoreHouse::create(['ingredient' => 'lettuce', 'units' => 5]);
        $onion = StoreHouse::create(['ingredient' => 'onion', 'units' => 5]);
        $cheese = StoreHouse::create(['ingredient' => 'cheese', 'units' => 5]);
        $meat = StoreHouse::create(['ingredient' => 'meat', 'units' => 5]);
        $chicken = StoreHouse::create(['ingredient' => 'chicken', 'units' => 5]);
    }
}
