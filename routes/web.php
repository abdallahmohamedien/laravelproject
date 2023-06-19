<?php

use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Illuminate\Support\Facades\Auth;


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

Route::get('/', function () {
    return view('dashboard.index');
});



Route::group(['prefix'=>'dashboard', 'as' => 'dashboard.' , 'middleware'=>['auth','checkLogin']], function(){

    Route::get('/', function(){
        return view('dashboard.layouts.layout');
    })->name('settings');

    Route::get('/settings', function(){
        return view('dashboard.settings');
    })->name('settings');

    Route::post('/settings/update/(setting)', [SettingController::class , 'update'])->name('settings.update');

    //Route::resource([
        //'users' => UserController::class,
    //]);
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
