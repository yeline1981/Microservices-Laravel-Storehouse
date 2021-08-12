<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\StoreHouseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$router->get('/purchases', [PurchaseController::class, 'index']);
$router->post('/purchases', [PurchaseController::class, 'store']);


$router->get('/storehouse', [StoreHouseController::class, 'index']);
$router->post('/storehouse', [StoreHouseController::class, 'store']);
$router->put('/storehouse/{id}', [StoreHouseController::class, 'update']);