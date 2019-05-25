<?php

namespace App\Http\Controllers\API\Lecturer;

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

    public function getAllCourses() {
        $courses = Course::get();
        foreach( $courses as $course ) {
            $course['college'] = $course->college()->first();
        }
        return response()->json([
            'message' => 'Successfully get colleges',
            'data' => $courses,
            'status' => 200,
        ]);
    }

    public function update(Request $request, $course_id) {

        $request->validate([
            'name' => 'required|unique:courses,name,'.$course_id.'|max:80',
        ]);

        $course = Course::where('id', $course_id)->first();
        $course->name = $request->name;
        $course->slug = strtolower( str_replace(' ', '-', $request->name) );
        $course->college_id = $request->college_id;
        $course->save();

        return response()->json([
            'message' => 'Successfully updated ' . $course->name . ' course',
            'status' => 200
        ]);
    }

    public function destroy($course_id) {
        $course = Course::where('id', $course_id)->first();
        $message = 'Successfully deleted ' . $course->name . ' course';
        $course->delete();
        return response()->json([
            'message' => $message,
            'status' => 200
        ]);
    }
}
