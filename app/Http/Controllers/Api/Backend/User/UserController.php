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
use Illuminate\Support\Facades\Validator;
use DB;
class UserController extends Controller
{
    public function getDetailLibrary(Request $request, Library $library)
    {
        $library = User::find($request->user()->id)->library;
        return ($library !== null) ? new UserResource($library) : null;
    }

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
            
            if( !$this->checkUserInsert($request->user()->id, 'library') )
            {
                DB::beginTransaction();
                $store = $library::create(array_merge($request->validated(), ['user_id' => $request->user()->id] ));
                $user = User::find($request->user()->id)->update(['type_insert' => '1']);

                if ($images = $request->data_perpustakaan_image) {
                    foreach ($images as $image) {
                        $store->addMedia($image)->toMediaCollection('images');
                    }
                }
                DB::commit();

                $admin = Admin::first();
                $operator = Operator::first();

                
                $postMail = [
                    'email' => [$admin->email, $operator->email],
                    'title' => 'Pengusul Melengkapi Data Perpustakaan',
                    'status' => 'insert perpus',
                    'body' => $store,
                ];

                dispatch(new SendEmailJob($postMail));
                
                return response()->json(['success' => 'success save data'], HttpResponse::HTTP_CREATED);
            }
            return response()->json(['message' => 'duplicate data not allowed'], 409);

        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while creating data: ' . $e->getMessage()], 404);
        } catch(\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while creating account: error on database'], 400);
        }

    }    

    /**
     * 
     * get Komponen data
     * 
     * @param Request $request
     * @param User $user
     * 
     * @return JsonResponse
     * 
     */
    public function getSubKomponen(Request $request, User $user)
    {
        $users = $user::find($request->user()->id)->library;

        return UserKomponenResource::collection(Komponen::where('jenis_perpustakaan', $users->jenis_perpustakaan)->get());
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
            $jenisPerpus = Library::where('user_id', $request->user()->id)->first()->jenis_perpustakaan;
            
            $validator = $request;
           
            DB::beginTransaction();
            $now = now();
            $stores = [];
            foreach ($request->all() as $data) {
                $store = $subKomponen->create([
                    'user_id' => $request->user()->id,
                    'subkomponen_id' => $data['subkomponen_id'],
                    'skor_subkomponen' => $data['skor_subkomponen'],
                    'nilai' => $data['nilai'],
                    'is_verified' => $data['is_verified'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                if (isset($data['bukti_dukung'])) {
                    $store->addMedia($data['bukti_dukung'])->toMediaCollection('images');
                    
                }
                $stores[] = $store->id;
            }

            $admin = Admin::first();
            $operator = Operator::first();
            
            if($subKomponen::where('user_id' ,$request->user()->id)->count() === 9 ){
                $user = User::find($request->user()->id)->update(['type_insert' => '2']);
                $postMail = [
                    'email' => [$admin->email, $operator->email],
                    'title' => 'Pengusul Melengkapi Data Komponen',
                    'status' => 'insert komponen',
                    'body' => Komponen::with((['subKomponens' => function ($query) use ($request) {
                                    $query->where('user_id', $request->user()->id); 
                                }]))->where('jenis_perpustakaan', $jenisPerpus)->get(),
                ];
    
                dispatch(new SendEmailJob($postMail));
            }
            DB::commit();
            return response()->json(['success' => 'success save data'], HttpResponse::HTTP_CREATED);
            
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while creating data: ' . $e->getMessage()], 404);
        } catch(\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while creating account: error on database'], 400);
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
            $validator = $request;
            DB::beginTransaction();
            $now = now();
            $stores = [];
            foreach ($request->all() as $data) {
                $store = $buktiFisik->create([
                    'user_id' => $request->user()->id,
                    'bukti_fisik_data_id' => $data['bukti_fisik_data_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                if (isset($data['bukti_fisik_upload'])) {
                    $store->addMedia($data['bukti_fisik_upload'])->toMediaCollection('images');
                    
                }
                $stores[] = $store->id;
            }

            $admin = Admin::first();
            $operator = Operator::first();
            if($buktiFisik::where('user_id' ,$request->user()->id)->count() === 9) 
            {
                $user = User::find($request->user()->id)->update(['type_insert' => '3']);
                $postMail = [
                    'email' => [$admin->email, $operator->email],
                    'title' => 'Pengusul Melengkapi Data Bukti Fisik',
                    'status' => 'insert bukti fisik',
                    'body' => BuktiFisikData::with((['buktiFisik' => function ($query) use ($request) {
                                $query->where('user_id', $request->user()->id); 
                            }]))->get(),
                ];
    
                dispatch(new SendEmailJob($postMail));
            }
            DB::commit();
            return response()->json(['success' => 'success save data'], HttpResponse::HTTP_CREATED);

        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while creating data: ' . $e->getMessage()], 404);
        } catch(\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while creating account: error on database'], 400);
        }
    }

    public function checkUserInsert($userId, $type = null) 
    {
        $userLibrary = User::find($userId)->library;
        $userKomponen = User::find($userId)->komponen;
        $userBuktiFisik = User::find($userId)->buktiFisik;

        if ($type == 'library' && $userLibrary != null) {
            return true;
        } elseif ($type == 'subKomponen'  && $userKomponen != null) {
            return true;
        } elseif ($type == 'buktiFisik' && $userBuktiFisik != null ) {
            return true;
        }
        return false;
    }
}
