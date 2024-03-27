<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\VeifikatorDeskAuthRequest;
use App\Http\Resources\Auth\Verifikator\VeifikatorDeskAuthResource;
use App\Models\VerifikatorDesk;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Auth\AuthResource;

class VerifikatorDeskAuthController extends Controller
{
    /**
     * login function
     * 
     * @param VeifikatorDeskAuthRequest $request
     * 
     */
    public function login(VeifikatorDeskAuthRequest $request)
    {   
        $request["role"] = "verifikator_desk";
        $desk = VerifikatorDesk::where('email', $request->email)->first();

        if (!$desk || !Hash::check($request->password, $desk->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return new AuthResource($desk);
    }

    /**
     * logout function
     * 
     * @param VeifikatorFieldAuthRequest $request
     * 
     */
    public function destory(Request $request) 
    {
       $verifikatordesk = $request->user();

       $verifikatordesk->tokens()->delete();

       return response()->noContent();
    }
}
