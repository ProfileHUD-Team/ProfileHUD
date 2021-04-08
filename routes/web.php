<?php

use App\XboxApi\getachievements;
use App\XboxApi\xboxProfile;
use App\XboxApi\getuserid;
use App\xboxApi\records;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestsController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\SteamPagesController;
use App\Http\Controllers\GamePageController;

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
Route::view('/test', 'test');

//Account Adding Pages
Route::get('/a/create', [AccountsController::class, 'create']);
Route::post('/a', [AccountsController::class, 'store']);

//Game adding pages
Route::get('/g/create/platform={platform}&id={id}', [\App\Http\Controllers\GamesController::class, 'create'])->name('g.create');
Route::post('/g', [\App\Http\Controllers\GamesController::class, 'store']);

//Achievement adding pages
Route::get('/ach/create/platform={platform}&id={id}', [\App\Http\Controllers\AchievementsController::class, 'create'])->name('ach.create');
Route::post('/ach', [\App\Http\Controllers\AchievementsController::class, 'store']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// Steam API Pages

Route::get('/steamapitests', [TestsController::class, 'index'])->name('steamapitests');
Route::get('/steamlogin', [SteamPagesController::class, 'steamLogin'])->name('steamlogin');
Route::get('a/steamredirect', [SteamPagesController::class, 'steamRedirect'])->name('steamredirect');
Route::get('a/steamlinked', [SteamPagesController::class, 'steamLinked'])->name('steamlinked');

// Xbox Api Routes
Route::post('a/profile',[AccountsController::class,'getProfile'] );
//Route::view('/linkxbox','xboxlink');
//Route::get('/xboxid', [getuserid::class, 'getData',])->name('xboxid');
//Route::get('/xboxprofile', [xboxProfile::class, 'xboxProfile'])->name('xboxprofile');
//Route::get('/userprofile', [getachievements::class, 'achievements'])->name('userprofile');


// Display game information routes
Route::get('/steamgame/gameid={id}', [GamePageController::class, 'viewSteamGame']);
Route::get('/games/gameid={id}', [GamePageController::class, 'viewGame'])->name('gamepage');

