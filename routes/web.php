<?php

use App\Http\XboxApi\getachievements;
use App\Http\XboxApi\getuserid;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestsController;

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
    return view('welcome');
});

Auth::routes(['verify' => true]);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::view('/welcome', 'welcome');
Route::view('/aboutus', 'aboutus');
Route::get('/steamapitests', [TestsController::class, 'index'])->name('steamapitests');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Xbox Api Routs

Route::view('/userid', 'xuid');
Route::get('/gamertag', [getuserid::class, 'getData',])->name('gamertag.getData');
Route::view('/achievements', 'xProfile');
Route::get('/xboxprofile', [getachievements::class, 'achievements'])->name('Profile.index');
