<?php

namespace App\Http\Controllers\API\Learner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClassroomUserController extends Controller
{
    public function myClassrooms() {
        $classroom_users = Auth::user()->classroom_users()->get();

        foreach( $classroom_users as $classroom_user ) {
            $classroom_user['classroom'] = $classroom_user->classroom;
            $classroom_user['classroom']['section'] = $classroom_user->classroom->section;
            $classroom_user['classroom']['subject'] = $classroom_user->classroom->subject;
            $classroom_user['classroom']['academic_yr_semester'] = $classroom_user->classroom->academic_yr_semester;
            $classroom_user['classroom']['academic_yr_semester']['full_name'] = $classroom_user->classroom->academic_yr_semester()->first()->getFullName();
        }

        return response()->json([
            'data' => $classroom_users,
            'status' => 200,
            'message' => 'Succesfully get all classrooms',
        ]);
    }
}
