<?php

namespace App\Http\Controllers\Api\Backend\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operator;
use App\Models\User;
use Mail;
use App\Mail\PostMail;
use App\Http\Requests\Backend\Operator\OperatorVerifiedRequest;
use App\Http\Resources\Backend\Operator\OperatorResource;
use App\Http\Resources\Backend\Operator\OperatorVerifiedResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class OperatorController extends Controller
{
    /**
     * index of items
     * 
     * @param $paginate
     * 
     * @return JsonResponse
     * 
     */
    public function getUserAccount($paginate = 10): JsonResponse
    {
        return response()->json(OperatorResource::collection(User::paginate($paginate)), HttpResponse::HTTP_OK);
    }


    /**
     * function fo update verified pic user account
     * 
     * @param OperatorVerifiedRequest $request
     * @param User $user
     * 
     * @return JsonResponse
     * 
     */
    public function verified(OperatorVerifiedRequest $request, User $user)
    {
        try {
            $users = $user::find($request->id);
            $users->is_verified = $request->is_verified;
            $users->save();
            
            if($users->is_verified) {
                Mail::to($users->email)->send(new PostMail([
                    'title' => 'Your Account Has Been Verified',
                    'body' => $users,
                ]));
            }

           return response()->json(['message' => 'User updated successfully'], HttpResponse::HTTP_CREATED);
            

        } catch(\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating data: ' . $e->getMessage()], 400);
        }
        
    }
}
