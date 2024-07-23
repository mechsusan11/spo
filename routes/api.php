<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PoliceUserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportTypeController;
use App\Http\Controllers\SubDivisionController;
use App\Http\Controllers\UserController;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// adding user, policeUser and report
Route::post('/addUser', [UserController::class, 'addUser']);
Route::post('/addPoliceUser', [PoliceUserController::class, 'addPoliceUser']);
Route::get('/policeUserList', [PoliceUserController::class, 'policeUserList']);
Route::get('/policeUser/{id}', [PoliceUserController::class, 'policeUserById']);
Route::post('/addReport', [ReportController::class, 'addReport']);
Route::post('/login', [PoliceUserController::class, 'login']);

// update
Route::patch('/update-status/{id}', [ReportController::class, 'updateStatus']);

// getting the reports
Route::get('/report-list', [ReportController::class, 'reportList']);
Route::get('/report/{id}', [ReportController::class, 'reportById']);

Route::get('/report-type', [ReportTypeController::class, 'report_type']);
Route::get('/sub-divisions', [SubDivisionController::class, 'sub_divisions']);
Route::get('/notifiction', [NotificationController::class, 'notification']);

// logout api
Route::post('/logout', [UserController::class, 'logout']);

// asset route
Route::get('/image-file/{slug}', [ReportController::class, 'showImage'])->middleware('auth:sanctum');
Route::get('/video-file/{slug}', [ReportController::class, 'showVideo'])->middleware('auth:sanctum');
Route::get('/audio-file/{slug}', [ReportController::class, 'showAudio'])->middleware('auth:sanctum');

Route::post('/otp-verify', [UserController::class, 'OTPVerify']);

Route::get('/dashboardCount', [ReportController::class, 'dashboardCount']);
Route::get('/filteredReports', [ReportController::class, 'filteredReports']);

Route::post('/updatePoliceAssets/{id}', [ReportController::class, 'updatePoliceAssets']);
