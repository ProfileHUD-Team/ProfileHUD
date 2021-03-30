<?php

use App\XboxApi\getachievements;
use App\XboxApi\getuserid;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestsController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\SteamPagesController;


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

Route::get('/a/create', [AccountsController::class, 'create']);
Route::post('/a', [AccountsController::class, 'store']);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::view('/welcome', 'welcome');
Route::view('/aboutus', 'aboutus');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Steam API Pages

Route::get('/steamapitests', [TestsController::class, 'index'])->name('steamapitests');
Route::get('/steamlogin', [SteamPagesController::class, 'steamLogin'])->name('steamlogin');
Route::get('/steamredirect', [SteamPagesController::class, 'steamRedirect'])->name('steamredirect');
Route::get('/steamlinked', [SteamPagesController::class, 'steamLinked'])->name('steamlinked');
// Xbox Api Routs
Route::view('/userid', 'xboxUserId');
Route::get('/gamertag', [getuserid::class, 'getData',])->name('gamertag.getData');
Route::get('/xboxprofile', [getachievements::class, 'achievements'])->name('Profile.index');

