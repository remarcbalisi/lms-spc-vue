<?php

namespace App\Http\Controllers\API\Admin;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:roles|max:20',
        ]);

        $new_role = new Role;
        $new_role->name = $request->name;
        $new_role->slug = strtolower( str_replace(' ', '-', $request->name) );
        $new_role->save();

        return response()->json([
           'message' => 'Successfully created ' . $new_role->name . ' role',
            'status' => 200
        ]);
    }

    public function getAllRoles() {
        return response()->json([
            'message' => 'Successfully get roles',
            'data' => Role::get(),
            'status' => 200,
        ]);
    }

    public function update(Request $request, $role_id) {
        $role = Role::where('id', $role_id)->first();
    }
}
