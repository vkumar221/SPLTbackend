<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserLoginController;
use App\Http\Controllers\API\UserRegisterController;
use App\Http\Controllers\API\UserHomeController;
use App\Http\Controllers\API\UserCategoryController;
use App\Http\Controllers\API\UserProductController;
use App\Http\Controllers\API\UserProfileController;
use App\Http\Controllers\API\UserCartController;
use App\Http\Controllers\API\UserCheckoutController;

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

Route::get('unauthenticated',function(){
    return response()->json(['message' => 'Invalid token', 'error' => 'Invalid token', 'status' => false], 401);
})->name('unauthenticated-api');

    //Auth
    Route::post('login', [UserLoginController::class, 'index']);
    Route::post('forgot_password', [UserLoginController::class, 'forgot_password']);
    Route::post('reset_password', [UserLoginController::class, 'reset_password']);

    //Register
    Route::post('register', [UserRegisterController::class, 'index']);




Route::group(['middleware' => ['auth:api']], function () {


    Route::get('profile', [UserProfileController::class, 'index']);
    Route::post('update_profile', [UserProfileController::class, 'update_profile']);
    Route::post('change_mobile', [UserProfileController::class, 'change_mobile']);
    Route::post('verify_new_mobile', [UserProfileController::class, 'verify_new_mobile']);
    Route::post('change_password', [UserProfileController::class, 'change_password']);

    //Auth
    Route::get('logout', [UserLoginController::class, 'logout']);
    Route::get('logout_all_device', [UserLoginController::class, 'logout_all_device']);

  //Category
    Route::get('category', [UserCategoryController::class, 'index']);

    //Product
    Route::get('product', [UserProductController::class, 'index']);
    Route::get('product_detail', [UserProductController::class, 'product_detail']);

    //Cart
    Route::get('cart', [UserCartController::class, 'index']);
    Route::get('add_cart', [UserCartController::class, 'add_cart']);
    Route::get('update_cart', [UserCartController::class, 'update_cart']);
    Route::get('remove_cart', [UserCartController::class, 'remove_cart']);
    Route::get('clear_cart', [UserCartController::class, 'clear_cart']);

    //Checkout
    Route::get('checkout', [UserCheckoutController::class, 'index']);
    Route::post('place_order', [UserCheckoutController::class, 'place_order']);


});



