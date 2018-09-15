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
Route::post('/empsignup',"AppControllers@empsignup");
Route::post('/placeorder',"AppControllers@postOrder");
Route::get('/getitem',"AppControllers@items");
Route::get('/history',"AppControllers@history");
Route::get('/editprofile',"AppControllers@editprofile");
Route::post('/showOrders',"AppControllers@showOrders");
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

Route::post('/showmyorderhistory',"AppControllers@showmyorderhistory");

Route::post('/close',"AppControllers@close");
Route::post('delivery',"AppControllers@delivery");
Route::post('/offers',"AppControllers@offers");
Route::post('/showoffers',"AppControllers@showoffers");
Route::post('/pincode',"AppControllers@pincode");
Route::post('/stores',"AppControllers@stores");
Route::post('/userinfo',"AppControllers@userinfo");
Route::post('/showmyoffers',"AppControllers@showmyoffers");
Route::post('/uploadfile',"AppControllers@uploadfile");
Route::get('/showstores',"NewController@showstores");
Route::get('/showemployees',"NewController@showemployees");
Route::get('/showpincodes',"NewController@showpincodes");
Route::get('/waiting',"NewController@waiting");
Route::get('/approve',"NewController@approve");
Route::get('/delstores',"DeleteController@delstores");
Route::get('/delpincodes',"DeleteController@delpincodes");
Route::get('/dleshowstores',"DeleteController@dleshowstores");
Route::post('/storelogin',"NewController@storelogin");
Route::post('/showstoreorders',"NewController@showstoreorders");
Route::post('/dispatch',"NewController@prodispatch");
Route::post('/emppay',"NewController@emppay");

Route::post('/delivery',"AppControllers@delivery");
Route::post('/undelivery',"AppControllers@undelivery");

Route::post('/paystore',"NewController@paystore");
Route::post('/transaction',"NewController@transaction");

Route::post('/storehistory',"AppControllers@storehistory");


Route::get('/shareid',"AppControllers@shareid");

