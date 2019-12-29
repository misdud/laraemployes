<?php

use Illuminate\Http\Request;
use App\Http\Resources\HeadEnterpResource;
use App\HeadEnterp;

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

Route::resource('/supervisor', 'Api\HeadEnterpController')
    ->only(['index', 'show']);

Route::resource('/employees', 'Api\EmployeController');
