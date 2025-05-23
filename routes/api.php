<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\CitiesController;
use App\Http\Controllers\Api\EnrollsController;
use App\Http\Controllers\Api\LeadsController;
use App\Http\Controllers\Api\LeavesController;
use App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\Api\RegionsController;
use App\Http\Controllers\Api\TownshipsController;
use App\Http\Controllers\Api\StatusesController;
use App\Http\Controllers\Api\StudentsController;
use App\Http\Controllers\Api\WarehousesController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\ContactsController;
use App\Http\Controllers\Api\AnnouncementsController;
use App\Http\Controllers\Api\CommentsController;


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


Route::get("/enrollsdashboard",[EnrollsController::class,"dashboard"]);

Route::get("/leadsdashboard",[LeadsController::class,"dashboard"]);
Route::get("/leavesdashboard",[LeavesController::class,"dashboard"]);
Route::get("/postsdashboard",[PostsController::class,"dashboard"]);
Route::get("/usersdashboard",[UsersController::class,"dashboard"]);
Route::get("/studentsdashboard",[StudentsController::class,"dashboard"]);

Route::get("/contactsdashboard",[ContactsController::class,"dashboard"]);
Route::get("/announcementsdashboard",[AnnouncementsController::class,"dashboard"]);

Route::get("/commentsdashboard",[CommentsController::class,"dashboard"]);
