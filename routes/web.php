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


//EMAIL VERIFICATION
Route::prefix('email')->group(function () {
    Route::view('verify', 'auth.verify-email')->middleware('auth')->name('verification.notice');
    Route::post('verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});

//Payments
Route::get('payment', 'PaymentController@payment');
Route::get('ipay/callback', 'PaymentController@callback');
Route::get('express-checkout', 'PaypalController@getExpressCheckout');
Route::get('express-checkout-success', 'PayPalController@getExpressCheckoutSuccess');
Route::post('paypal/ipn', 'PayPalController@postNotify');

//User Links
Route::prefix('user')->middleware(['auth'])->group(function () {
    Route::get('profile', 'UserController@show')->name('profile.show');
    Route::patch('{user}/update-profile', 'UserController@update')->name('profile.update');
    Route::get('change-password', 'UserController@passwordChange')->name('change.password');
    Route::post('change-password', 'UserController@updatePassword')->name('update.password');
    Route::get('read/{slug}', 'MagazineController@show');
});

//Admin Links
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('file-manager', 'FileManagerController@index')->name('manage.magazines');
    Route::view('subscription-plans', 'admin.subscription-plans')->name('manage.plans');
});

Route::view('/dashboard', 'dashboard')->middleware(['auth'])->name('dashboard');

//Unauth Pages
Route::view('/', 'welcome')->name('landing.page');
Route::view('/choose/plan', 'choose-plan')->name('choose.plan');
Route::view('/subscribe/plan', 'selected-plan')->name('subscribe.plan');

//Socialite Login
Route::prefix('auth')->group(function () {
    Route::get('/{key}/redirect', 'SocialiteController@redirect')->name('socialite');
    Route::get('/{key}/callback', 'SocialiteController@callback');
});

require __DIR__ . '/auth.php';
