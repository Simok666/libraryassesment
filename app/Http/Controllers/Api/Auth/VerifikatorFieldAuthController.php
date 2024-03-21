<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\VeifikatorFieldAuthRequest;
use App\Http\Resources\Auth\Verifikator\VeifikatorFieldAuthResource;
use App\Models\VerifikatorField;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

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
        $field = VerifikatorField::where('email', $request->email)->first();

        if (!$field || !Hash::check($request->password, $field->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return new VeifikatorFieldAuthResource($field);
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
