<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\TrainerAuthController;
use App\Http\Controllers\Trainer\TrainerDashboardController;
use App\Http\Controllers\Trainer\TrainerLoginController;
use App\Http\Controllers\Trainer\TrainerProfileController;
use App\Http\Controllers\Trainer\TrainerClientController;
use App\Http\Controllers\Trainer\TrainerWorkoutController;
use App\Http\Controllers\Trainer\TrainerWorkoutPlanController;
use App\Http\Controllers\Trainer\TrainerCertificateController;
use App\Http\Controllers\Trainer\TrainerVideoController;
use App\Http\Controllers\Trainer\TrainerProductController;
use App\Http\Controllers\Trainer\TrainerInventoryController;
use App\Http\Controllers\Trainer\TrainerOrderController;
use App\Http\Controllers\Trainer\TrainerNewsletterController;

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
Route::group(['middleware' => ['checktrainerlogin']], function () {

    Route::get('/', [TrainerAuthController::class, 'index'])->name('trainer.login');
    Route::post('login', [TrainerAuthController::class, 'checkLogin'])->name('trainer.authenticate-login');
    Route::match(['get','post'],'forgot_password', [TrainerLoginController::class, 'forgot_password'])->name('trainer.forgot-password');
    Route::post('forgot-password-email-check', [TrainerAuthController::class, 'forgotPasswordEmailCheck'])->name('trainer.forgot-password-email-check');
    Route::get('forgot-password/{token}', [TrainerAuthController::class, 'forgotPassword'])->name('trainer.forgot-password-page');
    Route::post('forgot-password/update', [TrainerAuthController::class, 'updateForgotPassword'])->name('trainer.update-forgot-password');

});

Route::group(['middleware' => ['checktrainer',]], function () {

    Route::get('dashboard', [TrainerDashboardController::class, 'index'])->name('trainer.dashboard-page');
    Route::get('profile',[TrainerProfileController::class, 'index'])->name('trainer.profile-page');
    Route::post('profile',[TrainerProfileController::class, 'update_profile'])->name('trainer.profile');
    Route::get('change_password',[TrainerProfileController::class, 'change_password'])->name('trainer.change_password');
    Route::post('update_password',[TrainerProfileController::class, 'update_password'])->name('trainer.update_password');
    Route::post('check-old-password',[TrainerProfileController::class, 'check_old_password'])->name('trainer.check_old_password');
    Route::get('logout',[TrainerDashboardController::class, 'logout'])->name('trainer.logout');

    //client
    Route::get('clients', [TrainerClientController::class, 'index'])->name('trainer.clients');
    Route::get('add_client',[TrainerClientController::class, 'add_client'])->name('trainer.add-client-page');
    Route::post('create_client',[TrainerClientController::class, 'create_client'])->name('trainer.add-client');
    Route::get('view_client/{id}',[TrainerClientController::class, 'view_client'])->name('trainer.view-client-page');
    Route::get('client_workout_plan/{id}',[TrainerClientController::class, 'client_workout_plan'])->name('trainer.client-workout-plan');
    Route::get('client_exercise_statics/{id}',[TrainerClientController::class, 'client_exercise_statics'])->name('trainer.client-exercise-statics');
    Route::get('client_advanced_statics/{id}',[TrainerClientController::class, 'client_advanced_statics'])->name('trainer.client-advanced-statics');
    Route::get('client_body_measurement/{id}',[TrainerClientController::class, 'client_body_measurement'])->name('trainer.client-body-measurement');
    Route::get('client_progress_picture/{id}',[TrainerClientController::class, 'client_progress_picture'])->name('trainer.client-progress-picture');
    Route::get('client_settings/{id}',[TrainerClientController::class, 'client_settings'])->name('trainer.client-settings');
    Route::post('client_update/{id}',[TrainerClientController::class, 'client_update'])->name('trainer.client-update');
    Route::get('client_goals/{id}',[TrainerClientController::class, 'client_goals'])->name('trainer.client-goals');
    Route::post('add_client_goal/{id}',[TrainerClientController::class, 'add_client_goal'])->name('trainer.add-client-goal');
    Route::post('client_measurement',[TrainerClientController::class, 'client_measurement'])->name('trainer.get-client-measurement');
    Route::post('add_measurement_log',[TrainerClientController::class, 'add_measurement_log'])->name('trainer.add-measurement-log');
    Route::get('edit_client/{id}',[TrainerClientController::class, 'edit_client'])->name('trainer.edit-client-page');
    Route::post('update_client/{id}',[TrainerClientController::class, 'update_client'])->name('trainer.edit-client');
    Route::get('client_status/{id}/{status}',[TrainerClientController::class, 'client_status'])->name('trainer.client-status');
    Route::post('get_clients',[TrainerClientController::class, 'get_clients'])->name('trainer.get-clients');

    //Workout
    Route::get('workouts', [TrainerWorkoutController::class, 'index'])->name('trainer.workouts');
    Route::get('add_workout',[TrainerWorkoutController::class, 'add_workout'])->name('trainer.add-workout-page');
    Route::post('create_workout',[TrainerWorkoutController::class, 'create_workout'])->name('trainer.add-workout');
    Route::get('edit_workout/{id}',[TrainerWorkoutController::class, 'edit_workout'])->name('trainer.edit-workout-page');
    Route::post('update_workout/{id}',[TrainerWorkoutController::class, 'update_workout'])->name('trainer.edit-workout');
    Route::post('view_exercise',[TrainerWorkoutController::class, 'view_exercise'])->name('trainer.view-exercise');
    Route::get('workout_status/{id}/{status}',[TrainerWorkoutController::class, 'workout_status'])->name('trainer.workout-status');
    Route::post('get_workouts',[TrainerWorkoutController::class, 'get_workouts'])->name('trainer.get-workouts');
    Route::post('filter_workouts',[TrainerWorkoutController::class, 'filter_workout'])->name('trainer.filter-workouts');

    //Workout
    Route::get('workout_plans', [TrainerWorkoutPlanController::class, 'index'])->name('trainer.workout-plans');
    Route::get('workout_plan_split', [TrainerWorkoutPlanController::class, 'split'])->name('trainer.workout-plan-split');
    Route::get('add_workout_plan',[TrainerWorkoutPlanController::class, 'add_workout_plan'])->name('trainer.add-workout-plan-page');
    Route::post('create_workout_plan',[TrainerWorkoutPlanController::class, 'create_workout_plan'])->name('trainer.add-workout-plan');
    Route::get('edit_workout_plan/{id}',[TrainerWorkoutPlanController::class, 'edit_workout_plan'])->name('trainer.edit-workout-plan-page');
    Route::post('update_workout_plan/{id}',[TrainerWorkoutPlanController::class, 'update_workout_plan'])->name('trainer.edit-workout-plan');
    Route::get('workout_plan_status/{id}/{status}',[TrainerWorkoutPlanController::class, 'workout_plan_status'])->name('trainer.workout-plan-status');
    Route::post('get_workout_plans',[TrainerWorkoutPlanController::class, 'get_workout_plans'])->name('trainer.get-workout-plans');
    Route::post('add_to_plan',[TrainerWorkoutPlanController::class, 'add_to_plan'])->name('trainer.add-to-plan');
    Route::post('filter_workout',[TrainerWorkoutPlanController::class, 'filter_workout'])->name('trainer.filter-workout');
    Route::post('get_programs',[TrainerWorkoutPlanController::class, 'get_programs'])->name('trainer.get-programs');
    Route::get('add_library/{id}',[TrainerWorkoutPlanController::class, 'add_library'])->name('trainer.add-to-library');
    Route::get('delete_library/{id}',[TrainerWorkoutPlanController::class, 'delete_library'])->name('trainer.delete-library');

    //Certificate
    Route::get('certificates', [TrainerCertificateController::class, 'index'])->name('trainer.certificates');
    Route::get('add_certificate',[TrainerCertificateController::class, 'add_certificate'])->name('trainer.add-certificate-page');
    Route::post('create_certificate',[TrainerCertificateController::class, 'create_certificate'])->name('trainer.add-certificate');
    Route::get('edit_certificate/{id}',[TrainerCertificateController::class, 'edit_certificate'])->name('trainer.edit-certificate-page');
    Route::post('update_certificate/{id}',[TrainerCertificateController::class, 'update_certificate'])->name('trainer.edit-certificate');
    Route::get('certificate_status/{id}/{status}',[TrainerCertificateController::class, 'certificate_status'])->name('trainer.certificate-status');
    Route::post('get_certificates',[TrainerCertificateController::class, 'get_certificates'])->name('trainer.get-certificates');

    //Video Section
    Route::get('section_detail', [TrainerVideoController::class, 'section_detail'])->name('trainer.section-details');
    Route::post('create_section', [TrainerVideoController::class, 'create_section'])->name('trainer.add-section');
    Route::post('edit_section', [TrainerVideoController::class, 'edit_section'])->name('trainer.edit-section');

    //Video
    Route::get('videos', [TrainerVideoController::class, 'index'])->name('trainer.videos');
    Route::get('add_video',[TrainerVideoController::class, 'add_video'])->name('trainer.add-video-page');
    Route::post('create_video',[TrainerVideoController::class, 'create_video'])->name('trainer.add-video');
    Route::get('edit_video/{id}',[TrainerVideoController::class, 'edit_video'])->name('trainer.edit-video-page');
    Route::post('update_video/{id}',[TrainerVideoController::class, 'update_video'])->name('trainer.edit-video');
    Route::get('video_status/{id}/{status}',[TrainerVideoController::class, 'video_status'])->name('trainer.video-status');

    //Products
    Route::get('products', [TrainerProductController::class, 'index'])->name('trainer.products');
    Route::get('add_product',[TrainerProductController::class, 'add_product'])->name('trainer.add-product-page');
    Route::post('create_product',[TrainerProductController::class, 'create_product'])->name('trainer.add-product');
    Route::get('edit_product/{id}',[TrainerProductController::class, 'edit_product'])->name('trainer.edit-product-page');
    Route::post('update_product/{id}',[TrainerProductController::class, 'update_product'])->name('trainer.edit-product');
    Route::get('product_status/{id}/{status}',[TrainerProductController::class, 'product_status'])->name('trainer.product-status');
    Route::post('get_products',[TrainerProductController::class, 'get_products'])->name('trainer.get-products');
    Route::get('product_gallery/{id}', [TrainerProductController::class, 'product_gallery'])->name('trainer.product_gallery');
    Route::post('add_product_gallery/{id}', [TrainerProductController::class, 'add_product_gallery'])->name('trainer.add_product_gallery');
    Route::post('drop_image', [TrainerProductController::class, 'drop_image'])->name('trainer.drop_image');
    Route::get('remove_image/{id}/{image}', [TrainerProductController::class, 'remove_image'])->name('trainer.remove_image');
    Route::post('select_attribute',[TrainerProductController::class, 'select_attribute'])->name('trainer.select-attribute');
    Route::post('attribute_price',[TrainerProductController::class, 'attribute_price'])->name('trainer.attribute-price');

    //Inventory
    Route::get('inventory', [TrainerInventoryController::class, 'index'])->name('trainer.inventory');
    Route::get('add_stock',[TrainerInventoryController::class, 'add_stock'])->name('trainer.add-inventory-page');
    Route::post('create_stock',[TrainerInventoryController::class, 'create_stock'])->name('trainer.add-inventory');
    Route::post('get_inventory',[TrainerInventoryController::class, 'get_inventory'])->name('trainer.get-inventory');
    Route::post('select_product',[TrainerInventoryController::class, 'select_product'])->name('trainer.select_product');
    Route::post('get_variant',[TrainerInventoryController::class, 'select_variant'])->name('trainer.select_variant');

    //Orders
    Route::get('orders', [TrainerOrderController::class, 'index'])->name('trainer.orders');
    Route::post('get_orders',[TrainerOrderController::class, 'get_orders'])->name('trainer.get-orders');
    Route::get('edit_order/{id}',[TrainerOrderController::class, 'edit_order'])->name('trainer.edit-order-page');
    Route::post('update_order_address/{id}',[TrainerOrderController::class, 'update_order_address'])->name('trainer.update-order-address');
    Route::post('order_status/{id}',[TrainerOrderController::class, 'order_status'])->name('trainer.update-order-status');

    //Newsletter
    Route::get('newsletters', [TrainerNewsletterController::class, 'index'])->name('trainer.newsletters');
    Route::get('add_newsletter',[TrainerNewsletterController::class, 'add_newsletter'])->name('trainer.add-newsletter-page');
    Route::post('create_newsletter',[TrainerNewsletterController::class, 'create_newsletter'])->name('trainer.add-newsletter');
    Route::get('edit_newsletter/{id}',[TrainerNewsletterController::class, 'edit_newsletter'])->name('trainer.edit-newsletter-page');
    Route::post('update_newsletter/{id}',[TrainerNewsletterController::class, 'update_newsletter'])->name('trainer.edit-newsletter');
    Route::post('view_exercise',[TrainerNewsletterController::class, 'view_exercise'])->name('trainer.view-exercise');
    Route::get('newsletter_delete/{id}',[TrainerNewsletterController::class, 'newsletter_delete'])->name('trainer.newsletter-delete');
    Route::post('select_product',[TrainerNewsletterController::class, 'select_product'])->name('trainer.select-product');
    Route::post('filter_newsletters',[TrainerNewsletterController::class, 'filter_newsletter'])->name('trainer.filter-newsletters');


});

