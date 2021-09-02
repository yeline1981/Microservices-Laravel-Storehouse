<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;

use App\Models\StoreHouse;
use App\Models\Purchase;
use App\Jobs\OrderProcessed;
use Illuminate\Support\Facades\Log;

class AttendIngredientsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {         
        $this->data = $data;                  
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {  
        
        /** Crear un job que gestione los ingredientes
        * - Determino los ingredientes q están disponibles
        * - Los que faltan se hace el listado para la compra
        * - 
        */        
       
        $notinstock = [];

        Log::info('ingredientes a despachar: ' . count($this->data['ingredients']));

        echo 'ingredientes a despachar: ' . count($this->data['ingredients']) . PHP_EOL;
        
        foreach($this->data['ingredients'] as $param){
            
            $ingredient = StoreHouse::find($param['ingredient_id']);

            if ($ingredient->units >= $param['units']){                

                $ingredient->units = $ingredient->units - $param['units']; // decremento pues despaché
                $ingredient->save();  
                
               // $instock[] = $param['ingredient'];
            } 
            elseif ($ingredient->units > 0){                

                $notinstock[] = [
                    "units" => $param['units'] - $ingredient->units, //Esto es lo q hace falta comprar
                    "ingredient" => $ingredient->ingredient
                ];

                $ingredient->units = 0;
                $ingredient->save();  
            }
            else {
                $notinstock[] = [
                    "units" => $param['units'] ,
                    "ingredient" => $ingredient->ingredient
                ];
            }
        }

        echo 'ingredientes a comprar: ' . count($notinstock) . PHP_EOL;

        //Los que falten mandar a comprar hasta q se alcance la cantidad requerida
        $url = config('marketservice.market.base_uri');      
        
        //echo 'URL: ' . $url . PHP_EOL;

        foreach($notinstock as $elem){

            echo 'Comprando: ' . $elem['ingredient'] . PHP_EOL;
             
            $complete = false;
            $attend = $elem['units'];

            while($complete == false){                               

                try{            
                    
                    $response = Http::get($url . '?ingredient=' . strtolower($elem['ingredient']));
                    
                    $response = json_decode($response, true);   

                    //echo 'Recibí: ' . $response['quantitySold'] . PHP_EOL;

                    $attend = $attend - $response['quantitySold'];

                    if ($attend <= 0){
                        $complete = true;
                    }
                    
                    //ir salvando cada compra
                    $storehouse = StoreHouse::where('ingredient', $elem['ingredient'])->first() ;
                    $storehouse->units = $storehouse->units + $response['quantitySold'];
                    $storehouse->save();

                    Purchase::create(['units' => $response['quantitySold'],
                                      'ingredient_id' => $storehouse->id]); 
                }
                catch (\Exception $e) {

                    echo $e->getMessage() . PHP_EOL;
                }                                        
                
            }           
            
        }
        
        echo 'Despacho realizado: ' . $this->data['order']['id'] . PHP_EOL;

        Log::info('Despacho realizado: ' . $this->data['order']['id']);

        OrderProcessed::dispatch($this->data['order']['id'])->onQueue('kitchen_queue');;
    }
}
