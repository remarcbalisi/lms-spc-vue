<?php

namespace App\Http\Controllers\API\Admin;

use App\ClassroomUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClassroomUserController extends Controller
{
    public function store(Request $request) {

        $classroomuser = ClassroomUser::withTrashed()
            ->where([
                'user_id' => $request->user_id,
                'classroom_id' => $request->classroom_id,
            ])
            ->first();

        if( !empty($classroomuser) ){

            if( $classroomuser->trashed() ) {
                $classroomuser->restore();
                return response()->json([
                    'message' => 'Successfully added ' . $classroomuser->user()->first()->first_name,
                    'status' => 200
                ]);
            }else{
                return response()->json([
                    'message' => $classroomuser->user()->first()->first_name . ' Already exist!',
                    'status' => 422
                ]);
            }

        }

        $request->validate([
            'user_id' => 'required',
            'classroom_id' => 'required',
        ]);

        $new_classroom_user = new ClassroomUser;
        $new_classroom_user->user_id = $request->user_id;
        $new_classroom_user->classroom_id = $request->classroom_id;
        $new_classroom_user->is_enrolled = true;
        $new_classroom_user->save();

        return response()->json([
            'message' => 'Successfully added ' . $new_classroom_user->user()->first()->first_name,
            'status' => 200
        ]);
    }
}
