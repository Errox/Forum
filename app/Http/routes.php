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
    //Directing to homepage
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

    //Topic route.
    Route::resource('/topic', 'TopicController');
    
    //Search route
    Route::post('/search', 'SearchController@index',
        ['only' => ['index']]);

    //Tag route
    Route::resource('/tag', 'TagController');

    //Comment route
    Route::resource('/comment', 'CommentController',
        ['only' => ['store', 'destroy']]);
  
    //Subscribe resource
    Route::resource('/subscribe', 'SubscriptionController');
});
