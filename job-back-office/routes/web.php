<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JopApplicationController;
use App\Http\Controllers\JopCatrgoryController;
use App\Http\Controllers\JopVancancyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    //companies
    Route::resource('companies', CompanyController::class);
    Route::put('companies/{id}/restore', [CompanyController::class, 'restore'])->name('companies.restore');
    //job-applications
    Route::resource('job-applications', JopApplicationController::class);
    Route::put('job-applications/{id}/restore', [JopApplicationController::class, 'restore'])->name('job-applications.restore');
    //job-categorise
    Route::resource('job-categorise', JopCatrgoryController::class);
    Route::put('job-categorise/{id}/restore', [JopCatrgoryController::class, 'restore'])->name('job-categorise.restore');
    //job-vacancies
    Route::resource('job-vacancies', JopVancancyController::class);
    Route::put('job-vacancies/{id}/restore', [JopVancancyController::class, 'restore'])->name('job-vacancies.restore');
    //user
    Route::resource('user', UserController::class);
    Route::put('user/{id}/restore', [UserController::class, 'restore'])->name('user.restore');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
