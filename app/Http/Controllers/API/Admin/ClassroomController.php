<?php

namespace App\Http\Controllers\API\Admin;

use App\Classroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClassroomController extends Controller
{
    public function store(Request $request) {

        $classroom = Classroom::withTrashed()
            ->where([
                'section_id' => $request->section_id,
                'subject_id' => $request->subject_id,
                'academic_yr_semester_id' => $request->academic_yr_semester_id,
            ])
            ->first();

        if( !empty($classroom) ){

            if( $classroom->trashed() ) {
                $classroom->restore();
                return response()->json([
                    'message' => 'Successfully created ' . $classroom->getFullName() . ' classroom',
                    'status' => 200
                ]);
            }else{
                return response()->json([
                   'message' => $classroom->getFullName() . ' Already exist!',
                    'status' => 422
                ]);
            }

        }

        $request->validate([
            'section_id' => 'required',
            'subject_id' => 'required',
            'academic_yr_semester_id' => 'required'
        ]);

        $new_classroom = new Classroom;
        $new_classroom->section_id = $request->section_id;
        $new_classroom->subject_id = $request->subject_id;
        $new_classroom->academic_yr_semester_id = $request->academic_yr_semester_id;
        $new_classroom->save();

        return response()->json([
            'message' => 'Successfully created ' . $new_classroom->getFullName() . ' classroom',
            'status' => 200
        ]);
    }

    public function get() {
        $classrooms = Classroom::get();
        foreach ( $classrooms as $classroom ) {
            $classroom['section'] = $classroom->section()->first();
            $classroom['subject'] = $classroom->subject()->first();
            $classroom['academic_yr_semester'] = $classroom->academic_yr_semester()->first();
            $classroom['academic_yr_semester']['full_name'] = $classroom->academic_yr_semester()->first()->getFullName();
        }
        return response()->json([
           'message' => 'Successfully get all classrooms',
           'data' => $classrooms,
           'status' => 200
        ]);
    }

    public function viewById($classroom_id) {
        $classroom = Classroom::where('id', $classroom_id)->first();
        $classroom['full_name'] = $classroom->getFullName();

        $classroom_users = [];
        foreach( $classroom->classroom_users()->get() as $classroom_user ) {
            $classroom_user['user'] = $classroom_user->user()->first();
            $classroom_user['user']['role'] = $classroom_user->user()->first()->role()->first();
            $classroom_user['user']['course'] = $classroom_user->user()->first()->course()->first() ? $classroom_user->user()->first()->course()->first() : null ;
            array_push($classroom_users, $classroom_user);
        }
        $classroom['classroom_users'] = $classroom_users;
        return response()->json([
           'message' => 'Successfully get classroom!',
           'data' => $classroom,
           'status' => 200,
        ]);
    }
}
