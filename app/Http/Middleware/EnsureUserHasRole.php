<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\Producer;
use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use App\Models\PublicUser;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {        
        $user = new PublicUser();       
        $user->addRole($request->user()); // Add Reg User Role            
        if($request->user()->admin)
            $user->addRole($request->user()->admin);
        if($request->user()->producer)
            $user->addRole($request->user()->producer);        
        if (! $user->roleOf($role))
        {            
            return response()->json([
                'message' => 'Unauthorized'
                ], 401);
        }

        return $next($request);
    }
    
}
