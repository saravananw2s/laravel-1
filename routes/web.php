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
    return view('welcome');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/dash', function () {
    return view('dashboard');
});

Route::post('/signup',"AppControllers@signup");
Route::post('/signin',"AppControllers@login");
Route::post('/placeorder',"AppControllers@postOrder");
Route::get('/showOrders',"AppControllers@showOrders");
Route::post('/stschage',"AppControllers@stschage");


