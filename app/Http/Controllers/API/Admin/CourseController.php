<?php

namespace App\Http\Controllers\API\Admin;

use App\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function store(Request $request) {

        $course = Course::onlyTrashed()
            ->where('name', $request->name)
            ->first();

        if( !empty($course) ){
            $course->restore();
            return response()->json([
                'message' => 'Successfully created ' . $course->name . ' course',
                'status' => 200
            ]);
        }

        $request->validate([
            'name' => 'required|unique:courses|max:80',
        ]);

        $new_course = new Course;
        $new_course->name = $request->name;
        $new_course->slug = strtolower( str_replace(' ', '-', $request->name) );
        $new_course->college_id = $request->college_id;
        $new_course->save();

        return response()->json([
            'message' => 'Successfully created ' . $new_course->name . ' course',
            'status' => 200
        ]);
    }
}
