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
        $roleIds = [];
        
        if($request->getPathInfo() === "/api/v1/getListLibrary" || $request->getPathInfo() === "/api/v1/storeTextEditor/" ||
             $request->getPathInfo() === "/api/v1/getListKomponen" || $request->getPathInfo() === "/api/v1/getListBuktiFisik") 
             {
            $roleIds = ['type.operator' => 'role:operator', 'type.verifikator_desk' => 'role:verifikator_desk', 'type.verifikator_field' => 'role:verifikator_field'];
        } else {
            $roleIds = ['type.operator' => 'role:operator', 'type.pimpinan' => 'role:pimpinan'];
        }
        
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
          if(in_array(auth()->user()->currentAccessToken()->getAttributeValue('abilities')[0], $allowedRoleIds)) {
            return $next($request);
          }
        }

        return response()->json(['message' => 'youre not allowed to accsess this route'], 405);
    }
}
