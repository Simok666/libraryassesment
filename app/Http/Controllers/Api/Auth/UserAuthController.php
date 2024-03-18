<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\UserAuthRequest;
use App\Http\Requests\Auth\UserAuthLoginRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Http\Resources\Auth\User\UserRegisterResource;  
use App\Models\User;
use App\Models\Admin;
use App\Models\Operator;
use Mail;
use App\Jobs\SendEmailJob;
use App\Mail\PostMail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    /**
     * function register user
     * 
     * @param UserRegisterRequest $request
     * 
     * @return JsonResponse
     */
    public function register(UserAuthRequest $request)
    {
        try {
            
            $user = User::create($request->validated());
            
            if ($images = $request->sk_image) {
                foreach ($images as $image) {
                    $user->addMedia($image)->toMediaCollection('images');
                }
            }
       
            $admin = Admin::first();
            $operator = Operator::first();

            
            $postMail = [
                'email' => [$admin->email, $admin->operator],
                'title' => 'New User Has Been Registration',
                'status' => 'auth',
                'body' => $user,
            ];

            dispatch(new SendEmailJob($postMail));

            return new UserRegisterResource($user);
        }
        catch(\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating account: ' . $e->getMessage()], 404);
        }
    }

    /**
    * function login user
    *
    * @param UserAuthRequest $request
    */
    public function login(UserAuthLoginRequest $request) {
        $request["role"] = "user";
        $user = User::where('email', $request->email)->first();
        
        if (!$user || !Hash::check($request->password, $user->password) || $user->is_verified == 0 ) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect or Your account has not been verified'],
            ]);
        }
        
        return new AuthResource($user);
    }

     /**
     * logout function
     * 
     */
    public function destory(Request $request) 
    {
       $user = $request->user();

       $user->tokens()->delete();

       return response()->noContent();
    }

}
