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

Route::get('/', function () {
    return view('index');
})->middleware('nonAdmin');

Route::get('company/{url}/{id}',function(){
   return view('company');
})->middleware('nonAdmin');

Route::get('searchList/{url}',function(){
    return view('searchList');
})->middleware('nonAdmin');

Route::get('addSalary',function(){
    return view('addSalary');
})->middleware('user');

Route::get('addReview',function(){
    return view('addReview');
})->middleware('user');

Route::get('feeds',function(){
    return view('feeds');
})->middleware('user');

Route::get('settings',function(){
    return view('settings');
})->middleware('user');

Route::get('chat/{id}',function(){
    return view('chat');
})->middleware('chatable');

Route::get('chatList',function(){
    return view('chatList');
})->middleware('admin');

Route::get('addCompany',function(){
    return view('addCompany');
})->middleware('admin');

Route::get('login','UserController@doLogin');
Route::get('logout','UserController@doLogout');
Route::get('checkLogin','UserController@checkLogin');
Route::get('test','TestController@test');
Route::post('changePicture','UserController@changeProfilePicture');
