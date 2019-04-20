<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $admin_role = Role::where('slug', 'admin')->first();
        if( auth()->user()->role_id == $admin_role->id ) {
            return $next($request);
        }
        return false;
    }
}
