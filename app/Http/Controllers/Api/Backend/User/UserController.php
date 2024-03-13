<?php

namespace App\Http\Controllers\Api\Backend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Library;
use App\Http\Requests\Backend\User\UserRequest;
use App\Http\Resources\Backend\User\UserResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class UserController extends Controller
{
    /**
     * store data library registration
     * 
     * @param UserRequest $request
     * @param Library $library
     *  
     * @return JsonResponse
     * 
     * */
    public function store(UserRequest $request, Library $library) 
    {

    }    
}
