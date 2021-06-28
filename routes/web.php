<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('app')->group(function(){
    Route::get('/getSortedVerdicts/{selectedVerdict}', [StaffController::class, 'getSortedVerdicts']);
    Route::get('/get_date_range/{fromDate}/{toDate}', [StaffController::class, 'getDateRange']);
    Route::get('/get_last_notification', [NotificationController::class, 'getLastNotification']);
    Route::get('/get_users', [StaffController::class, 'getStaffs']);
    Route::get('/get_reportedTimes', [StaffController::class, 'get_reportedTimes']);
    Route::get('/get_reportingTime', [StaffController::class, 'get_reportingTime']);
    Route::get('/getLateRecords', [StaffController::class, 'getLateRecords']);

    Route::post('/create_staff', [StaffController::class, 'createStaff']);
    Route::post('/create_reportedTime/{staff_id}', [StaffController::class, 'createReportedTime']);
    Route::post('/create_reportingTime/{time}', [StaffController::class, 'createReportingTime']);
    Route::post('/login', [StaffController::class, 'login']);
});

Route::get('/logout', [StaffController::class, 'logout']);
Route::get('/', [StaffController::class, 'index']);
Route::any('{slug}', [StaffController::class, 'index'])->where('slug', '([A-z\d\-\/_.]+)?');

// Route::get('/', function () {
//     return view('welcome');
// });




