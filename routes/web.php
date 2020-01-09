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

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function () {
    $departamentId = Department::select('id')->where('name_head_depart', 'Фёдор Алексеевич Белоусовa')->first();
    dump($departamentId->id); 
});


Auth::routes();
//--any - for 1 page  (SPA)
Route::get('/{any}', 'HomeController@index')->where('any', '.*');

//Route::get('/home', 'HomeController@index')->name('home');


