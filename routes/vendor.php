<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VendorAuthController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use App\Http\Controllers\Vendor\VendorLoginController;
use App\Http\Controllers\Vendor\VendorProfileController;
use App\Http\Controllers\Vendor\VendorProductController;
use App\Http\Controllers\Vendor\VendorInventoryController;
use App\Http\Controllers\Vendor\VendorOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can product web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['checkvendorlogin']], function () {

    Route::get('/', [VendorAuthController::class, 'index'])->name('vendor.login');
    Route::post('login', [VendorAuthController::class, 'checkLogin'])->name('vendor.authenticate-login');
    Route::match(['get','post'],'forgot_password', [VendorLoginController::class, 'forgot_password'])->name('vendor.forgot-password');
    Route::post('forgot-password-email-check', [VendorAuthController::class, 'forgotPasswordEmailCheck'])->name('vendor.forgot-password-email-check');
    Route::get('forgot-password/{token}', [VendorAuthController::class, 'forgotPassword'])->name('vendor.forgot-password-page');
    Route::post('forgot-password/update', [VendorAuthController::class, 'updateForgotPassword'])->name('vendor.update-forgot-password');

});

Route::group(['middleware' => ['checkvendor',]], function () {

    Route::get('dashboard', [VendorDashboardController::class, 'index'])->name('vendor.dashboard-page');
    Route::get('profile',[VendorProfileController::class, 'index'])->name('vendor.profile-page');
    Route::post('profile',[VendorProfileController::class, 'update_profile'])->name('vendor.profile');
    Route::get('change_password',[VendorProfileController::class, 'change_password'])->name('vendor.change_password');
    Route::post('update_password',[VendorProfileController::class, 'update_password'])->name('vendor.update_password');
    Route::post('check-old-password',[VendorProfileController::class, 'check_old_password'])->name('vendor.check_old_password');
    Route::get('logout',[VendorDashboardController::class, 'logout'])->name('vendor.logout');

    //Products
    Route::get('products', [VendorProductController::class, 'index'])->name('vendor.products');
    Route::get('add_product',[VendorProductController::class, 'add_product'])->name('vendor.add-product-page');
    Route::post('create_product',[VendorProductController::class, 'create_product'])->name('vendor.add-product');
    Route::get('edit_product/{id}',[VendorProductController::class, 'edit_product'])->name('vendor.edit-product-page');
    Route::post('update_product/{id}',[VendorProductController::class, 'update_product'])->name('vendor.edit-product');
    Route::get('product_status/{id}/{status}',[VendorProductController::class, 'product_status'])->name('vendor.product-status');
    Route::post('get_products',[VendorProductController::class, 'get_products'])->name('vendor.get-products');
    Route::get('product_gallery/{id}', [VendorProductController::class, 'product_gallery'])->name('vendor.product_gallery');
    Route::post('add_product_gallery/{id}', [VendorProductController::class, 'add_product_gallery'])->name('vendor.add_product_gallery');
    Route::post('drop_image', [VendorProductController::class, 'drop_image'])->name('vendor.drop_image');
    Route::get('remove_image/{id}/{image}', [VendorProductController::class, 'remove_image'])->name('vendor.remove_image');
    Route::post('select_attribute',[VendorProductController::class, 'select_attribute'])->name('vendor.select-attribute');
    Route::post('attribute_price',[VendorProductController::class, 'attribute_price'])->name('vendor.attribute-price');

    //Inventory
    Route::get('inventory', [VendorInventoryController::class, 'index'])->name('vendor.inventory');
    Route::get('add_stock',[VendorInventoryController::class, 'add_stock'])->name('vendor.add-inventory-page');
    Route::post('create_stock',[VendorInventoryController::class, 'create_stock'])->name('vendor.add-inventory');
    Route::post('get_inventory',[VendorInventoryController::class, 'get_inventory'])->name('vendor.get-inventory');
    Route::post('select_product',[VendorInventoryController::class, 'select_product'])->name('vendor.select_product');
    Route::post('get_variant',[VendorInventoryController::class, 'select_variant'])->name('vendor.select_variant');


    //Orders
    Route::get('orders', [VendorOrderController::class, 'index'])->name('vendor.orders');
    Route::post('get_orders',[VendorOrderController::class, 'get_orders'])->name('vendor.get-orders');
    Route::get('edit_order/{id}',[VendorOrderController::class, 'edit_order'])->name('vendor.edit-order-page');
    Route::post('update_order_address/{id}',[VendorOrderController::class, 'update_order_address'])->name('vendor.update-order-address');
    Route::post('order_status/{id}',[VendorOrderController::class, 'order_status'])->name('vendor.update-order-status');


});

