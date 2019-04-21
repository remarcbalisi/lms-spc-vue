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

Route::post('/register', 'API\AuthController@register');
Route::post('/login', 'API\AuthController@login');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', 'API\AuthController@logout');
    Route::get('/get-user', 'API\AuthController@getUser');
});

Route::middleware('auth:api', 'role:admin')->group(function () {
    Route::prefix('admin')->group(function () {

        //User
        Route::post('/users/store', 'API\Admin\UserController@store');

        //Role
        Route::post('/roles/store', 'API\Admin\RoleController@store');
        Route::post('/roles/update/{role_id}', 'API\Admin\RoleController@update');
        Route::get('/roles/destroy/{role_id}', 'API\Admin\RoleController@destroy');
        Route::get('/roles', 'API\Admin\RoleController@getAllRoles');

        //College
        Route::post('/colleges/store', 'API\Admin\CollegeController@store');
        Route::post('/colleges/update/{college_id}', 'API\Admin\CollegeController@update');
        Route::get('/colleges/destroy/{college_id}', 'API\Admin\CollegeController@destroy');
        Route::get('/colleges', 'API\Admin\CollegeController@getAllColleges');
    });
});
