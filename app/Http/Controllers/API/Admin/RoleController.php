<?php

namespace App\Http\Controllers\API\Admin;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function store(Request $request) {

        $role = Role::onlyTrashed()
            ->where('name', $request->name)
            ->first();

        if( !empty($role) ){
            $role->restore();
            return response()->json([
                'message' => 'Successfully created ' . $role->name . ' role',
                'status' => 200
            ]);
        }

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

        $request->validate([
            'name' => 'required|unique:roles,name,'.$role_id.'|max:20',
        ]);

        $role = Role::where('id', $role_id)->first();
        $role->name = $request->name;
        $role->slug = strtolower( str_replace(' ', '-', $request->name) );
        $role->save();

        return response()->json([
            'message' => 'Successfully updated ' . $role->name . ' role',
            'status' => 200
        ]);
    }

    public function destroy($role_id) {
        $role = Role::where('id', $role_id)->first();
        $message = 'Successfully deleted ' . $role->name . ' role';
        $role->delete();
        return response()->json([
            'message' => $message,
            'status' => 200
        ]);
    }
}
