<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Purchase;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use App\Repositories\PurchaseRepository;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    use ApiResponser;

    private $purchaseRepos;

    function __construct(PurchaseRepository $repository) {

        $this->purchaseRepos = $repository;
    }
    
    /**
     * Return purchases list
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = $this->purchaseRepos->list();

        return $this->successResponse($purchases);
    }

    /**
     * Create purchases in store
     * @return Illuminate\Http\Response
     */
    public function store(PurchaseRequest $request)
    {
        $purchases = $this->purchaseRepos->store($request->all());

        return $this->successResponse($purchases);
    }    

}
