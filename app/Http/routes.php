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
    Route::get('/', function () {
        return view('welcome');
    })->name('home');
    Route::post('/registration', ['uses' => 'UserController@registration',
        'as' => 'registration'
    ]);
    Route::post('/login', ['uses' => 'UserController@login',
        'as' => 'login'
    ]);
    Route::get('/signIn', ['uses' => 'PostController@getSignIn',
        'as' => 'signIn',
        'middleware' => 'auth'
    ]);


    Route::post('/createPost', [
        'uses' => 'PostController@postCreatePost',
        'as' => 'post.Create',
        'middleware' => 'auth'
    ]);
    Route::get('/delete-post/{post_id}', [
        'uses' => 'PostController@getDeletePost',
        'as' => 'post.delete',
        'middleware' => 'auth'
    ]);


    Route::get('/logOut', [
        'uses' => 'UserController@getLogOut',
        'as' => 'logout'
    ]);


    Route::post('/edit', [
        'uses' => 'PostController@postEditPost',
        'as' => 'edit'
    ]);




    Route::get('/userSend', [
        'uses' => 'PostController@userSendId',
        'as' => 'userSend'
    ]);



    Route::get('/createPostUser', [
        'uses' => 'PostController@postCreatePostUser',
        'as' => 'post.Create.User',

    ]);



});

