<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CitiesController;
use App\Http\Controllers\Api\StatusesController;
use App\Http\Controllers\Api\WarehousesController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResource("warehouses",WarehousesController::class);

Route::apiResource("cities",CitiesController::class,["as"=>"api"]);
Route::put("/citiesstatus",[CitiesController::class,"typestatus"]);

Route::apiResource("statuses",StatusesController::class,["as"=>"api"]);
Route::get("/statusessearch",[StatusesController::class,"search"]);


Route::apiResource("warehouses",WarehousesController::class,["as"=>"api"]);
Route::put("/warehousesstatus",[WarehousesController::class,"typestatus"]);
