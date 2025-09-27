<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\TrainerAuthController;
use App\Http\Controllers\Trainer\TrainerDashboardController;
use App\Http\Controllers\Trainer\TrainerLoginController;
use App\Http\Controllers\Trainer\TrainerProfileController;
use App\Http\Controllers\Trainer\TrainerClientController;
use App\Http\Controllers\Trainer\TrainerWorkoutController;
use App\Http\Controllers\Trainer\TrainerWorkoutPlanController;

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
    Route::get('workout_status/{id}/{status}',[TrainerWorkoutController::class, 'workout_status'])->name('trainer.workout-status');
    Route::post('get_workouts',[TrainerWorkoutController::class, 'get_workouts'])->name('trainer.get-workouts');

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


});

