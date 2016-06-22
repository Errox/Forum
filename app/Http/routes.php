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


Route::get('/register', function () {
    return redirect('/login');
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

//alleen bij kunnen als je ingelogt bent
Route::group(['middleware' => 'web'], function () {
    //De route wordt gecheckd of de gebruiker is ingelogd
    Route::auth();
    Route::get('/register', function () {
    return redirect('/login');
});

    //Hier wordt de route actief en ajax naar toe gestuurd. Actief en ajax returnd een json format en reageerd als een api.
    Route::get('/queue/actief', 'QueueController@actief');
    Route::get('/queue/ajax', 'QueueController@ajax');
    Route::post('/queue/postcomment', 'QueueController@postcomment');

    //Topic close post
    Route::post('/topic/close', 'TopicController@close');
    
    //Search Post
    Route::post('/search', 'SearchController@index',
        ['only' => ['index']]);


    //View profile
    Route::resource('/profile', 'ProfileController');

    
    Route::post('/profileChange', 'ProfileController@passwordChange');

    //View results of every profile
    Route::resource('/result', 'ResultController');

    //Notification route
    Route::resource('/notificaties', 'NotificationController');

    //Topic route.
    Route::resource('/topic', 'TopicController');
    

    //Comment route
    Route::resource('/comment', 'CommentController',
        ['only' => ['store', 'destroy']]);
  
    //Subscribe resource
    Route::resource('/subscribe', 'SubscriptionController');

    //Event route
    Route::resource('/event', 'EventController');
    
    //Queue route    
    Route::resource('/queue', 'QueueController');
    

    Route::post('/queue/afhandeling', 'QueueController@afhandeling');


    //Topic route
    Route::resource('/topic', 'TopicController');

        //alles waar je alleen bij kan met speciale rechten 
        Route::group(['middleware' => 'role'], function(){
            
            //Beheer Route
            Route::resource('/beheer', 'RoleController');
            
            //Tag route
            Route::resource('/tag', 'TagController');

            //Csv Route
            Route::resource('/csv', 'CsvController');

            //Event route
          //  Route::resource('/event', 'EventController');
        });
});
