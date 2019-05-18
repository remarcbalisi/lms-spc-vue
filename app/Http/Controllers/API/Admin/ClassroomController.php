<?php

namespace App\Http\Controllers\API\Admin;

use App\Classsroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClassroomController extends Controller
{
    public function store(Request $request) {

        $classroom = Classsroom::withTrashed()
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

        $new_classroom = new Classsroom();
        $new_classroom->section_id = $request->section_id;
        $new_classroom->subject_id = $request->subject_id;
        $new_classroom->academic_yr_semester_id = $request->academic_yr_semester_id;
        $new_classroom->save();

        return response()->json([
            'message' => 'Successfully created ' . $new_classroom->getFullName() . ' classroom',
            'status' => 200
        ]);
    }
}
