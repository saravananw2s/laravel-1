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


Route::post('/signup',"AppControllers@signup");
Route::post('/signin',"AppControllers@login");
Route::post('/placeorder',"AppControllers@postOrder");
Route::get('/getitem',"AppControllers@items");
Route::get('/history',"AppControllers@history");
Route::get('/editprofile',"AppControllers@editprofile");


