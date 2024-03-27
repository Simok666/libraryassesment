<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\VeifikatorFieldAuthRequest;
use App\Http\Resources\Auth\Verifikator\VeifikatorFieldAuthResource;
use App\Models\VerifikatorField;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Auth\AuthResource;

class VerifikatorFieldAuthController extends Controller
{
     /**
     * login function
     * 
     * @param VeifikatorFieldAuthRequest $request
     * 
     */
    public function login(VeifikatorFieldAuthRequest $request)
    {   
        $request["role"] = "verifikator_field";
        $field = VerifikatorField::where('email', $request->email)->first();

        if (!$field || !Hash::check($request->password, $field->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return new AuthResource($field);
    }

    /**
     * logout function
     * 
     * @param VeifikatorFieldAuthRequest $request
     * 
     */
    public function destory(Request $request) 
    {
       $verifikatorField = $request->user();

       $verifikatorField->tokens()->delete();

       return response()->noContent();
    }
}
