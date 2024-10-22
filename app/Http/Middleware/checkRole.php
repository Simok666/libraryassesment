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
        
        if($request->getPathInfo() === "/api/v1/getListLibrary" || $request->getPathInfo() === "/api/v1/storeTextEditor" ||
             $request->getPathInfo() === "/api/v1/getListKomponen" || $request->getPathInfo() === "/api/v1/getListBuktiFisik") 
             {
            $roleIds = ['type.operator' => 'role:operator', 'type.admin' => 'role:admin', 'type.verifikator_desk' => 'role:verifikator_desk', 'type.verifikator_field' => 'role:verifikator_field'];
        } else if ($request->getPathInfo() === "/api/v1/getPlenoFinal") {
            $roleIds = ['type.operator' => 'role:operator', 'type.verifikator_desk' => 'role:verifikator_desk', 'type.verifikator_field' => 'role:verifikator_field', 'type.user' => 'role:user', 'type.admin' => 'role:admin'];
        } else if (
            $request->getPathInfo() === "/api/v1/getUser" || 
            $request->getPathInfo() === "/api/v1/operator/verified/{id}" || 
            $request->getPathInfo() === "/api/v1/operator/notifyEmailVerifikator/{id}" || 
            $request->getPathInfo() === "/api/v1/operator/storeGradePleno" || 
            $request->getPathInfo() === "/api/v1/operator/storeBuktiEvaluasi" || 
            $request->getPathInfo() === "/api/v1/operator/store/{id}" || 
            $request->getPathInfo() === "/api/v1/admin/getEselonFungsi" || 
            $request->getPathInfo() === "/api/v1/admin/eselonSatu" || 
            $request->getPathInfo() === "/api/v1/admin/eselonDua" || 
            $request->getPathInfo() === "/api/v1/admin/eselonTiga" || 
            $request->getPathInfo() === "/api/v1/admin/fungsi" 
        ) {
            $roleIds = ['type.operator' => 'role:operator', 'type.admin' => 'role:admin'];
        } else if ($request->getPathInfo() === "/api/v1/user/store" || $request->getPathInfo() === "/api/v1/user/getSubKomponen" || $request->getPathInfo() === "/api/v1/user/storeKomponen"
            || $request->getPathInfo() === "/api/v1/user/getBuktiFisikData" || $request->getPathInfo() === "/api/v1/user/storeBuktiFisik" || $request->getPathInfo() === "/api/v1/dashboard") {
            $roleIds = ['type.user' => 'role:user', 'type.admin' => 'role:admin'];
        } else if ($request->getPathInfo() === "/api/v1/operator/getListVerifikatorDesk" || $request->getPathInfo() === "/api/v1/operator/getListVerifikatorField" ) {
            $roleIds = ['type.operator' => 'role:operator', 'type.admin' => 'role:admin'];
        } else {
            $roleIds = ['type.operator' => 'role:operator', 'type.admin' => 'role:admin', 'type.pimpinan' => 'role:pimpinan' , 'type.pimpinankaban' => 'role:pimpinankaban'];
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
