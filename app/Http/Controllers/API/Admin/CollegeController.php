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
}
