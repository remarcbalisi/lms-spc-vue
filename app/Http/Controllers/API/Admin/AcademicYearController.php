<?php

namespace App\Http\Controllers\API\Admin;

use App\AcademicYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AcademicYearController extends Controller
{
    public function store(Request $request) {
        $check_academicyear_exist = AcademicYear::withTrashed()->where([
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
        ])->first();

        if( !empty($check_academicyear_exist) ) {
            if ($check_academicyear_exist->trashed()) {
                $check_academicyear_exist->restore();
                return response()->json([
                    'message' => 'Academic Year ' . $request->from_date . ' - ' . $request->to_date . ' successfully added!',
                    'status' => 200,
                ]);
            }else{
                return response()->json([
                    'message' => 'Academic Year ' . $request->from_date . ' - ' . $request->to_date . ' already exist!',
                    'status' => 422
                ]);
            }
        }

        $new_academic_year = new AcademicYear;
        $new_academic_year->from_date = $request->from_date;
        $new_academic_year->to_date = $request->to_date;
        $new_academic_year->save();

        return response()->json([
            'message' => 'Academic Year ' . $request->from_date . ' - ' . $request->to_date . ' successfully added!',
            'status' => 200,
        ]);
    }

    public function get() {
        return response()->json([
           'message' => 'Sucessfully get all academic years',
           'data' => AcademicYear::get(),
           'status' => 200
        ]);
    }

    public function update(Request $request, $ay_id) {
        $check_academicyear_exist = AcademicYear::where([
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
        ])->first();

        if( !empty($check_academicyear_exist) ) {
            return response()->json([
                'message' => 'Academic Year ' . $request->from_date . ' - ' . $request->to_date . ' already exist!',
                'status' => 422
            ]);
        }

        $academic_year = AcademicYear::where('id', $ay_id)->first();
        $academic_year->from_date = $request->from_date;
        $academic_year->to_date = $request->to_date;
        $academic_year->save();

        return response()->json([
            'status' => 200,
            'message' => 'Successfully updated AY ' . $academic_year->from_date . ' - ' . $academic_year->to_date,
        ]);
    }

    public function destroy($ay_id) {
        $academic_year = AcademicYear::where('id', $ay_id)->first();
        $message = 'Successfully deleted AY ' . $academic_year->from_date . ' - ' . $academic_year->to_date;
        $academic_year->delete();

        return response()->json([
            'status' => 200,
            'message' => $message,
        ]);
    }
}
