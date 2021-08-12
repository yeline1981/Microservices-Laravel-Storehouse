<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\AttendIngredientsJob;
use Illuminate\Support\Facades\Log;


class SendIngredients extends Command
{    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:ingredients {order} {instock} {notinstock}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Response from Storehouse to kitchen new order';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $order = $this->argument('order'); 
        
        Log::info('call job: ' . $order);
        
        $instock = $this->argument('instock');
        $notinstock = $this->argument('notinstock');
       // StoreHouseJob::dispatch(StoreHouse::inRandomOrder()->first()->toArray());  
       AttendIngredientsJob::dispatch($order, $instock, $notinstock);        
    }
}
