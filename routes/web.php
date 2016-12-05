<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use Illuminate\Support\Facades\Auth;

$languages = array('vn', 'en');
$locale = Request::segment(1);
if(in_array($locale,$languages)){
    App::setLocale($locale);
} else {
    $locale = null;
}

Route::group(['prefix' => $locale],function(){
    
    Route::get('/', function () {
        return view('welcome');
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::resource('users', 'UsersController', [
            'names' => [
                'create' => 'users.add',
            ],
        ]);
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/set','UsersController@setCookie')->name('set');
Route::get('/get','UsersController@getCookie')->name('get');

Route::group(['prefix' => 'api','middleware'=>['api']],function(){
    Route::get('/csrf',function(){
        header('Access-Control-Allow-Origin: *');
        return response()->json(['message' => 'success','csrf' => csrf_token()],200);
    });

    Route::resource('jokes', 'JokesController');

    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
    Route::get('authenticate/user', 'AuthenticateController@getAuthenticatedUser');
});

Route::resource('comments','CommentsController');