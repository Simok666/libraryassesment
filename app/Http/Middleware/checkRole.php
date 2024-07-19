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
        // dd($request->getPathInfo());
        if($request->getPathInfo() === "/api/v1/getListLibrary" || $request->getPathInfo() === "/api/v1/storeTextEditor/" ||
             $request->getPathInfo() === "/api/v1/getListKomponen" || $request->getPathInfo() === "/api/v1/getListBuktiFisik") 
             {
            $roleIds = ['type.operator' => 'role:operator', 'type.verifikator_desk' => 'role:verifikator_desk', 'type.verifikator_field' => 'role:verifikator_field'];
        } else if ($request->getPathInfo() === "/api/v1/getPlenoFinal") {
            $roleIds = ['type.operator' => 'role:operator', 'type.verifikator_desk' => 'role:verifikator_desk', 'type.verifikator_field' => 'role:verifikator_field', 'type.user' => 'role:user'];
        } else if ($request->getPathInfo() === "/api/v1/operator/getUser" || $request->getPathInfo() === "/api/v1/operator/verified/{id}") {
            $roleIds = ['type.operator' => 'role:operator', 'type.admin' => 'role:admin'];
        } else if ($request->getPathInfo() === "/api/v1/user/store" || $request->getPathInfo() === "/api/v1/user/getSubKomponen" || $request->getPathInfo() === "/api/v1/user/storeKomponen"
            || $request->getPathInfo() === "/api/v1/user/getBuktiFisikData" || $request->getPathInfo() === "/api/v1/user/storeBuktiFisik") {
            $roleIds = ['type.user' => 'role:user', 'type.admin' => 'role:admin'];
        } else {
            $roleIds = ['type.operator' => 'role:operator', 'type.pimpinan' => 'role:pimpinan' , 'type.pimpinankaban' => 'role:pimpinankaban'];
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
