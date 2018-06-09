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
Route::post('upload/multiple','ArticleController@uploadMultiple');

Route::group(['middleware'=>'api-lang'], function () {

   	Route::get('category','ApiCategoryController@index');
	Route::get('city','ApiCityController@index');
	Route::get('content','ApiContentController@index');
	Route::get('content/detail','ApiContentController@show');

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
