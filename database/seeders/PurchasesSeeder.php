<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;

class PurchasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 10; $i++){
            Purchase::create(['ingredient_id' => rand(1,10),
                              'units' => rand(1, 20)]);
        }
    }
}
