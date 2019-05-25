<?php

namespace App\Http\Controllers\API\Lecturer;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getAllUserByRole($role_slug) {
        $role = Role::where('slug', $role_slug)->first();
        $users = User::where('role_id', $role->id)->get();
        return response()->json([
           'message' => 'Successfully get all ' . $role_slug,
           'data' => $users,
           'status' => 200
        ]);
    }
}
