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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/threads/create','ThreadController@create');
Route::get('/threads','ThreadController@index');
Route::post('/threads','ThreadController@store');
Route::get('/threads/{channel}','ThreadController@index');
Route::get('/threads/{channel}/{thread}','ThreadController@show');
Route::delete('/threads/{channel}/{thread}','ThreadController@destroy');
//Route::resource('threads','ThreadController');
Route::post('/threads/{thread}/replies','ReplyController@store');
Route::delete('/replies/{reply}','ReplyController@delete');
Route::patch('/replies/{reply}','ReplyController@update');
Route::post('/replies/{reply}/favorites','FavoritesController@store');
Route::delete('/replies/{reply}/favorites','FavoritesController@delete');

Route::get('/profiles/{user}','ProfileController@show')->name('profile');




