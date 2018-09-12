<?php

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

Route::get('/','PagesController@root')->name('root');

/** 认证路由 */
Route::get('login', 'Auth\OAuthLoginController@login')->name('login');
Route::get('callback', 'Auth\OAuthLoginController@callback')->name('callback');
Route::post('logout', 'Auth\OAuthLoginController@logout')->name('logout');