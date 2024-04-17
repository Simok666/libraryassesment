<?php

namespace App\Http\Controllers\Api\Backend\Verifikator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Library;
use App\Models\User;
use App\Models\Operator;
use App\Models\SubKomponen;
use App\Http\Resources\Backend\Operator\OperatorListLibrary;
use App\Http\Requests\Backend\Verifikator\VerifikatorRequest;
use Mail;
use App\Mail\PostMail;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use DB;


class VerifikatorDeskController extends Controller
{
    /**
     * notifikasi sudah sesuai
     * 
     * @param Request $request
     * 
     * @return JsonResponse
     * 
     */
    public function notification(Request $request, User $user) 
    {
        try{
            $users = User::find($request->id);
            $operator = Operator::first();
            $typeNotification = filter_var($request->type_notification, FILTER_VALIDATE_BOOLEAN);
            
            if($request->type_form == 'library') 
            {
                $library = User::find($request->id)->library;

                if($library)
                {
                    ($library->status_verifikato == 1) ? $library->status_verifikator  = 1 : $library->status_verifikator  = 2;  
                    $library->save();
                    
                    $postMail = [
                        'email' => $operator->email,
                        'title' => 'Form Data Profil Perpustakaan'. $typeNotification ? 'Sesuai' : 'Tidak Sesuai',
                        'status' => 'profil_perpustakaan',
                        'body' => $library,
                    ];

                    dispatch(new SendEmailJob($postMail));
                }
            } elseif ($request->type_form == 'subkomponen')
            {
                $subKomoponen = User::find($request->id)->komponen;
                
                if($subKomoponen)
                {
                    foreach ($subKomoponen as $value) {
                        
                        ($typeNotification) ? $value->status_verifikator  = 1 : $value->status_verifikator  = 2 ;  
                        $value->save();
                    }

                    $postMail = [
                        'email' => $operator->email,
                        'title' => 'Form Data Komponen '. $typeNotification ? 'Sesuai' : 'Tidak Sesuai',
                        'status' => 'komponen_perpustakaan',
                        'body' => $subKomoponen,
                    ];

                    dispatch(new SendEmailJob($postMail));
                }
            } elseif ($request->type_form == 'buktifisik') 
            {
                $buktiFisik = User::find($request->id)->buktiFisik;
                
                if($buktiFisik)
                {
                    foreach($buktiFisik as $value) {
                        ($typeNotification) ? $value->status_verifikator  = 1 : $value->status_verifikator  = 2;  
                        $value->save();
                    }

                    $postMail = [
                        'email' => $operator->email,
                        'title' => 'Form Data Bukti Fisik Perpustakaan '. $typeNotification ? 'Sesuai' : 'Tidak Sesuai',
                        'status' => 'bukti_fisik_perpustakaan',
                        'body' => $buktiFisik,
                    ];

                    dispatch(new SendEmailJob($postMail));
                }
            }
            

            return response()->json(['message' => 'notified with successfully'], HttpResponse::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while notif email: ' . $e->getMessage()], 400);
        }
    }

    /**
     * 
     * store notes verifikator
     * 
     * @param Request $request
     * @param SubKomponen $subKomponen
     * @param User $user
     * 
     */
    public function store (Request $request, SubKomponen $subkomponen, User $user , Operator $operator) 
    {
        try {
            
            $textEditor = null;
            $user = $user::find($request->user_id);
            $operator = Operator::first();
            $setStatusSubKomponen = [];
            $setStatusBuktiFisik = [];
            $setTypeData = [];

            $data = collect($request->repeater)->map(function ($val) use ($subkomponen, $user, $request, $operator, &$setStatusSubKomponen, &$setStatusBuktiFisik, &$setTypeData) {
                
                $val['user_id'] = $request->user_id;
                $val['type'] = $request->type;
                
                $val['notes'] = ($val['type'] == 'subkomponen' || $val['type'] == 'bukti_fisik') ? $val['catatan'] : $val['notes'];
                
                if (!$user) {
                    return response()->json(['message' => 'User id Not Found'], 404);
                }
                
                if(auth()->user()->currentAccessToken()->getAttributeValue('abilities')[0] == 'role:operator') {
                    $textEditor = $val['pleno'];
                } elseif (auth()->user()->currentAccessToken()->getAttributeValue('abilities')[0] == 'role:verifikator_desk') {
                    $textEditor = $val['notes'];
                } else {
                    $textEditor = $val['verifikasi_lapangan'];
                }
                
                DB::beginTransaction();

                if(!empty($textEditor)) {
                    $dom = new \domdocument();
                    $dom->loadHtml($textEditor, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                    $images = $dom->getelementsbytagname('img');
        
                    foreach($images as $key => $img) {
                        $data = $img->getattribute('src');
                        list($type, $data) = explode(';', $data);
                        list(, $data)      = explode(',', $data);

                        $data = base64_decode($data);
                        $image_name= time().$k.'.png';
                        $path = public_path() .'/'. $image_name;

                        file_put_contents($path, $data);

                        $img->removeattribute('src');
                        $img->setattribute('src', $image_name);
                    }

                    $detail = $dom->savehtml();
                } else {
                    $detail = null;
                }

                if (auth()->user()->currentAccessToken()->getAttributeValue('abilities')[0] == 'role:operator') {
                    
                    $subKomponen->komentar_pleno = $detail;
                } elseif (auth()->user()->currentAccessToken()->getAttributeValue('abilities')[0] == 'role:verifikator_desk') {
                    $status = (boolean) $val['status'];
                    $setTypeData[] = $val['type'];
                    
                    if($val['type'] == 'perpustakaan') {
                        $val['library_id'] = $request->library_id;
                        
                        if($status) {
                            $user->library->status_verifikator = $status;
                            $user->library->notes = $detail;
                            $user->status_perpustakaan = (boolean) true;

                            $postMail = [
                                'email' => [$user->email, $operator->email],
                                'title' => 'Form Data Perpustakaan sudah sesuai',
                                'status' => 'profil_perpustakaan',
                                'body' => $user->library,
                            ];

                            dispatch(new SendEmailJob($postMail));

                        } else {
                            
                            $user->type_insert = "0";
                            $user->library->notes = $detail;
                            $user->library->status_verifikator = $status;

                            $postMail = [
                                'email' => [$user->email, $operator->email],
                                'title' => 'Form Data Perpustakaan tidak sesuai',
                                'status' => 'profil_perpustakaan',
                                'body' => $user->library,
                            ];

                            dispatch(new SendEmailJob($postMail));
                        }
                        $user->library->save();
                    } elseif ($val['type'] == 'subkomponen') {
                        if($status) {
                            $setStatusSubKomponen[] = $val['status'];
                            $subKomponen = $user->with(['komponen' => function ($query) use ($val, $detail, $status) {
                                $query->where('id', $val['id'])->update(['status_verifikator' => $status, 'notes' =>  $detail]);
                            }])->find($val['user_id']);
                            
                        } else {
                            $subKomponen = $user->with(['komponen' => function ($query) use ($val, $detail, $status) {
                                $query->where('id', $val['id'])->update(['status_verifikator' => $status, 'notes' =>  $detail]);
                            }])->find($val['user_id'])->update(['type_insert' => "1"]);
                        }
                        
                    } elseif ($val['type'] == 'bukti_fisik') {
                        if($status) {
                            $setStatusBuktiFisik[] = $val['status'];
                            $buktiFisik = $user->with(['buktiFisik' => function ($query) use ($val, $detail, $status) {
                                $query->where('id', $val['id'])->update(['status_verifikator' => $status, 'notes' =>  $detail]);
                            }])->find($val['user_id']);
                            
                        } else {
                            $buktiFisik = $user->with(['buktiFisik' => function ($query) use ($val, $detail, $status) {
                                $query->where('id', $val['id'])->update(['status_verifikator' => $status, 'notes' =>  $detail]);
                            }])->find($val['user_id'])->update(['type_insert' => "2"]);
                        }
                    }

                } else {
                    $subKomponen->verifikasi_lapangan = $detail;
                }
               
                $user->save();
                DB::commit();
            });

            if(count($setStatusSubKomponen) == 9 && $setTypeData[0] == 'subkomponen') {
                $user->status_subkomponent = (boolean) true;
                
                $postMail = [
                    'email' => [$user->email, $operator->email],
                    'title' => 'Form Data komponen sudah Sesuai',
                    'status' => 'komponen_perpustakaan',
                    'body' => $user,
                ];

                dispatch(new SendEmailJob($postMail));

            } else {
                if( $setTypeData[0] == 'subkomponen' ) {
                    $user->status_subkomponent = (boolean) false;
    
                    $postMail = [
                        'email' => [$user->email, $operator->email],
                        'title' => 'Form Data komponen tidak sesuai',
                        'status' => 'komponen_perpustakaan',
                        'body' => $user,
                    ];
    
                    dispatch(new SendEmailJob($postMail));
                }
            }
            
            if(count($setStatusBuktiFisik) == 9 && $setTypeData[0] == 'bukti_fisik') 
            {
                $user->status_buktifisik = (boolean) true;
                $postMail = [
                    'email' => [$user->email, $operator->email],
                    'title' => 'Form Data bukti fisik sudah Sesuai',
                    'status' => 'bukti_fisik_perpustakaan',
                    'body' => $user,
                ];

                dispatch(new SendEmailJob($postMail));
            } else {
                if ( $setTypeData[0] == 'bukti_fisik' ) {
                    $user->status_buktifisik = (boolean) false;
                    $postMail = [
                        'email' => [$user->email, $operator->email],
                        'title' => 'Form Data bukti fisik tidak Sesuai',
                        'status' => 'bukti_fisik_perpustakaan',
                        'body' => $user,
                    ];

                    dispatch(new SendEmailJob($postMail));
                }
            }

            $user->save();

            return response()->json(['message' => 'success save notes'], HttpResponse::HTTP_CREATED);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while store data: ' . $e->getMessage()], 400);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while store data: ' . $ex->getMessage()], 400);
        } 
    }



}
