<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::patch('/resendEmail','UserController@resendEmail');
Route::post('/register','UserController@doRegister');
Route::get('/register/verify/{confirmation_code}','UserController@doVerify');
Route::post('/changePassword','UserController@changePassword');
Route::get('/company','CompanyController@getAll');
Route::get('/companyDetail/profile','CompanyController@getDetail');
Route::get('/companyDetail/salary','SalaryController@getSalaryForCompany');
Route::get('/companyDetail/review','ReviewController@getReviewForCompany');
Route::get('/companyDetail/jobs','JobController@getJobsForCompany');
Route::get('/checkFollow','FollowController@checkFollow');
Route::post('/follow','FollowController@follow');
Route::patch('/unfollow','FollowController@unfollow');
Route::post('/helpful','HelpfulController@helpful');
Route::patch('/delHelpful','HelpfulController@delHelpful');
Route::get('/salary','SalaryController@getSalary');
Route::get('/review','ReviewController@getReview');
Route::get('/jobs','JobController@getJobs');
Route::get('/getUser','UserController@getUserList');
Route::get('/getFeeds','FeedController@getFeeds');