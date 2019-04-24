<?php

namespace App\Http\Controllers\API\Admin;

use App\Semester;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SemesterController extends Controller
{
    public function store(Request $request) {
        $check_semester_exist = Semester::withTrashed()->where([
            'name' => $request->name,
        ])->first();

        if( !empty($check_semester_exist) ) {
            if ($check_semester_exist->trashed()) {
                $check_semester_exist->restore();
                return response()->json([
                    'message' => 'Semester ' . $request->name . ' successfully added!',
                    'status' => 200,
                ]);
            }else{
                return response()->json([
                    'message' => 'Semester ' . $request->name . ' already exist!',
                    'status' => 422
                ]);
            }
        }

        $new_semester = new Semester;
        $new_semester->name = $request->name;
        $new_semester->slug = strtolower( str_replace(' ', '-', $request->name) );
        $new_semester->save();

        return response()->json([
            'message' => 'Semester ' . $new_semester->name . ' successfully added!',
            'status' => 200,
        ]);
    }

    public function get() {
        return response()->json([
            'status' => 200,
            'message' => 'Successfully get all semesters!',
            'data' => Semester::get(),
        ]);
    }

    public function update(Request $request, $semester_id) {

        $request->validate([
            'name' => 'required|unique:semesters,name,'.$semester_id.'|max:20',
        ]);

        $semester = Semester::where('id', $semester_id)->first();
        $semester->name = $request->name;
        $semester->slug = strtolower( str_replace(' ', '-', $request->name) );
        $semester->save();

        return response()->json([
            'message' => 'Semester ' . $semester->name . ' successfully updated!',
            'status' => 200,
        ]);

    }

    public function destroy($semester_id) {
        $semester = Semester::where('id', $semester_id)->first();
        $message = 'Successfully deleted ' . $semester->name . ' Semester';
        $semester->delete();
        return response()->json([
            'status' => 200,
            'message' => $message
        ]);
    }
}
