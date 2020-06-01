<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//email verification
Route::get('/email/resend', 'Api\VerificationController@resend')->name('verification.resend');
Route::get('/email/verify/{id}/{hash}', 'Api\VerificationController@verify')->name('verification.verify');
Route::get('/verified-only', function( Request $request){
    dd('you are verified', $request->user()->username);
})->middleware('auth:api', 'verified');
//user register, login and logout
Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');
Route::middleware('auth:api')->group(function () {
    Route::get('/logout', 'Api\AuthController@logout')->name('logout');
});
//password resets
Route::post('/password/email', 'Api\ForgotPasswordController@SendResetLinkEmail');
Route::post('/password/reset', 'Api\ResetPasswordController@resetsPasswords');
//users routes
Route::apiResource('/users', 'Api\UserController')->middleware('auth:api','verified');
//product routes
Route::apiResource('/products', 'Api\ProductsController')->middleware('auth:api','verified');
//provider routes
Route::apiResource('/providers', 'Api\ProvidersController')->middleware('auth:api','verified');
//search
Route::post('/search', 'Api\SearchController@search')->middleware('auth:api');;
