<?php

namespace App\Http\Controllers\Api\Backend\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\Administrator\AdministratorVerifiedReqeust;
use App\Models\User;
use App\Http\Resources\Backend\Administrator\AdministratorResource;
use App\Http\Resources\Backend\Administrator\AdministratorVerifiedResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AdminController extends Controller
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
        return response()->json(AdministratorResource::collection(User::paginate($paginate)), HttpResponse::HTTP_OK);
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
    public function verified(AdministratorVerifiedReqeust $request, User $user)
    {
        try {
            $users = $user::find($request->id);
            $users->is_verified = $request->is_verified;
            $users->save();
            
            if($users->is_verified) {

                $postMail = [
                    'email' => $users->email,
                    'title' => 'Your Account Has Been Verified',
                    'body' => $users,
                ];
                
                dispatch(new SendEmailJob($postMail));
                
            }

           return response()->json(['message' => 'User updated successfully'], HttpResponse::HTTP_CREATED);
            

        } catch(\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating data: ' . $e->getMessage()], 400);
        }
        
    }
}
