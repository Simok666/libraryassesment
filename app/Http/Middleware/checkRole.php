<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $roleIds = ['type.operator' => 1, 'type.verifikator_desk' => 1];
        $allowedRoleIds = [];
        foreach ($roles as $role)
        {
           if(isset($roleIds[$role]))
           {
               $allowedRoleIds[] = $roleIds[$role];
           }
        }
        $allowedRoleIds = array_unique($allowedRoleIds); 
        
        if(auth()->user()) {
          if(in_array(auth()->user()->id, $allowedRoleIds)) {
            return $next($request);
          }
        }

        return response()->json(['message' => 'youre not allowed to accsess this route'], 405);
    }
}
