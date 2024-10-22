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
use App\Models\GoogleForm;
use App\Models\EselonSatu;
use App\Models\EselonDua;
use App\Models\EselonTiga;
use App\Http\Requests\Backend\User\UserRequest;
use App\Http\Requests\Backend\User\UserKomponenRequest;
use App\Http\Requests\Backend\User\UserBuktiFisikRequest;
use App\Http\Resources\Backend\User\UserResource;
use App\Http\Resources\Backend\User\UserKomponenResource;
use App\Http\Resources\Backend\User\UserSubKomponenResource;
use App\Http\Resources\Backend\User\UserBuktiFisikDataResource;
use App\Http\Resources\Backend\User\UserBuktiFisikResource;
use App\Http\Resources\Backend\Operator\OperatorListKomponen;
use App\Http\Resources\Backend\Operator\OperatorListBuktiFisik;
use App\Http\Resources\Backend\Operator\OperatorLinkGoogle;
use App\Http\Requests\Backend\User\GoogleFormRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Http\Resources\Backend\Operator\DataEselonFungsiResource;
class UserController extends Controller
{
    public function getDetailLibrary(Request $request, Library $library)
    {
        $library = User::find($request->user()->id)->library;
        return ($library !== null) ? new UserResource($library) : null;
    }

    public function getDetailKomponen(Request $request, Komponen $komponen)
    {
        $komponen = User::find($request->user()->id)->komponen;
  
        return ($komponen !== null) ? UserSubKomponenResource::collection($komponen) : null;
    }

    public function getDetailBuktiFisik(Request $request, BuktiFisik $buktiFisik)
    {
        $bukti = User::find($request->user()->id)->buktiFisik;
        
        return ($bukti !== null) ?  UserBuktiFisikResource::collection($bukti) : null;
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
            
            DB::beginTransaction();
            
            $store = $library::updateOrCreate(
                ['user_id' => $request->user()->id],
                array_merge($request->validated(), ['user_id' => $request->user()->id])
            );
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
                'role' => 'PIC',
                'role_to' => 'Admin & Operator',
                'body' => $store,
            ];

            dispatch(new SendEmailJob($postMail));
            
            return response()->json(['success' => 'success save data'], HttpResponse::HTTP_CREATED);
            // if( !$this->checkUserInsert($request->user()->id, 'library') )
            // {
            // }
            // return response()->json(['message' => 'duplicate data not allowed'], 409);

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

        return UserKomponenResource::collection(Komponen::where('jenis_perpustakaan', $users->jenis_perpustakaan ?? 'empty')->get());
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

                $store = $subKomponen::updateOrCreate([
                    'user_id' => $request->user()->id,
                    'subkomponen_id' => $data['subkomponen_id'],
                ], [
                    'user_id' => $request->user()->id,
                    'subkomponen_id' => $data['subkomponen_id'],
                    'skor_subkomponen' => $data['skor_subkomponen'],
                    'nilai' => $data['nilai'],
                    // 'is_verified' => $data['is_verified'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                if (isset($data['bukti_dukung'])) {
                    $store->clearMediaCollection('images');
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
                    'role' => 'PIC',
                    'role_to' => 'Admin & Operator',
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

                $store = $buktiFisik::updateOrCreate(
                        [
                            'user_id' => $request->user()->id,
                            'bukti_fisik_data_id' => $data['bukti_fisik_data_id']
                        ],
                        [
                            'user_id' => $request->user()->id,
                            'bukti_fisik_data_id' => $data['bukti_fisik_data_id'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                
                if (isset($data['bukti_fisik_upload'])) {
                    $store->clearMediaCollection('images');
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
                    'role' => 'PIC',
                    'role_to' => 'Admin & Operator',
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

    public function storeGoogleForm (Request $request, User $user) {
        try {
            $userId = $request->user()->id;
            $data = collect($request->repeater)->map(function ($item) use ($userId, $user) {
                DB::beginTransaction(); 
                    $storeGoogleForm = $user::updateOrCreate(
                        [
                            'id' => $userId,
                        ],
                        [
                            'id' => $userId,
                            'is_upload_google_form' => (boolean) request("is_upload_google_form"),
                        ]
                    );
                    
                    if($googleForms = $item['bukti_googleform']) {
                        // foreach ($googleForms as $googleForm) {
                        //     dd('tes');
                            $storeGoogleForm->clearMediaCollection('bukti_googleform');
                            $storeGoogleForm->addMedia($googleForms)->toMediaCollection('bukti_googleform');
                        // }
                    }
                DB::commit();        
            });
            return response()->json(['success' => 'success save data'], HttpResponse::HTTP_CREATED);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while creating or updating: '. $ex->getMessage()], 400);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while upload pleno: ' . $e->getMessage()], 400);
        }
    }
    public function getLinkGoogleForm(GoogleForm $googleForm) {
        try {
            $googleForm = $googleForm->get();
            return new OperatorLinkGoogle($googleForm);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while creating or updating: '. $ex->getMessage()], 400);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while upload data: ' . $e->getMessage()], 400);
        }
    }


    /**
     * function data dashborad for eselon
     * 
     * @param User $user
     * @param Request $request
     * 
     */
    public function dashboardEselon(User $user, Request $request)
    {
        $userSelected = $user->find($request->user()->id);
        $role = $request->user()->currentAccessToken()->abilities;
        $role = explode(':', $role[0])[1] ?? "";
        $bawahanEselon = [];
        $isEselon1 = false;
        $isEselon2 = false;

        if ($userSelected !== null) {
            if( $userSelected->eselon_satu  && $userSelected->eselon_dua == null && $userSelected->eselon_tiga == null && $role == 'user' ) {
                $dataEselon2 = User::with('evaluation')
                ->withCount([
                    'evaluation as cek_evaluasi' => function ($query) {
                        $query->where('is_evaluasi', 1);
                    },
                ])
                ->where('id_satuan_kerja_eselon_1', $userSelected->id_satuan_kerja_eselon_1)
                ->whereNotNull('id_satuan_kerja_eselon_2')
                ->whereNull('id_satuan_kerja_eselon_3')
                ->get();

                $usersDataEselon2 = collect();
    
                foreach ($dataEselon2 as $user) {
                    $usersDataEselon2->push([
                        'nama' => $user->name,
                        'email' => $user->email,
                        'evaluasi' => $user->cek_evaluasi == 0 ? 'Belum Evaluasi' : 'Sudah Evaluasi',
                    ]);
                }

                $dataEselon3 = User::with('evaluation')
                ->withCount([
                    'evaluation as cek_evaluasi' => function ($query) {
                        $query->where('is_evaluasi', 1);
                    },
                ])
                ->where('id_satuan_kerja_eselon_1', $userSelected->id_satuan_kerja_eselon_1)
                ->whereNotNull('id_satuan_kerja_eselon_2')
                ->whereNotNull('id_satuan_kerja_eselon_3')
                ->get();
                

                $usersDataEselon3 = collect();
    
                foreach ($dataEselon3 as $user) {
                    $usersDataEselon3->push([
                        'nama' => $user->name,
                        'email' => $user->email,
                        'evaluasi' => $user->cek_evaluasi == 0 ? 'Belum Evaluasi' : 'Sudah Evaluasi',
                    ]);
                }

                $bawahanEselon = [
                    'eselon_2' => $usersDataEselon2,
                    'eselon_3' => $usersDataEselon3
                ];
    
                $isEselon1 = true;
                $isEselon2 = false;
            } elseif ( $userSelected->eselon_dua  && $userSelected->eselon_tiga == null && $role == 'user') {
                $dataBawahan =  User::with('evaluation')
                ->withCount([
                    'evaluation as cek_evaluasi' => function ($query) {
                        $query->where('is_evaluasi', 1);
                    }
                ])
                ->where('id_satuan_kerja_eselon_2', $userSelected->id_satuan_kerja_eselon_2)
                ->whereNotNull('id_satuan_kerja_eselon_3')
                ->get();
    
                $usersDataBawahan = collect();

                foreach ($dataBawahan as $user) {
                    $usersDataBawahan->push([
                        'nama' => $user->name,
                        'email' => $user->email,
                        'evaluasi' => $user->cek_evaluasi == 0 ? 'Belum Evaluasi' : 'Sudah Evaluasi',
                    ]);
                }

                $bawahanEselon = $usersDataBawahan;
                $isEselon1 = false;
                $isEselon2 = true;
            }
        }

        return response()->json([
            'isEselon1' => $isEselon1,
            'isEselon2' => $isEselon2,
            'bawahan_eselon' => $bawahanEselon,
        ]);
    }

    /**
     * get all evaluasi data    
     * 
     * @param User $user    
     * @param Request $request
     */
    public function listEvaluasi (User $user, Request $request) {
        
        $query = User::with(['pleno'])
        ->whereHas('pleno', function ($query) {
            $query->where('is_final', true);
        })
        ->where([
            ['status_perpustakaan', '=', 1],
            ['status_subkomponent', '=', 1],
            ['status_buktifisik', '=', 1],
        ]);

        // Search functionality
        if (!empty($request->search['value'])) {
            $search = $request->search['value'];
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('grade', 'like', "%{$search}%");
            });
        }

        // Eselon 1
        if (!empty($request->eselonSatu)) {
            $query->where('id_satuan_kerja_eselon_1', $request->eselonSatu);
        }
        // Eselon 2
        if (!empty($request->eselonDua)) {
            $query->where('id_satuan_kerja_eselon_2', $request->eselonDua);
        }
        // Eselon 3
        if (!empty($request->eselonTiga)) {
            $query->where('id_satuan_kerja_eselon_3', $request->eselonTiga);
        }

        // Ordering
        if ($request->has('order')) {
            $orderColumn = $request->columns[$request->order[0]['column']]['data'];
            $orderDir = $request->order[0]['dir'];
            $query->orderBy($orderColumn, $orderDir);
        }

        // Pagination
        $limit = $request->length;
        $offset = $request->start;
        
        $totalRecords = $query->count();
        $evaluasi = $query->offset($offset)->limit($limit)->get();
        // dd($evaluasi);
        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $evaluasi,
        ]);
        
        // return OperatorListKomponen::collection($evaluasi);
    }

    /**
     * Get data Eselon
     * 
     * @param EselonSatu $eselonSatu
     */
    public function getAllEselon(EselonSatu $eselonSatu) {
        return DataEselonFungsiResource::collection($eselonSatu->all());
    }

    /**
     * Get data Eselon 2
     * 
     * @param EselonDua $eselonDua
     */
    public function getAllEselon2(EselonDua $eselonDua) {
        return DataEselonFungsiResource::collection($eselonDua->all());
    }

    /**
     * Get data Eselon 3
     * 
     * @param EselonTiga $eselonTiga
     */
    public function getAllEselon3(EselonTiga $eselonTiga) {
        return DataEselonFungsiResource::collection($eselonTiga->all());
    }

    /**
     * search evaluasi    
     * 
     * @param User $user    
     * @param Request $request
     */
    public function searchEvaluasi (User $user, Request $request) {
        $searchTerm = $request->input('poin');
        $evaluations = User::where('grade', 'like', '%' . $searchTerm . '%')
        ->with(['pleno'])
        ->whereHas('pleno', function($query) use ($request) {
            $query->where('is_final', (boolean) true);
        })
        ->whereHas('komponen', function ($query) use ($request) {
            if (!empty($request->status)) {
                $query->where('status', $request->status);
            }
        })->where([
            ['status_perpustakaan', '=', (boolean) 1],
            ['status_subkomponent', '=', (boolean) 1],
            ['status_buktifisik', '=', (boolean) 1],
        ])->when($request->has('id'), function ($query) use ($request){
            $query->where('id', request("id"));
        })->get();
      
        if(count($evaluations) == 0) {
            $evaluations = [
                'message' => 'Evaluasi Tidak Ditemukan',
            ];
        }

        return response()->json($evaluations);
    }
}
