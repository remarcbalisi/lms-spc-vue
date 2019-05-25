<?php

namespace App\Http\Controllers\API\Lecturer;

use App\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SectionController extends Controller
{
    public function store(Request $request) {

        $request->validate([
            'name' => 'required|max:45'
        ]);

        $check_section_exist = Section::withTrashed()->where([
            'name' => $request->name,
        ])->first();

        if( !empty($check_section_exist) ) {
            if ($check_section_exist->trashed()) {
                $check_section_exist->restore();
                return response()->json([
                    'message' => 'Section ' . $request->name . ' successfully added!',
                    'status' => 200,
                ]);
            }else{
                return response()->json([
                    'message' => 'Section ' . $request->name . ' already exist!',
                    'status' => 422
                ]);
            }
        }

        $new_section = new Section;
        $new_section->name = $request->name;
        $new_section->slug = strtolower( str_replace(' ', '-', $request->name) );
        $new_section->save();

        return response()->json([
            'message' => 'Section ' . $new_section->name . ' successfully added!',
            'status' => 200,
        ]);
    }

    public function get() {
        return response()->json([
            'message' => 'Successfully get all sections',
            'data' => Section::get(),
        ]);
    }
}
