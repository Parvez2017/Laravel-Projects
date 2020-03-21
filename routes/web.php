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

Route::get('/' ,'HomeController@index')->name('home');

Auth::routes();



Route::group(['as'=>'admin.','prefix'=>'admin', 'namespace'=>'admin','middleware'=>['auth', 'admin'] ],function(){

  Route::get('dashboard', 'AdminDashboardController@index')->name('dashboard');
  Route::resource('tag','TagController');
  Route::resource('category', 'CategoryController');
  Route::resource('post', 'PostController');


});

Route::group(['as'=>'author.','prefix'=>'author', 'namespace'=>'author','middleware'=>['auth', 'author'] ],function(){

    Route::get('dashboard', 'AuthorDashboardController@index')->name('dashboard');
    Route::resource('post','UserController');

});