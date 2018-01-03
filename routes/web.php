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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Routes to add/remove subscribers from Bunch Forms
Route::get('bunch/remove_subscriber/{bunch},{subscriber}', 'BunchController@removeSubscriber')->name('bunch.removeSubscriber');
Route::post('bunch/add_subscriber/{bunch}', 'BunchController@addSubscriber')->name('bunch.addSubscriber');

// Routes to add to/remove from bunches from Subscriber Forms
Route::get('subscriber/remove_from_bunch/{subscriber},{bunch}', 'SubscriberController@removeFromBunch')->name('subscriber.removeFromBunch');
Route::post('subscriber/add_to_bunch/{subscriber}', 'SubscriberController@addToBunch')->name('subscriber.addToBunch');

Route::group(['middleware' => ['auth']], function (){
    Route::resource('subscriber', 'SubscriberController');
    Route::resource('template', 'TemplateController');
    Route::resource('bunch', 'BunchController');
});
