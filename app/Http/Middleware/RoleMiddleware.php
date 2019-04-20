<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $role = Role::where('slug', $role)->first();
        if( auth()->user()->role_id == $role->id ) {
            return $next($request);
        }
        return false;
    }
}
