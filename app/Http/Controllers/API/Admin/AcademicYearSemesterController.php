<?php

namespace App\Http\Controllers\API\Admin;

use App\AcademicYear;
use App\AcademicYrSemester;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AcademicYearSemesterController extends Controller
{
    public function store($academic_year_id, Request $request) {

        foreach( $request->semester_arr as $key => $sem ) {
            $check_acaddemic_yr_sem = AcademicYrSemester::where([
                'academic_year_id' => $academic_year_id,
                'semester_id' => $sem
            ])->first();

            if( !empty($check_acaddemic_yr_sem) ) {
                if( $check_acaddemic_yr_sem->trashed() ) {
                    $check_acaddemic_yr_sem->restore();
                }
                else {
                    return response()->json([
                        'message' => $check_acaddemic_yr_sem->getFullName() . ' already exist!',
                        'status' => 422,
                    ]);
                }
            }
            else{
                $new_academic_yr_sem = new AcademicYrSemester;
                $new_academic_yr_sem->semester_id = $sem;
                $new_academic_yr_sem->academic_year_id = $academic_year_id;
                $new_academic_yr_sem->save();
            }
        }


        return response()->json([
            'message' => 'Successfully added',
            'status' => 200
        ]);

    }

    public function get() {
        return AcademicYrSemester::get();
    }

}
