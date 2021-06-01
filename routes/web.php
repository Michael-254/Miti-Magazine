<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('/', function () {
    return view('welcome');
})->name('landing.page');

Route::prefix('user')->middleware(['auth'])->group(function () {
    Route::get('profile', 'UserController@show')->name('profile.show');
    Route::patch('{user}/update-profile', 'UserController@update')->name('profile.update');
    Route::get('change-password', 'UserController@passwordChange')->name('change.password');
    Route::post('change-password', 'UserController@updatePassword')->name('update.password');;
    Route::get('payment', 'PaymentController@payment');
    Route::get('file-manager', 'FileManagerController@index');
});

Route::get('/read', 'MagazineController@show');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/choose/plan', function () {
    return view('choose-plan');
})->name('choose.plan');

Route::get('/subscribe/plan', function () {
    return view('selected-plan');
})->name('subscribe.plan');

Route::prefix('auth')->group(function () {
    Route::get('/{key}/redirect', [App\Http\Controllers\SocialiteController::class, 'redirect'])->name('socialite');
    Route::get('/{key}/callback', [App\Http\Controllers\SocialiteController::class, 'callback']);
});

require __DIR__ . '/auth.php';
