<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', 'Twitter@get')->name('top')->middleware('checkedtop');

Route::get('/twitter', 'Auth\TwitterLoginController@redirectToProvider')->name('login')->middleware('checkedtop');
Route::get('/auth/twitter/callback', 'Auth\TwitterLoginController@handleProviderCallback')->middleware('checkedtop');
Route::get('/logout', 'Auth\TwitterLogoutController@getLogout')->name('logout')->middleware('checkedlogin');

Route::get('/calendar', 'CalendarController@index')->name('calendar')->middleware('checkedlogin');


Route::get('/getdata', 'Twitter@welcome');
