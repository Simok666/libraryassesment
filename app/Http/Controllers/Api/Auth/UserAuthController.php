<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\UserAuthRequest;
use App\Http\Requests\Auth\UserAuthLoginRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Http\Resources\Auth\User\UserRegisterResource;
use App\Http\Resources\Auth\UserAccountResource;
use App\Models\User;
use App\Models\Admin;
use App\Models\Operator;
use Mail;
use App\Jobs\SendEmailJob;
use App\Mail\PostMail;
use Illuminate\Support\Facades\DB;
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
            DB::beginTransaction();
            
            $validatedData = $request->validated();
            $otherData = [
                'leader_instance_name' => $request->leader_instance_name,
                'library_name' => $request->library_name,
                'head_library_name' => $request->head_library_name,
                'npp' => $request->npp,
                'website' => $request->website
            ];
            
            $user = User::create(array_merge($validatedData, $otherData));
            
            if ($images = $request->sk_image) {
                foreach ($images as $image) {
                    $user->addMedia($image)->toMediaCollection('images');
                }
            }

            $admin = Admin::first();
            $operator = Operator::first();

            $postMail = [
                'email' => [$admin->email, $operator->email],
                'title' => 'New User Has Been Registration',
                'status' => 'auth',
                'body' => $user,
            ];

            dispatch(new SendEmailJob($postMail));

            DB::commit();

            return new UserRegisterResource($user);
        }
        catch(\Illuminate\Database\QueryException $ex) {
            return response()->json(['error' => 'An error occurred while creating account: Duplicate Entry'], 400);
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
    
    // check user from token
    public function getUserAccount(Request $request)
    {
        $user = $request->user();
        $role = $request->user()->currentAccessToken()->abilities;
        $role = explode(':', $role[0])[1] ?? "";
        $user["role"] = $role;
        return new UserAccountResource($user);
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
