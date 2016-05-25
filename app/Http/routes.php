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

//alleen bij kunnen als je ingelogt bent
Route::group(['middleware' => 'web'], function () {
    Route::auth();
    
    Route::get('/queue/ajax', 'QueueController@ajax');
    Route::resource('/queue', 'QueueController');



	Route::resource('/topic', 'TopicController');
    Route::post('/topic/close', 'TopicController@close');
    Route::post('/search', 'SearchController@index',
        ['only' => ['index']]);
    
        //alles waar je alleen bij kan met speciale rechten 
        Route::group(['middleware' => 'role'], function(){
            Route::resource('/beheer', 'RoleController');
                //Tag route
            Route::resource('/tag', 'TagController');

            Route::resource('/csv', 'CsvController');


            Route::resource('/event', 'EventController');
        });

    //View profile
    Route::resource('/profile', 'ProfileController');

    //Notification route
    Route::resource('/notificaties', 'NotificationController');

    //Topic route.
    Route::resource('/topic', 'TopicController');
    
    //Search route
    Route::post('/search', 'SearchController@index',
        ['only' => ['index']]);

    //Comment route
    Route::resource('/comment', 'CommentController',
        ['only' => ['store', 'destroy']]);
  
    //Subscribe resource
    Route::resource('/subscribe', 'SubscriptionController');

    //Event route
    Route::resource('/event', 'EventController',
        ['only' => ['index']]);
});
