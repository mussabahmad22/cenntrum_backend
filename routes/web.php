<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\WebController;
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

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/', function () {

    return view('auth.login');
})->middleware('BusinessLogin');

Route::get('/dashboard', [BusinessController::class, 'dashboard'])->middleware('Bussiness');
Route::get('/', [BusinessController::class, 'dashboard'])->name('dashboard')->middleware('Bussiness');
Route::post('/login', [BusinessController::class, 'login'])->name('login_business');
Route::get('/admin_logout', [BusinessController::class, 'logout'])->name('admin_logout');

Route::get('/giftcards', [BusinessController::class, 'business_list'])->name('giftcards')->middleware('BusinessLogin');
Route::get('/giftcards/{id}', [BusinessController::class, 'giftcards_list'])->middleware('BusinessLogin');
Route::post('/used', [BusinessController::class, 'used'])->name('used');
Route::post('/redeem', [BusinessController::class, 'redeem'])->name('redeem');
Route::delete('/delete', [BusinessController::class, 'delete'])->name('delete');
Route::get('/test2', [WebController::class, 'test']);
Route::get('/send-mail', [WebController::class, 'test']);

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return 'Application cache has been cleared';
});

//Clear route cache:
Route::get('/route-cache', function () {
    Artisan::call('route:cache');
    return 'Routes cache has been cleared';
});

//Clear config cache:
Route::get('/config-cache', function () {
    Artisan::call('config:cache');
    return 'Config cache has been cleared';
});

// Clear view cache:
Route::get('/view-clear', function () {
    Artisan::call('view:clear');
    return 'View cache has been cleared';
});
