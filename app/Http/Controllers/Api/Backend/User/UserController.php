<?php

namespace App\Http\Controllers\Api\Backend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Library;
use App\Http\Requests\Backend\User\UserRequest;
use App\Http\Requests\Backend\User\UserKomponenRequest;
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
        try {

            $store = $library::create($request->validated());

            if ($images = $request->data_perpustakaan_image) {
                foreach ($images as $image) {
                    $store->addMedia($image)->toMediaCollection();
                }
            }
            
            return response()->json(['success' => 'success save data', 'data' => new UserResource($store)], HttpResponse::HTTP_CREATED);

        } catch(\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating data: ' . $e->getMessage()], 404);
        }

    }    


    /**
     * store data library komponen
     * 
     * @param UserKomponenRequest $request
     * @param Library $library
     *  
     * @return JsonResponse
     * 
     * */
    public function storeKomponen()
    {

    }
}
