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
// 首頁
Route::get('/', 'HomeController@home');
Route::get('/search', 'HomeController@searchTour');
// 管理者
// Route::group(['prefix' => 'admin'], function(){
//         Route::get('/sign-up', 'AdminController@signUpPage');
//         Route::post('/sign-up', 'AdminController@signUpProcess');
//         Route::get('/sign-in', 'AdminController@signInPage');
//         Route::post('/sign-in', 'AdminController@signInProcess');
//         Route::get('/sign-out', 'AdminController@signOut');
// });

// 使用者
Route::group(['prefix' => 'user'], function(){
    Route::get('/sign-up', 'UserController@signUpPage');
    Route::post('/sign-up', 'UserController@signUpProcess');
    Route::get('/sign-in', 'UserController@signInPage');
    Route::post('/sign-in', 'UserController@signInProcess');
    // Route::get('/sign-in', 'UserController@signInPage');
    Route::get('/sign-out', 'UserController@signOut');

    Route::group(['middleware' => 'auth.user'], function(){
        Route::get('/{id}', 'UserController@profilePage');
        Route::put('/{id}', 'UserController@updateProfile');
        Route::get('/{id}/booking-list', 'UserController@toursPage');
        Route::get('/{id}/wish-list', 'UserController@wishListPage');
        Route::post('/{id}/wish-list', 'UserController@addWishList');
    });
});

Route::group(['prefix' => 'tour'], function(){
    // Route::get('/', 'TravelController@createTour');
    // Route::get('/{id}/edit', 'TravelController@tourItemEditPage');
    Route::get('/tour-list/{search}', 'TravelController@searchTour');
    Route::get('/{id}', 'TravelController@tourPage');
    // Route::put('/{id}', 'TravelController@updateTour');
});

Route::group(['prefix' => 'transaction', 'middleware' => 'auth.user'], function(){
    Route::post('/', 'TransactionController@bookingTour');
    // Route::get('/', 'TransactionController@bookingPage');
    // Route::post('/', 'TransactionController@createBooking');
    // Route::get('/{id}', 'TransactionController@bookingResult');
    Route::get('/{id}/comment', 'TransactionController@commentPage');
    Route::post('/{id}/comment', 'TransactionController@postComment');
});
