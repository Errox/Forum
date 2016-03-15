<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect('/topic');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    //Topic route
    Route::resource('/topic', 'TopicController');
    //Comment route
    Route::resource('/comment', 'CommentController',
    	['only' => ['store', 'destroy']]);
    //Directing to homepage
    Route::get('/home', 'HomeController@index');
    //Searchbar post route
    Route::post('/search', 'SearchController@index');
    //Subscribe resource
    Route::resource('/subscribe', 'SubscriptionController');
});
