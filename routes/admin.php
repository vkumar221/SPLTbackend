<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminBrandController;
use App\Http\Controllers\Admin\AdminVendorController;
use App\Http\Controllers\Admin\AdminTrainerController;
use App\Http\Controllers\Admin\AdminAttributeController;
use App\Http\Controllers\Admin\AdminPromoCodeController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminInventoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminExerciseTypeController;
use App\Http\Controllers\Admin\AdminEquipmentController;
use App\Http\Controllers\Admin\AdminMuscleGroupController;
use App\Http\Controllers\Admin\AdminWorkoutCategoryController;
use App\Http\Controllers\Admin\AdminWorkoutController;
use App\Http\Controllers\Admin\AdminWorkoutPlanController;
use App\Http\Controllers\Admin\AdminSubscriptionPlanController;

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
Route::group(['middleware' => ['checkadminlogin']], function () {

    Route::get('/', [AuthController::class, 'index'])->name('admin.login');
    Route::post('login', [AuthController::class, 'checkLogin'])->name('admin.authenticate-login');
    Route::match(['get','post'],'forgot_password', [AdminLoginController::class, 'forgot_password'])->name('admin.forgot-password');
    Route::post('forgot-password-email-check', [AuthController::class, 'forgotPasswordEmailCheck'])->name('admin.forgot-password-email-check');
    Route::get('forgot-password/{token}', [AuthController::class, 'forgotPassword'])->name('admin.forgot-password-page');
    Route::post('forgot-password/update', [AuthController::class, 'updateForgotPassword'])->name('admin.update-forgot-password');

});

Route::group(['middleware' => ['checkadmin',]], function () {

    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard-page');
    Route::get('profile',[AdminProfileController::class, 'index'])->name('admin.profile-page');
    Route::post('profile',[AdminProfileController::class, 'update_profile'])->name('admin.profile');
    Route::get('change_password',[AdminProfileController::class, 'change_password'])->name('admin.change_password');
    Route::post('update_password',[AdminProfileController::class, 'update_password'])->name('admin.update_password');
    Route::post('check-old-password',[AdminProfileController::class, 'check_old_password'])->name('admin.check_old_password');
    Route::get('logout',[AdminDashboardController::class, 'logout'])->name('admin.logout');

    //category
    Route::get('categories', [AdminCategoryController::class, 'index'])->name('admin.categories');
    Route::get('add_category',[AdminCategoryController::class, 'add_category'])->name('admin.add-category-page');
    Route::post('create_category',[AdminCategoryController::class, 'create_category'])->name('admin.add-category');
    Route::get('edit_category/{id}',[AdminCategoryController::class, 'edit_category'])->name('admin.edit-category-page');
    Route::post('update_category/{id}',[AdminCategoryController::class, 'update_category'])->name('admin.edit-category');
    Route::get('category_status/{id}/{status}',[AdminCategoryController::class, 'category_status'])->name('admin.category-status');
    Route::post('get_categories',[AdminCategoryController::class, 'get_categories'])->name('admin.get-categories');

    //brand
    Route::get('brands', [AdminBrandController::class, 'index'])->name('admin.brands');
    Route::get('add_brand',[AdminBrandController::class, 'add_brand'])->name('admin.add-brand-page');
    Route::post('create_brand',[AdminBrandController::class, 'create_brand'])->name('admin.add-brand');
    Route::get('edit_brand/{id}',[AdminBrandController::class, 'edit_brand'])->name('admin.edit-brand-page');
    Route::post('update_brand/{id}',[AdminBrandController::class, 'update_brand'])->name('admin.edit-brand');
    Route::get('brand_status/{id}/{status}',[AdminBrandController::class, 'brand_status'])->name('admin.brand-status');
    Route::post('get_brands',[AdminBrandController::class, 'get_brands'])->name('admin.get-brands');

    //attribute
    Route::get('attributes', [AdminAttributeController::class, 'index'])->name('admin.attributes');
    Route::get('add_attribute',[AdminAttributeController::class, 'add_attribute'])->name('admin.add-attribute-page');
    Route::post('create_attribute',[AdminAttributeController::class, 'create_attribute'])->name('admin.add-attribute');
    Route::get('edit_attribute/{id}',[AdminAttributeController::class, 'edit_attribute'])->name('admin.edit-attribute-page');
    Route::post('update_attribute/{id}',[AdminAttributeController::class, 'update_attribute'])->name('admin.edit-attribute');
    Route::get('attribute_status/{id}/{status}',[AdminAttributeController::class, 'attribute_status'])->name('admin.attribute-status');
    Route::get('attribute_variation_status/{id}/{status}',[AdminAttributeController::class, 'attribute_variation_status'])->name('admin.attribute-variant-status');
    Route::get('attribute_variation_delete/{id}',[AdminAttributeController::class, 'attribute_variation_delete'])->name('admin.attribute-variant-delete');
    Route::post('get_attributes',[AdminAttributeController::class, 'get_attributes'])->name('admin.get-attributes');

    //vendor
    Route::get('vendors', [AdminVendorController::class, 'index'])->name('admin.vendors');
    Route::get('add_vendor',[AdminVendorController::class, 'add_vendor'])->name('admin.add-vendor-page');
    Route::post('create_vendor',[AdminVendorController::class, 'create_vendor'])->name('admin.add-vendor');
    Route::get('edit_vendor/{id}',[AdminVendorController::class, 'edit_vendor'])->name('admin.edit-vendor-page');
    Route::post('update_vendor/{id}',[AdminVendorController::class, 'update_vendor'])->name('admin.edit-vendor');
    Route::get('vendor_status/{id}/{status}',[AdminVendorController::class, 'vendor_status'])->name('admin.vendor-status');
    Route::post('get_vendors',[AdminVendorController::class, 'get_vendors'])->name('admin.get-vendors');

    //trainer
    Route::get('trainers', [AdminTrainerController::class, 'index'])->name('admin.trainers');
    Route::get('add_trainer',[AdminTrainerController::class, 'add_trainer'])->name('admin.add-trainer-page');
    Route::post('create_trainer',[AdminTrainerController::class, 'create_trainer'])->name('admin.add-trainer');
    Route::get('edit_trainer/{id}',[AdminTrainerController::class, 'edit_trainer'])->name('admin.edit-trainer-page');
    Route::post('update_trainer/{id}',[AdminTrainerController::class, 'update_trainer'])->name('admin.edit-trainer');
    Route::get('trainer_status/{id}/{status}',[AdminTrainerController::class, 'trainer_status'])->name('admin.trainer-status');
    Route::post('get_trainers',[AdminTrainerController::class, 'get_trainers'])->name('admin.get-trainers');

    //Promo Codes
    Route::get('promo_codes', [AdminPromoCodeController::class, 'index'])->name('admin.promo-codes');
    Route::get('add_promo_code',[AdminPromoCodeController::class, 'add_promo_code'])->name('admin.add-promo-code-page');
    Route::post('create_promo_code',[AdminPromoCodeController::class, 'create_promo_code'])->name('admin.add-promo-code');
    Route::get('edit_promo_code/{id}',[AdminPromoCodeController::class, 'edit_promo_code'])->name('admin.edit-promo-code-page');
    Route::post('update_promo_code/{id}',[AdminPromoCodeController::class, 'update_promo_code'])->name('admin.edit-promo-code');
    Route::get('promo_code_status/{id}/{status}',[AdminPromoCodeController::class, 'promo_code_status'])->name('admin.promo-code-status');
    Route::post('get_promo_codes',[AdminPromoCodeController::class, 'get_promo_codes'])->name('admin.get-promo-codes');

    //Products
    Route::get('products', [AdminProductController::class, 'index'])->name('admin.products');
    Route::get('add_product',[AdminProductController::class, 'add_product'])->name('admin.add-product-page');
    Route::post('create_product',[AdminProductController::class, 'create_product'])->name('admin.add-product');
    Route::get('edit_product/{id}',[AdminProductController::class, 'edit_product'])->name('admin.edit-product-page');
    Route::post('update_product/{id}',[AdminProductController::class, 'update_product'])->name('admin.edit-product');
    Route::get('product_status/{id}/{status}',[AdminProductController::class, 'product_status'])->name('admin.product-status');
    Route::post('get_products',[AdminProductController::class, 'get_products'])->name('admin.get-products');
    Route::post('select_attribute',[AdminProductController::class, 'select_attribute'])->name('admin.select-attribute');
    Route::post('attribute_price',[AdminProductController::class, 'attribute_price'])->name('admin.attribute-price');
    Route::get('product_gallery/{id}', [AdminProductController::class, 'product_gallery'])->name('admin.product_gallery');
    Route::post('add_product_gallery/{id}', [AdminProductController::class, 'add_product_gallery'])->name('admin.add_product_gallery');
    Route::post('drop_image', [AdminProductController::class, 'drop_image'])->name('admin.drop_image');
    Route::get('remove_image/{id}/{image}', [AdminProductController::class, 'remove_image'])->name('admin.remove_image');


    //Inventory
    Route::get('inventory', [AdminInventoryController::class, 'index'])->name('admin.inventory');
    Route::get('add_stock',[AdminInventoryController::class, 'add_stock'])->name('admin.add-inventory-page');
    Route::post('create_stock',[AdminInventoryController::class, 'create_stock'])->name('admin.add-inventory');
    Route::post('get_inventory',[AdminInventoryController::class, 'get_inventory'])->name('admin.get-inventory');
    Route::post('select_product',[AdminInventoryController::class, 'select_product'])->name('admin.select_product');
    Route::post('get_variant',[AdminInventoryController::class, 'select_variant'])->name('admin.select_variant');

    //Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('admin.orders');
    Route::post('get_orders',[AdminOrderController::class, 'get_orders'])->name('admin.get-orders');
    Route::get('edit_order/{id}',[AdminOrderController::class, 'edit_order'])->name('admin.edit-order-page');
    Route::post('update_order_address/{id}',[AdminOrderController::class, 'update_order_address'])->name('admin.update-order-address');
    Route::post('order_status/{id}',[AdminOrderController::class, 'order_status'])->name('admin.update-order-status');

    //Exercise Type
    Route::get('exercise_types', [AdminExerciseTypeController::class, 'index'])->name('admin.exercise-type');
    Route::post('get_exercise_type', [AdminExerciseTypeController::class, 'get_exercise_type'])->name('admin.get-exercise-types');
    Route::get('exercise_type_detail', [AdminExerciseTypeController::class, 'exercise_type_detail'])->name('admin.exercise-type-details');
    Route::match(['get','post'],'add_exercise_type', [AdminExerciseTypeController::class, 'add_exercise_type'])->name('admin.add-exercise_type');
    Route::match(['get','post'],'edit_exercise_type', [AdminExerciseTypeController::class, 'edit_exercise_type'])->name('admin.edit-exercise_type');
    Route::get('exercise_type_status/{id}/{status}', [AdminExerciseTypeController::class, 'exercise_type_status'])->name('admin.exercise-type-status');

    //Equipments
    Route::get('equipments', [AdminEquipmentController::class, 'index'])->name('admin.equipment');
    Route::post('get_equipment', [AdminEquipmentController::class, 'get_equipment'])->name('admin.get-equipments');
    Route::get('equipment_detail', [AdminEquipmentController::class, 'equipment_detail'])->name('admin.equipment-details');
    Route::match(['get','post'],'add_equipment', [AdminEquipmentController::class, 'add_equipment'])->name('admin.add-equipment');
    Route::match(['get','post'],'edit_equipment', [AdminEquipmentController::class, 'edit_equipment'])->name('admin.edit-equipment');
    Route::get('equipment_status/{id}/{status}', [AdminEquipmentController::class, 'equipment_status'])->name('admin.equipment-status');

    //Muscle Group
    Route::get('muscle_groups', [AdminMuscleGroupController::class, 'index'])->name('admin.muscle-group');
    Route::post('get_muscle_group', [AdminMuscleGroupController::class, 'get_muscle_group'])->name('admin.get-muscle-groups');
    Route::get('muscle_group_detail', [AdminMuscleGroupController::class, 'muscle_group_detail'])->name('admin.muscle-group-details');
    Route::match(['get','post'],'add_muscle_group', [AdminMuscleGroupController::class, 'add_muscle_group'])->name('admin.add-muscle_group');
    Route::match(['get','post'],'edit_muscle_group', [AdminMuscleGroupController::class, 'edit_muscle_group'])->name('admin.edit-muscle_group');
    Route::get('muscle_group_status/{id}/{status}', [AdminMuscleGroupController::class, 'muscle_group_status'])->name('admin.muscle-group-status');

    //Workout category
    Route::get('workout_categories', [AdminWorkoutCategoryController::class, 'index'])->name('admin.workout-categories');
    Route::get('add_workout_category',[AdminWorkoutCategoryController::class, 'add_workout_category'])->name('admin.add-workout-category-page');
    Route::post('create_workout_category',[AdminWorkoutCategoryController::class, 'create_workout_category'])->name('admin.add-workout-category');
    Route::get('edit_workout_category/{id}',[AdminWorkoutCategoryController::class, 'edit_workout_category'])->name('admin.edit-workout-category-page');
    Route::post('update_workout_category/{id}',[AdminWorkoutCategoryController::class, 'update_workout_category'])->name('admin.edit-workout-category');
    Route::get('workout_category_status/{id}/{status}',[AdminWorkoutCategoryController::class, 'workout_category_status'])->name('admin.workout-category-status');
    Route::post('get_workout_categories',[AdminWorkoutCategoryController::class, 'get_workout_categories'])->name('admin.get-workout-categories');

    //Workout
    Route::get('workouts', [AdminWorkoutController::class, 'index'])->name('admin.workouts');
    Route::get('add_workout',[AdminWorkoutController::class, 'add_workout'])->name('admin.add-workout-page');
    Route::post('create_workout',[AdminWorkoutController::class, 'create_workout'])->name('admin.add-workout');
    Route::get('edit_workout/{id}',[AdminWorkoutController::class, 'edit_workout'])->name('admin.edit-workout-page');
    Route::post('update_workout/{id}',[AdminWorkoutController::class, 'update_workout'])->name('admin.edit-workout');
    Route::get('workout_status/{id}/{status}',[AdminWorkoutController::class, 'workout_status'])->name('admin.workout-status');
    Route::post('get_workouts',[AdminWorkoutController::class, 'get_workouts'])->name('admin.get-workouts');

    //Workout
    Route::get('workout_plans', [AdminWorkoutPlanController::class, 'index'])->name('admin.workout-plans');
    Route::get('add_workout_plan',[AdminWorkoutPlanController::class, 'add_workout_plan'])->name('admin.add-workout-plan-page');
    Route::post('create_workout_plan',[AdminWorkoutPlanController::class, 'create_workout_plan'])->name('admin.add-workout-plan');
    Route::get('edit_workout_plan/{id}',[AdminWorkoutPlanController::class, 'edit_workout_plan'])->name('admin.edit-workout-plan-page');
    Route::post('update_workout_plan/{id}',[AdminWorkoutPlanController::class, 'update_workout_plan'])->name('admin.edit-workout-plan');
    Route::get('workout_plan_status/{id}/{status}',[AdminWorkoutPlanController::class, 'workout_plan_status'])->name('admin.workout-plan-status');
    Route::post('get_workout_plans',[AdminWorkoutPlanController::class, 'get_workout_plans'])->name('admin.get-workout-plans');
    Route::post('add_to_plan',[AdminWorkoutPlanController::class, 'add_to_plan'])->name('admin.add-to-plan');
    Route::post('filter_workout',[AdminWorkoutPlanController::class, 'filter_workout'])->name('admin.filter-workout');

    //Subscription Plans
    Route::get('subscription_plans', [AdminSubscriptionPlanController::class, 'index'])->name('admin.subscription-plans');
    Route::get('add_subscription_plan',[AdminSubscriptionPlanController::class, 'add_subscription_plan'])->name('admin.add-subscription-plan-page');
    Route::post('create_subscription_plan',[AdminSubscriptionPlanController::class, 'create_subscription_plan'])->name('admin.add-subscription-plan');
    Route::get('edit_subscription_plan/{id}',[AdminSubscriptionPlanController::class, 'edit_subscription_plan'])->name('admin.edit-subscription-plan-page');
    Route::post('update_subscription_plan/{id}',[AdminSubscriptionPlanController::class, 'update_subscription_plan'])->name('admin.edit-subscription-plan');
    Route::get('subscription_plan_status/{id}/{status}',[AdminSubscriptionPlanController::class, 'subscription_plan_status'])->name('admin.subscription-plan-status');
    Route::post('get_subscription_plans',[AdminSubscriptionPlanController::class, 'get_subscription_plans'])->name('admin.get-subscription-plans');


});

