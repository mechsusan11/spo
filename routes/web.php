<?php

use App\Http\Controllers\PoliceUserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportTypeController;
use App\Http\Controllers\SubDivisionController;
use App\Models\PoliceUser;
use App\Models\ReportModel;
use App\Models\SubDivisionModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;


Route::get('/login', [PoliceUserController::class, 'getLoginPage'])->name('login.page');
Route::post('/login', [PoliceUserController::class, 'getAuthenticate'])->name('login.check');

Route::get('/dashboard', function () {
    // dd(Gate::allows('isAdmin'));
    // if (Gate::allows('isAdmin')) {
    dd(Auth::guard('police_users')->user());
    if (Auth::guard('police_users')->user()) {
        $reports = ReportModel::all();
        return view('dashboard.main', compact('reports'));
    } else {
        return redirect()->route('login.page');
    }
    // } else {
    //     return response('Only admin can access this page!', 200);
    // }
})->name('admin.dashboard')->middleware('web','IsAdmin');

// adduser route
Route::get('/adduser', function () {
    $sub_divisions = SubDivisionModel::orderBy('id', 'asc')->get();
    return view('pages.adduser', compact('sub_divisions'));
});

// list user
Route::get('/listuser', function () {
    $users = PoliceUser::all();
    return view('pages.listuser', compact('users'));
});

// get report list
Route::get('/getReportList', function () {
    $reports = ReportModel::with(['reportType', 'subDivision'])
        ->where('sub_division_mismatch', 0)
        ->orderBy('report_id', 'desc')
        ->get();
    return view('pages.reportlist', compact('reports'));
});

// get report by id
Route::get('/reports/{id}', [ReportController::class, 'showReport'])->name('reports.view');

// master table
Route::get('/report-type', [ReportTypeController::class, "getReportTypes"])->name('reportType.master');
Route::get('/appConfigMessage', [ReportController::class, 'getAppConfigMessage'])->name('appConfigMessage.master');

// add

Route::get('/sub-division', [SubDivisionController::class, "getSubDivisions"])->name('subdivision.master');

Route::get('/subDivisionMismatchList', [ReportController::class, 'getSubDivMismatchList'])->name('reports.subdivmismatchlist');
Route::get('/subDivisionMismatchView/{id}', [ReportController::class, 'getSubDivMismatchView'])->name('reports.subdivmismatchview');

Route::post('/addSubdivisions', [SubDivisionController::class, 'addSubdivisions'])->name('subdivision.add');
Route::post('/addUserCheck', [PoliceUserController::class, 'addPoliceUserUi'])->name('register.user');
Route::post('/subDivisionMismatch', [ReportController::class, 'updateSubDivision'])->name('reports.updateSubDivision');

// Auth::routes();
