<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */



Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/', function () {
    return redirect('/home');
});
Route::get('/getAllNews', 'HomeController@getAllNews');
Route::get('/news/{id}', 'HomeController@news');
Route::post('/export_file', 'HomeController@exportFile');
Route::get("/scrapwebsite", 'WebscrapController@index');
