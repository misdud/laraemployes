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

//use App\Deputy;
//
use App\Employe;
use App\Position;

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function (){
    $positionHeadDepartament = Position::select('id')
        ->where('name_position', 'Начальник отдела')->get();

    $emploues = Employe::with('position', 'department')
        ->where('id_positione','<>',$positionHeadDepartament)
        ->limit(10)
        ->get();
    dump($emploues);

});


//Route::redirect('/', '/login');

Route::get('/test3', function (){
    return view('vue');
});
Auth::routes();
//--any -
Route::get('/{any}', 'HomeController@index')->where('any', '.*');

Route::get('/home', 'HomeController@index')->name('home');


