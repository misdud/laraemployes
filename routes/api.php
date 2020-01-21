<?php

use Illuminate\Http\Request;
use App\Http\Resources\HeadEnterpResource;
//use App\HeadEnterp;

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


//Route::get('/supervisor', function(){
//     return  HeadEnterpResource::collection(HeadEnterp::with('position')->get());
//     //return  new HeadEnterpResource(HeadEnterp::all());
//})->name('head_enterp');

Route::get('/supervisor/employes', 'Api\HeadEnterpController@getEmploye');
Route::get('/supervisor/departs', 'Api\HeadEnterpController@getDepart');
Route::get('/supervisor/deputys', 'Api\HeadEnterpController@getDeputy');
Route::get('/supervisor/directors', 'Api\HeadEnterpController@getDirector');
Route::resource('/supervisor', 'Api\HeadEnterpController');
    //->only(['index', 'show']);

Route::put('/employees/redistrs', 'Api\EmployeController@redistr');
//Route::get('/employees/erases', 'Api\EmployeController@erase');
Route::get('/employees/search', 'Api\EmployeController@search');
Route::post('/employees/storephotos', 'Api\EmployeController@storPhoto');
Route::get('/employees/headdeparts', 'Api\EmployeController@getHeadDepart');
Route::get('/employees/positions', 'Api\EmployeController@getPosition');
Route::resource('/employees', 'Api\EmployeController');
