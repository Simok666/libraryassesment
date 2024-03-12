<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\PimpinanAuthRequest;
use App\Models\Pimpinan;
use App\Http\Resources\Auth\Pimpinan\PimpinanAuthResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class PimpinanAuthController extends Controller
{
    /**
     * login function
     * 
     * @param PimpinanAuthRequest $request
     * 
     */
    public function login(PimpinanAuthRequest $request)
    {   
        $pimpinan = Pimpinan::where('email', $request->email)->first();

        if (!$pimpinan || !Hash::check($request->password, $pimpinan->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return new PimpinanAuthResource($pimpinan);
    }

    /**
     * logout function
     * 
     * @param PimpinanAuthRequest $request
     * 
     */
    public function destory(PimpinanAuthRequest $request) 
    {
       $pimpinan = $request->user();

       $pimpinan->tokens()->delete();

       return response()->noContent();
    }
}
