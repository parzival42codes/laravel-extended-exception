<?php

namespace parzival42codes\LaravelUnittestView;

use Illuminate\Support\Facades\Route;
use parzival42codes\LaravelExtendedException\App\Controllers\DashboardController;

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

Route::middleware(['web', 'auth'])
    ->group(function () {
        Route::get('extended-exception', [DashboardController::class, 'index'])
            ->name('extended-exception.dashboard');

        Route::post('extended-exception', [DashboardController::class, 'index'])
            ->name('extended-exception.dashboard.work');
    });
