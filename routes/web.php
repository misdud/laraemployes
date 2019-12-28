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

use App\Deputy;

Route::get('/', function () {
    return view('welcome');
});
 Route::get('/test', function (){
     $deputys = App\Deputy::pluck('id')->all();

     dump($deputys);
     exit();
 });