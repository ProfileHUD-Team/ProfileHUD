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


Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::view('/welcome', 'welcome');
Route::view('/aboutus', 'aboutus');

//Account Adding Pages
Route::get('/a/create', [AccountsController::class, 'create']);
Route::post('/a', [AccountsController::class, 'store']);

//Game adding pages
Route::get('/g/create/platform={platform}&id={id}', [\App\Http\Controllers\GamesController::class, 'create'])->name('g.create');
Route::post('/g', [\App\Http\Controllers\GamesController::class, 'store']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Steam API Pages

Route::get('/steamapitests', [TestsController::class, 'index'])->name('steamapitests');
Route::get('/steamlogin', [SteamPagesController::class, 'steamLogin'])->name('steamlogin');
Route::get('a/steamredirect', [SteamPagesController::class, 'steamRedirect'])->name('steamredirect');
Route::get('a/steamlinked', [SteamPagesController::class, 'steamLinked'])->name('steamlinked');

// Xbox Api Routs
Route::view("xboxlink",'xboxlink');
Route::view('/userid', 'xboxUserId');
Route::get('/gamertag', [getuserid::class, 'getData',])->name('gamertag');
Route::get('/xboxprofile', [getachievements::class, 'achievements'])->name('xboxprofile');

