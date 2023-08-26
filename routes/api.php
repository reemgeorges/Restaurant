<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Restaurant\RestaurantController;
use App\Http\Controllers\reviews\ReviewController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Display a listing of all restaurants along with their ratings.
Route::get('/restaurants', [RestaurantController::class,'showAllRestaurant']);

Route::get('/restaurant-menu/{UuidRestaurant}', [RestaurantController::class,'showٌRestaurantWithMenu']);
Route::get('/search', [RestaurantController::class,'search']);




Route::middleware(['AuthUser'])->group(function () {

    //add to order and menu-order all order
    Route::post('/add-all-order', [OrderController::class,'addAllOrder']);
    //add one order
    Route::post('/add-one-order', [OrderController::class,'addoneOrder']);



    // Route for updating an order
    Route::match(['put', 'patch' ],'/orders-all-update', [OrderController::class, 'updateAllOrder']);

    // Route for updating an order
    Route::match(['put', 'patch' ],'/orders-one-update', [OrderController::class, 'updateOneOrder']);

    // Route for deleting an order
    Route::delete('/orders/delete', [OrderController::class, 'deleteOrder']);

    //add review use to restaurant
    Route::post('/review-add',[ReviewController::class,'store']);

    //show all order for user
    Route::get('/user-allOrder',[UserController::class,'userOrders']);

    //deliver order


    Route::match(['put', 'patch' ],'/orders-deliver', [OrderController::class, 'deliverOrder']);

    Route::post('/logout', [AuthController::class, 'logout']);

});
