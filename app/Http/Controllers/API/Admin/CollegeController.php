<?php

namespace App\Http\Controllers\API\Admin;

use App\College;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CollegeController extends Controller
{
    public function store(Request $request) {

        $college = College::onlyTrashed()
            ->where('name', $request->name)
            ->first();

        if( !empty($college) ){
            $college->restore();
            return response()->json([
                'message' => 'Successfully created ' . $college->name . ' college',
                'status' => 200
            ]);
        }

        $request->validate([
            'name' => 'required|unique:colleges|max:80',
        ]);

        $new_college = new College;
        $new_college->name = $request->name;
        $new_college->slug = strtolower( str_replace(' ', '-', $request->name) );
        $new_college->save();

        return response()->json([
            'message' => 'Successfully created ' . $new_college->name . ' college',
            'status' => 200
        ]);
    }

    public function getAllColleges() {
        return response()->json([
            'message' => 'Successfully get colleges',
            'data' => College::get(),
            'status' => 200,
        ]);
    }

    public function update(Request $request, $college_id) {

        $request->validate([
            'name' => 'required|unique:colleges,name,'.$college_id.'|max:80',
        ]);

        $college = College::where('id', $college_id)->first();
        $college->name = $request->name;
        $college->slug = strtolower( str_replace(' ', '-', $request->name) );
        $college->save();

        return response()->json([
            'message' => 'Successfully updated ' . $college->name . ' college',
            'status' => 200
        ]);
    }

    public function destroy($college_id) {
        $college = College::where('id', $college_id)->first();
        $message = 'Successfully deleted ' . $college->name . ' college';
        $college->delete();
        return response()->json([
            'message' => $message,
            'status' => 200
        ]);
    }
}
