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


    Route::get('/edit', [
        'uses' => 'PostController@postEditPost',
        'as' => 'edit'
    ]);




    Route::post('/userSend', [
        'uses' => 'PostController@userSendId',
        'as' => 'userSend'
    ]);



    Route::get('/createPostUser', [
        'uses' => 'PostController@postCreatePostUser',
        'as' => 'post.Create.User',

    ]);

    Route::get('/userlink', [
        'uses' => 'PostController@postCreatePostUser',
        'as' => 'userlink'
    ]);
    Route::get('/imagesAll', [
        'uses' => 'PostController@userAllImage',
        'as' => 'userImage'
    ]);





    Route::get('/account', [
        'uses' => 'UserController@getAccount',
        'as' => 'account'
    ]);


    Route::post('/editAccount', [
        'uses' => 'UserController@editAccount',
        'as' => 'edit.account'
    ]);


    Route::get('/image', [
        'uses' => "UserController@editAccount",
        'as' => 'GetImage'
    ]);

    Route::get('/imageId', [
        'uses' => "PostController@profileImage",
        'as' => 'imageId'
    ]);
    Route::post('/addFriend', [
        'uses' => "PostController@addFriend",
        'as' => 'addFriend'
    ]);
    Route::post('/sendMessage', [
        'uses' => "PostController@sendMessage",
        'as' => 'sendMessage'
    ]);
    Route::post('/inbox', [
        'uses' => "PostController@inbox",
        'as' => 'inbox'
    ]);
    Route::post























    ('/showMessage', [
        'uses' => "PostController@showMessage",
        'as' => 'show.message'
    ]);
});

