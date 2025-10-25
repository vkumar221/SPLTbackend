<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserLoginController;
use App\Http\Controllers\API\UserRegisterController;
use App\Http\Controllers\API\UserHomeController;
use App\Http\Controllers\API\UserCategoryController;
use App\Http\Controllers\API\UserPromoCodeController;
use App\Http\Controllers\API\UserProductController;
use App\Http\Controllers\API\UserPlanController;
use App\Http\Controllers\API\UserProfileController;
use App\Http\Controllers\API\UserCartController;
use App\Http\Controllers\API\UserCheckoutController;
use App\Http\Controllers\API\UserOrderController;
use App\Http\Controllers\API\TrainerLoginController;
use App\Http\Controllers\API\TrainerRegisterController;
use App\Http\Controllers\API\UserFollowController;
use App\Http\Controllers\API\UserBlockedController;
use App\Http\Controllers\API\UserAppointmentController;
use App\Http\Controllers\API\UserCertificateController;
use App\Http\Controllers\API\UserTrainerController;
use App\Http\Controllers\API\UserGoalController;
use App\Http\Controllers\API\UserPageController;
use App\Http\Controllers\API\UserWorkoutController;
use App\Http\Controllers\API\UserSettingController;

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
    Route::post('validate_uname', [UserRegisterController::class, 'validate_uname']);

    //Auth
    Route::post('trainer_login', [TrainerLoginController::class, 'index']);
    Route::post('trainer_forgot_password', [TrainerLoginController::class, 'forgot_password']);
    Route::post('trainer_reset_password', [TrainerLoginController::class, 'reset_password']);

Route::group(['middleware' => ['auth:api']], function () {

    Route::get('profile', [UserProfileController::class, 'index']);
    Route::post('update_profile', [UserProfileController::class, 'update_profile']);
    Route::post('change_mobile', [UserProfileController::class, 'change_mobile']);
    Route::post('verify_new_mobile', [UserProfileController::class, 'verify_new_mobile']);
    Route::post('change_password', [UserProfileController::class, 'change_password']);

    //Trainer
    Route::get('trainer_profile', [UserProfileController::class, 'trainer_profile']);
    Route::post('trainer_update_profile', [UserProfileController::class, 'trainer_update_profile']);
    Route::get('social_media', [UserProfileController::class, 'social_media']);

    //Following
    Route::post('follow', [UserFollowController::class, 'index']);
    Route::post('unfollow', [UserFollowController::class, 'unfollow']);
    Route::get('follwing_list', [UserFollowController::class, 'follwing_list']);
    Route::get('follwer_list', [UserFollowController::class, 'follwer_list']);

    //Block
    Route::post('block', [UserBlockedController::class, 'index']);
    Route::post('unblock', [UserBlockedController::class, 'unblock']);
    Route::get('blocked_list', [UserBlockedController::class, 'blocked_list']);

    //Appointment
    Route::post('book_appointment', [UserAppointmentController::class, 'index']);
    Route::get('appointment_list', [UserAppointmentController::class, 'appointment_list']);
    Route::post('appointment_cancel', [UserAppointmentController::class, 'appointment_cancel']);

    //Address
    Route::get('address_list', [UserProfileController::class, 'address_list']);
    Route::post('add_address', [UserProfileController::class, 'add_address']);
    Route::post('edit_address', [UserProfileController::class, 'edit_address']);
    Route::post('delete_address', [UserProfileController::class, 'delete_address']);

    //Card
    Route::get('card_list', [UserProfileController::class, 'card_list']);
    Route::post('add_card', [UserProfileController::class, 'add_card']);
    Route::post('edit_card', [UserProfileController::class, 'edit_card']);
    Route::post('delete_card', [UserProfileController::class, 'delete_card']);

    //Auth
    Route::get('logout', [UserLoginController::class, 'logout']);
    Route::get('logout_all_device', [UserLoginController::class, 'logout_all_device']);

    //Category
    Route::get('category', [UserCategoryController::class, 'index']);

    //Promocode
    Route::get('promocode', [UserPromoCodeController::class, 'index']);
    Route::post('verify_promocode', [UserPromoCodeController::class, 'verify_promocode']);

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

    //Order
    Route::get('orders', [UserOrderController::class, 'index']);
    Route::get('order_details', [UserOrderController::class, 'order_details']);
    Route::post('order_cancel', [UserOrderController::class, 'order_cancel']);
    Route::post('order_review', [UserOrderController::class, 'order_review']);

    //Plans
    Route::get('plans', [UserPlanController::class, 'index']);
    Route::post('buy_plan', [UserPlanController::class, 'buy_plan']);

    //Trainers
    Route::get('trainer_list', [UserTrainerController::class, 'index']);
    Route::post('search_trainer', [UserTrainerController::class, 'search_trainer']);
    Route::post('about_trainer', [UserTrainerController::class, 'about_trainer']);

    //Certificate
    Route::get('certificates', [UserCertificateController::class, 'index']);
    Route::post('trainer_certificate', [UserCertificateController::class, 'trainer_certificate']);
    Route::post('add_certificate', [UserCertificateController::class, 'add_certificate']);

    //Review
    Route::post('add_review', [UserTrainerController::class, 'add_review']);
    Route::post('review_like', [UserTrainerController::class, 'review_like']);
    Route::post('remove_review_like', [UserTrainerController::class, 'remove_review_like']);

    //Goal
    Route::get('goals', [UserGoalController::class, 'index']);
    Route::get('goal_types', [UserGoalController::class, 'goal_types']);
    Route::post('add_goal', [UserGoalController::class, 'add_goal']);

    //Pages
    Route::get('terms', [UserPageController::class, 'terms']);
    Route::get('about', [UserPageController::class, 'about']);
    Route::get('contact', [UserPageController::class, 'contact']);

    //Settings
    Route::get('faq', [UserSettingController::class, 'faq']);
    Route::post('search_faq', [UserSettingController::class, 'search_faq']);
    Route::post('submit_question', [UserSettingController::class, 'submit_question']);
    Route::get('measurement_parts', [UserSettingController::class, 'measurement_parts']);
    Route::post('add_measurement', [UserSettingController::class, 'add_measurement']);

    //Settings
    Route::get('workout', [UserWorkoutController::class, 'index']);
    Route::post('search_workout', [UserWorkoutController::class, 'search_workout']);
    Route::post('workout_detail', [UserWorkoutController::class, 'workout_plan_detail']);

});



