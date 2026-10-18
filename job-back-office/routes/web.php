<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JopApplicationController;
use App\Http\Controllers\JopCatrgoryController;
use App\Http\Controllers\JopVancancyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//sahre Routes
Route::middleware(['auth', 'role:admin,company-owner'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    //job-applications
    Route::resource('job-applications', JopApplicationController::class);
    Route::put('job-applications/{id}/restore', [JopApplicationController::class, 'restore'])->name('job-applications.restore');

    //job-vacancies
    Route::resource('job-vacancies', JopVancancyController::class);
    Route::put('job-vacancies/{id}/restore', [JopVancancyController::class, 'restore'])->name('job-vacancies.restore');

});

//Company Routes
Route::middleware(['auth', 'role:company-owner'])->group(function () {
    Route::get('/my-company',[CompanyController::class,'show'])->name('my-company.show');
    Route::get('/my-company/edit',[CompanyController::class,'edit'])->name('my-company.edit');
    Route::put('/my-company',[CompanyController::class,'update'])->name('my-company.update');

});


//Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    //job-categorise
    Route::resource('job-categorise', JopCatrgoryController::class);
    Route::put('job-categorise/{id}/restore', [JopCatrgoryController::class, 'restore'])->name('job-categorise.restore');
    //user
    Route::resource('user', UserController::class);
    Route::put('user/{id}/restore', [UserController::class, 'restore'])->name('user.restore');
    //companies
    Route::resource('companies', CompanyController::class);
    Route::put('companies/{id}/restore', [CompanyController::class, 'restore'])->name('companies.restore');

});

require __DIR__.'/auth.php';
