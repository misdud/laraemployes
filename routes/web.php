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

use App\Department;
use App\Employe;
use App\Position;
use App\Deputy;

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function () {
    $deputys = Deputy::where('id_director', 3)
    ->with('position', 'director')
    ->get();

    dump($deputys);
    exit();

});


Auth::routes();
//--any - for 1 page  (SPA)
Route::get('/{any}', 'HomeController@index')->where('any', '.*');

//Route::get('/home', 'HomeController@index')->name('home');
