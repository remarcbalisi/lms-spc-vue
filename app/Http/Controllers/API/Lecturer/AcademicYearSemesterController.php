<?php

namespace App\Http\Controllers\API\Lecturer;

use App\AcademicYear;
use App\AcademicYrSemester;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AcademicYearSemesterController extends Controller
{
    public function get() {
        $academic_yr_semesters = AcademicYrSemester::get();
        foreach( $academic_yr_semesters as $academic_yr_semester ) {
            $academic_yr_semester['full_name'] = $academic_yr_semester->getFullName();
        }
        return $academic_yr_semesters;
    }

}
