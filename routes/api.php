<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\CitiesController;
use App\Http\Controllers\Api\RegionsController;
use App\Http\Controllers\Api\TownshipsController;
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

// REST API (RESTful API)

// Representational State Transfer, Application Programming Interface
Route::post('/register',[AuthController::class,"register"]);
Route::post('/login',[AuthController::class,"login"]);

Route::post('/logout',[AuthController::class,"logout"])->middleware("auth:api");
Route::middleware(["auth:api"])->group(function(){
     Route::apiResource("warehouses",WarehousesController::class,["as"=>"api"]);
     Route::put("/warehousesstatus",[WarehousesController::class,"typestatus"]);

     Route::apiResource("cities",CitiesController::class,["as"=>"api"]);
     Route::put("/citiesstatus",[CitiesController::class,"typestatus"]);
     Route::get("/filter/cities/{filter}",[CitiesController::class,"filterbyregionid"]); // dyamic selectoption by countryid
     
     Route::get("/filter/regions/{filter}",[RegionsController::class,"filterbycountryid"]); // dyamic selectoption by cityid


     Route::apiResource("townships",TownshipsController::class,["as"=>"api"]);
     Route::put("/townshipsstatus",[TownshipsController::class,"typestatus"]);
     Route::get("/filter/townships/{filter}",[TownshipsController::class,"filterbycityid"]); // dyamic selectoption by countryid
     

     Route::apiResource("statuses",StatusesController::class,["as"=>"api"]);
     Route::get("/statusessearch",[StatusesController::class,"search"]);

});


// Route::apiResource("warehouses",WarehousesController::class);



