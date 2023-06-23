<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\CountryController;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Route;
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


// Route::get('/', [GameController::class, 'show']);


Route::get('/login',function () {
    if (!Auth::user()) {
        return view('login');
    } else {
        return redirect('start');
    }
    return;
})->name('login');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [GameController::class, 'show']);
    Route::resource('league', LeagueController::class);
    Route::resource('country', CountryController::class);
    Route::get('/country/{country_id}/sport/{sport}', [CountryController::class, 'show'])->name('sport.show');
});

// Route::group(function () {
//     if (Auth::user()) {
//         Route::get('/start', [GameController::class, 'show']);
//         Route::resource('league', LeagueController::class);
//         Route::resource('country', CountryController::class);
//         Route::get('/country/{country_id}/league/{league_id}', [LeagueController::class, 'show']);
//     } else {
//         redirect('/');
//     }
// });

Route::get('auth/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('auth/google/callback', function () {
    $user = Socialite::driver('google')->user();
    $database = User::firstOrCreate([
        'email' => $user->getEmail(),
        'name' => $user->getName(),
        'google_id' => $user->getId(),
    ]);
    Auth::login($database);
    return redirect('/');
});
