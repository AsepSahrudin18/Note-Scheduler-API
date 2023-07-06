<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ActivityController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::resource('schedules', ScheduleController::class);
Route::get('/schedule/{id}/activities', [ScheduleController::class, 'getActivitiesByScheduleId']);
Route::get('/activity/{id}', [ScheduleController::class, 'getActivitiesByScheduleId']);

// ROUTING SCHEDULE
Route::post('schedules', [ScheduleController::class, 'store']);
Route::put('/schedule/{id}', [ScheduleController::class, 'update']);
Route::delete('/schedule/{id}', [ScheduleController::class, 'deleteSchedule']);
Route::get('/schedule/{id}/activities', [ActivityController::class, 'getActivitiesByScheduleId']);
Route::get('/activity/{id}', [ActivityController::class, 'getActivityById']);

Route::post('/schedule/{id}/activity', [ScheduleController::class, 'addActivityToSchedule']); // progress
Route::put('/schedules/{scheduleId}/activities/{activityId}', [ScheduleController::class, 'updateActivity']);
Route::delete('/schedules/{scheduleId}/activities/{activityId}', [ScheduleController::class, 'deleteActivity']);
Route::get('/schedules/{scheduleId}', [ScheduleController::class, 'getScheduleById']);

Route::post('/schedules/search', [ScheduleController::class, 'searchSchedulesByTitle']); // progress 
Route::post('/schedules/search-by-date', [ScheduleController::class, 'searchSchedulesByDate']); // progress
Route::get('/schedules', [ScheduleController::class, 'getAllSchedules']);











