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
        Route::get('/users/by-role/{role_slug}', 'API\Admin\UserController@getAllUserByRole');

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

        //Course
        Route::post('/courses/store', 'API\Admin\CourseController@store');
        Route::post('/courses/update/{college_id}', 'API\Admin\CourseController@update');
        Route::get('/courses/destroy/{college_id}', 'API\Admin\CourseController@destroy');
        Route::get('/courses', 'API\Admin\CourseController@getAllCourses');

        //Academic Year
        Route::post('/academic-years/store', 'API\Admin\AcademicYearController@store');
        Route::get('/academic-years', 'API\Admin\AcademicYearController@get');
        Route::post('/academic-years/update/{ay_id}', 'API\Admin\AcademicYearController@update');
        Route::get('/academic-years/destroy/{ay_id}', 'API\Admin\AcademicYearController@destroy');

        //Semester
        Route::post('/semesters/store', 'API\Admin\SemesterController@store');
        Route::get('/semesters', 'API\Admin\SemesterController@get');
        Route::post('/semesters/update/{semester_id}', 'API\Admin\SemesterController@update');
        Route::get('/semesters/destroy/{semester_id}', 'API\Admin\SemesterController@destroy');

        //Academic Year Semester
        Route::post('/academic-year-semester/{academic_year_id}/store', 'API\Admin\AcademicYearSemesterController@store');
        Route::get('/academic-year-semester', 'API\Admin\AcademicYearSemesterController@get');

        //Subject
        Route::post('/subject/store', 'API\Admin\SubjectController@store');
        Route::get('/subjects', 'API\Admin\SubjectController@get');

        //Section
        Route::post('/section/store', 'API\Admin\SectionController@store');
        Route::get('/sections', 'API\Admin\SectionController@get');

        //Classroom
        Route::post('/classroom/store', 'API\Admin\ClassroomController@store');
        Route::get('/classrooms', 'API\Admin\ClassroomController@get');
        Route::get('/classroom/{classroom_id}', 'API\Admin\ClassroomController@viewById');

        //Classroom User
        Route::post('/classroom-user/store', 'API\Admin\ClassroomUserController@store');
        Route::get('/classroom-users', 'API\Admin\ClassroomUserController@get');
    });
});


Route::middleware('auth:api', 'role:lecturer')->group(function () {
    Route::prefix('lecturer')->group(function () {

        //Course
        Route::post('/courses/store', 'API\Lecturer\CourseController@store');
        Route::post('/courses/update/{college_id}', 'API\Lecturer\CourseController@update');
        Route::get('/courses/destroy/{college_id}', 'API\Lecturer\CourseController@destroy');
        Route::get('/courses', 'API\Lecturer\CourseController@getAllCourses');

        //College
        Route::get('/colleges', 'API\Admin\CollegeController@getAllColleges');

        //Subject
        Route::post('/subject/store', 'API\Lecturer\SubjectController@store');
        Route::get('/subjects', 'API\Lecturer\SubjectController@get');

    });
});
