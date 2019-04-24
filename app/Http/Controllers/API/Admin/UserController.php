<?php

namespace App\Http\Controllers\API\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function store(Request $request) {
        $this->validate($request, [
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|unique:users',
            'password' => 'required|confirmed',
            'role_id' => 'required',
        ]);

        $new_user = new User;
        $new_user->first_name = $request->first_name;
        $new_user->middle_name = $request->middle_name;
        $new_user->last_name = $request->last_name;
        $new_user->email = $request->email;
        $new_user->password = bcrypt($request->password);
        $new_user->role_id = Role::where('slug', $request->role_id)->first()->id;
        $new_user->course_id = ($request->course_id) ? $request->course_id : null;
        $new_user->save();

        return response()->json([
            'message' => 'Successfully added ' . $new_user->first_name,
            'status' => 200
        ]);
    }
}
