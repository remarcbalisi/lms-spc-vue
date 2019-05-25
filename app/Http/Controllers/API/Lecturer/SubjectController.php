<?php

namespace App\Http\Controllers\API\Lecturer;

use App\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    public function store(Request $request) {

        $subject = Subject::onlyTrashed()
            ->where('name', $request->name)
            ->first();

        if( !empty($subject) ){
            $subject->restore();
            return response()->json([
                'message' => 'Successfully created ' . $subject->name . ' subject',
                'status' => 200
            ]);
        }

        $request->validate([
            'name' => 'required|unique:subjects|max:100'
        ]);

        $new_subject = new Subject;
        $new_subject->name = $request->name;
        $new_subject->offered_from = $request->offered_from;
        $new_subject->code = $request->code;
        $new_subject->slug = strtolower(str_replace(' ', '-', $request->name));
        $new_subject->save();

        return response()->json([
           'message' => 'Successfully added ' . $new_subject->name . ' subject',
           'status' => 200
        ]);
    }

    public function get() {

        $subjects = Subject::get();
        foreach( $subjects as $subject ) {
            $subject['college'] = $subject->college()->first();
        }
        return response()->json([
            'message' => 'Successfully get all subjects',
            'data' => $subjects,
            'status' => 200
        ]);

    }
}
