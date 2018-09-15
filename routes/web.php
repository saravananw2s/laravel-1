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
Route::get('/offer', function () {
    return view('login');
});
Route::get('/about.html', function () {
    return view('about');
});
Route::get('/elements.html', function () {
    return view('ship');
});
Route::get('/contact.html', function () {
    return view('contact');
});
Route::get('zohoverify/verifyforzoho.html',function (){
return "1535721928169";
});

Route::post('/signup',"AppControllers@signup");
Route::post('/signin',"AppControllers@login");
Route::post('/placeorder',"AppControllers@postOrder");
Route::get('/items',"AppControllers@items");
//Route::get('/showOrders',"AppControllers@showOrders");
Route::post('/stschage',"AppControllers@stschage");


