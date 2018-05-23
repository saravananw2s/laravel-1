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
Route::post('/adminsignin',"AppControllers@adminsignin");

Route::post('/placeorder',"AppControllers@postOrder");
Route::get('/getitem',"AppControllers@items");
Route::get('/history',"AppControllers@history");
Route::get('/editprofile',"AppControllers@editprofile");
Route::get('/showOrders',"AppControllers@showOrders");
Route::post('/stschage',"AppControllers@stschage");
Route::get('/showuser',"AppControllers@showusers");
Route::post('/updateprice',"AppControllers@updateprice");
Route::post('/ordershistory',"AppControllers@ordershistory");
Route::post('/resetpass',"AppControllers@resetpass");
Route::post('/assign',"AppControllers@assign");
Route::post('/emplogin',"AppControllers@emplogin");

Route::post('/emp',"AppControllers@emp");
Route::post('/showmyorders',"AppControllers@showmyorder");
Route::post('/reset',"AppControllers@reset");
Route::post('/showslot',"AppControllers@showslat");

Route::post('/close',"AppControllers@close");
Route::post('delivery',"AppControllers@delivery");
Route::post('/offers',"AppControllers@offers");
Route::post('/showoffers',"AppControllers@showoffers");

