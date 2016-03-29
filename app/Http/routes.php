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
	//Topic via Home
Route::get('/', function () {
    return redirect('/topic');
});
    //Topic route
Route::resource('/topic', 'TopicController',
		['only' => ['index']]);

    //Searchbar post route
Route::post('/search', 'SearchController@index',
		['only' => ['index']]);



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


Route::group(['middleware' => 'web'], function () {
    Route::auth();
	Route::resource('/topic', 'TopicController');
	Route::post('/search', 'SearchController@index',
		['only' => ['index']]);
	
Route::group(['middleware' => 'role'], function(){
	Route::resource('/beheer', 'RoleController');
});


    //Comment route
    Route::resource('/comment', 'CommentController',
    	['only' => ['store', 'destroy']]);
    //Directing to homepage
    //Subscribe resource
    Route::resource('/subscribe', 'SubscriptionController');
});
