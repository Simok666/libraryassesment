<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\AdminAuthRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Models\Admin;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
     /**
     * login function
     * 
     * @param AdminAuthRequest $request
     * 
     */
    public function login(AdminAuthRequest $request)
    {   
        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $admin->role = "admin";
        return new AuthResource($admin);
    }

    /**
     * logout function
     * 
     * @param AdminAuthRequest $request
     * 
     */
    public function destory(Request $request) 
    {
       $admin = $request->user();

       $admin->tokens()->delete();

       return response()->noContent();
    }
}
