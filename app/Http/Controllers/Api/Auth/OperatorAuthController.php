<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operator;
use App\Http\Requests\Auth\OperatorAuthRequest;
use App\Models\Admin;
use App\Http\Resources\Auth\Operator\OperatorAuthResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class OperatorAuthController extends Controller
{
     /**
     * login function
     * 
     * @param OperatorAuthRequest $request
     * 
     */
    public function login(OperatorAuthRequest $request)
    {   
        $operator = Operator::where('email', $request->email)->first();

        if (!$operator || !Hash::check($request->password, $operator->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return new OperatorAuthResource($operator);
    }

    /**
     * logout function
     * 
     * @param OperatorAuthRequest $request
     * 
     */
    public function destory(OperatorAuthRequest $request) 
    {
       $operator = $request->user();

       $operator->tokens()->delete();

       return response()->noContent();
    }
}
