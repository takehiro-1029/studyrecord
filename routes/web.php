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
Route::get('/', 'Twitter@getTopPage')->name('top')->middleware('checkedtop');

Route::get('/twitter', 'Auth\TwitterLoginController@redirectToProvider')->name('login')->middleware('checkedtop');
Route::get('/demo', 'Auth\DemoLoginController@Login')->name('demo_login')->middleware('checkedtop');
Route::get('/auth/twitter/callback', 'Auth\TwitterLoginController@handleProviderCallback')->middleware('checkedtop');
Route::get('/logout', 'Auth\TwitterLogoutController@getLogout')->name('logout')->middleware('checkedlogin');

Route::get('/calendar', 'CalendarController@index')->name('calendar')->middleware('checkedlogin');
Route::get('/how_to_use', 'Twitter@getHowToUse')->name('how_to_use')->middleware('checkedlogin');

Route::get('/save_record', 'Twitter@getSavePage')->name('save_record')->middleware('checkedlogin');
Route::get('/edit_record/{id}', 'Twitter@getEditPage')->name('edit_record')->middleware('checkedlogin');
Route::get('/delete_record/{id}', 'Twitter@DeleteRecord')->name('delete_record')->middleware('checkedlogin');

Route::post('/save_record/{id?}','Twitter@SaveRecord')->middleware('checkedlogin');