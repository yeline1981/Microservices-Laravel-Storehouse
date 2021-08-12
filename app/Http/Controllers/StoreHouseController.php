<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\StoreHouse;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use App\Repositories\StorehouseRepository;
use App\Http\Requests\StoreHouseRequest;
use App\Http\Requests\StoreHouseAttendRequest;

class StoreHouseController extends Controller
{
    use ApiResponser;

    private $storehouseRepo;

    function __construct(StorehouseRepository $repository) {

        $this->storehouseRepo = $repository;
    }
    
    /**
     * Return ingredients list
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $ingredients = $this->storehouseRepo->list();

        return $this->successResponse($ingredients);
    }    

    public function update(StoreHouseRequest $request, $id)
    {
        $storehouse = $this->storehouseRepo->update($request->all(), $id);

        if ($storehouse->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        return $this->successResponse($storehouse);        
    }
    

}
