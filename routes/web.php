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
// Index
Route::group(['middleware'=> 'throttle:30,1'], function(){
    Route::get('/', 'HomeController@index');
    Route::get('/search', 'HomeController@searchTour');
});

// User
Route::group(['middleware'=> 'throttle:30,1'], function(){
    Route::get('/sign-up', 'UserController@signUpPage');
    Route::post('/sign-up', 'UserController@signUpProcess');
    Route::post('/sign-in', 'UserController@signInProcess');
    Route::get('/sign-out', 'UserController@signOut');
});

Route::group(['prefix' => 'users','middleware'=>['auth.user','throttle:30,1']], function(){
        Route::get('/{id}', 'UserController@profilePage');
        Route::put('/{id}', 'UserController@updateProfile');
        Route::get('/{id}/orders', 'UserController@toursPage');
        Route::get('/{id}/favorite-tours', 'UserController@favoriteToursPage');
        Route::post('/{id}/favorite-tours', 'UserController@addFavoriteTour');
});

//Tour
Route::group(['middleware'=> 'throttle:30,1'], function(){
    Route::get('/tours{search?}', 'TravelController@searchTour');
    Route::get('tours/{id}', 'TravelController@tourPage');
});
//Order
Route::post('/order', 'TransactionController@orderTour')->middleware(['auth.user','throttle:30,1']);
Route::group(['prefix' => 'orders', 'middleware' => ['auth.user','throttle:30,1']], function(){
    Route::get('/{id}/comment', 'TransactionController@commentPage');
    Route::post('/{id}/comment', 'TransactionController@postComment');
});
