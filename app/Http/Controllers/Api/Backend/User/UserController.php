<?php

namespace App\Http\Controllers\Api\Backend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Library;
use App\Models\SubKomponen;
use App\Models\Komponen;
use App\Models\BuktiFisikData;
use App\Models\BuktiFisik;
use App\Models\Admin;
use App\Models\Operator;
use App\Http\Requests\Backend\User\UserRequest;
use App\Http\Requests\Backend\User\UserKomponenRequest;
use App\Http\Requests\Backend\User\UserBuktiFisikRequest;
use App\Http\Resources\Backend\User\UserResource;
use App\Http\Resources\Backend\User\UserKomponenResource;
use App\Http\Resources\Backend\User\UserSubKomponenResource;
use App\Http\Resources\Backend\User\UserBuktiFisikDataResource;
use App\Http\Resources\Backend\User\UserBuktiFisikResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use App\Jobs\SendEmailJob;

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
            if( !$this->checkUserInsert($request->user_id, 'library') )
            {
                $store = $library::create($request->validated());

                if ($images = $request->data_perpustakaan_image) {
                    foreach ($images as $image) {
                        $store->addMedia($image)->toMediaCollection('images');
                    }
                }
                $admin = Admin::first();
                $operator = Operator::first();

                
                $postMail = [
                    'email' => [$admin->email, $operator->email],
                    'title' => 'Pengusul Melengkapi Data Perpustakaan',
                    'status' => 'insert perpus',
                    'body' => $store,
                ];

                dispatch(new SendEmailJob($postMail));
                
                return response()->json(['success' => 'success save data', 'data' => new UserResource($store)], HttpResponse::HTTP_CREATED);
            }
            return response()->json(['message' => 'duplicate data not allowed'], 409);

        } catch(\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating data: ' . $e->getMessage()], 404);
        }

    }    

    /**
     * 
     * get Komponen data
     * 
     * @return JsonResponse
     * 
     */
    public function getSubKomponen(Request $request)
    {
        return UserKomponenResource::collection(Komponen::where('jenis_perpustakaan', $request->jenis_perpustakaan)->get());
    }

    /**
     * store data library komponen
     * 
     * @param UserKomponenRequest $request
     * @param SubKomponen $subKomponen
     *  
     * @return JsonResponse
     * 
     * */
    public function storeKomponen(UserKomponenRequest $request, SubKomponen $subKomponen)
    {
        try {
            if( !$this->checkUserInsert($request->user_id, 'subKomponen') )
            {
                $store = $subKomponen::create($request->validated());
    
                if ($images = $request->bukti_dukung) {
                    foreach ($images as $image) {
                        $store->addMedia($image)->toMediaCollection('images');
                    }
                }
                $admin = Admin::first();
                $operator = Operator::first();
    
                
                $postMail = [
                    'email' => [$admin->email, $operator->email],
                    'title' => 'Pengusul Melengkapi Data Komponen',
                    'status' => 'insert komponen',
                    'body' => $store,
                ];
    
                dispatch(new SendEmailJob($postMail));
                
                return response()->json(['success' => 'success save data', 'data' => new UserSubKomponenResource($store)], HttpResponse::HTTP_CREATED);
            }
            return response()->json(['message' => 'duplicate data not allowed'], 409);

        } catch(\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating data: ' . $e->getMessage()], 404);
        }
    }

    /**
     * 
     * get bukti fisik data
     * 
     * @return JsonResponse
     * 
     */
    public function getBuktiFisikData(Request $request)
    {
        return UserBuktiFisikDataResource::collection(BuktiFisikData::all());
    }

    /**
     * store data Bukti Fisik
     * 
     * @param UserBuktiFisikRequest $request
     * @param BuktiFisik $buktiFisik
     *  
     * @return JsonResponse
     * 
     * */
    public function storeBuktiFisik(UserBuktiFisikRequest $request, BuktiFisik $buktiFisik)
    {
        try {
            if( !$this->checkUserInsert($request->user_id, 'buktiFisik') )
            {
                $store = $buktiFisik::create($request->validated());
    
                if ($images = $request->bukti_fisik_upload) {
                    foreach ($images as $image) {
                        $store->addMedia($image)->toMediaCollection('images');
                    }
                }
                $admin = Admin::first();
                $operator = Operator::first();
    
                $postMail = [
                    'email' => [$admin->email, $operator->email],
                    'title' => 'Pengusul Melengkapi Data Perpustakaan',
                    'status' => 'insert bukti fisik',
                    'body' => $store,
                ];
    
                dispatch(new SendEmailJob($postMail));
                
                return response()->json(['success' => 'success save data', 'data' => new UserBuktiFisikResource($store)], HttpResponse::HTTP_CREATED);
            }
            return response()->json(['message' => 'duplicate data not allowed'], 409);

        } catch(\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating data: ' . $e->getMessage()], 404);
        }
    }

    public function checkUserInsert($userId, $type = null) 
    {
        $userLibrary = User::find(1)->library;
        $userKomponen = User::find(1)->komponen;
        $userBuktiFisik = User::find(1)->buktiFisik;
        
        if (count($userLibrary->get()) > 0 && $type == 'library') {
            return true;
        } elseif (count($userKomponen->get()) > 0 && $type == 'subKomponen') {
            return true;
        } elseif (count($userBuktiFisik->get()) > 0  && $type == 'buktiFisik') {
            return true;
        }
        return false;
    }
}
