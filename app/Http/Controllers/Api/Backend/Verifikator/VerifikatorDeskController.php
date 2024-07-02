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
            $countdataPleno = [];
            $setStatusSubKomponen = [];
            $setStatusBuktiFisik = [];
            $setTypeData = [];

            $data = collect($request->repeater)->map(function ($val) use ($subkomponen, $user, $request, $operator, &$setStatusSubKomponen, &$setStatusBuktiFisik, &$setTypeData, &$countdataPleno) {
                
                $val['user_id'] = $request->user_id;
                $val['type'] = $request->type;
                
                if (!$user) {
                    return response()->json(['message' => 'User id Not Found'], 404);
                }
                
                if(auth()->user()->currentAccessToken()->getAttributeValue('abilities')[0] == 'role:operator') {
                    $textEditor = $val['pleno'];
                } elseif (auth()->user()->currentAccessToken()->getAttributeValue('abilities')[0] == 'role:verifikator_desk') {
                    $textEditor = ($val['type'] == 'subkomponen' || $val['type'] == 'bukti_fisik') ? $val['catatan'] : $val['notes'];
                } else {
                    $textEditor = $val['verifikasi_lapangan'];
                }
                
                DB::beginTransaction();

                if(!empty($textEditor)) {
                    $dom = new \domdocument();
                    $dom->loadHtml($textEditor, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                    $images = $dom->getElementsByTagName('img');
                   
                    foreach($images as $key => $img) {
                        
                        $data = $img->getattribute('src');
                        if (strpos($data, 'data:image') !== false) {
                            list($type, $data) = explode(';', $data);
                            list(, $data)      = explode(',', $data);
                            $data = base64_decode($data);
                            
                            $image_name= '/editor/' . time().$key.'.png';
                            $path = public_path() . $image_name;
                            
                            file_put_contents($path, $data);

                            $img->removeattribute('src');
                            $img->setattribute('src', $image_name);
                        }
                    }
                    $detail = $dom->savehtml();
                } else {
                    $detail = null;
                }
               
                if (auth()->user()->currentAccessToken()->getAttributeValue('abilities')[0] == 'role:operator') {
                    
                    $countdataPleno[] = $detail;

                    $subKomponen = $user->with(['komponen' => function ($query) use ($val, $detail) {
                        $query->where('id', $val['id'])->update(['komentar_pleno' =>  $detail]);
                    }])->find($val['user_id']);

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
                                'role' => 'Verifikator Desk',
                                'role_to' => 'PIC & Operator',
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
                                'role' => 'Verifikator Desk',
                                'role_to' => 'PIC & Operator',
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
                   
                    if($val['type'] == 'perpustakaan') {
                        $val['library_id'] = $request->library_id;
                        
                        $user->library->verifikasi_lapangan = $detail;

                        $postMail = [
                            'email' => [$user->email, $operator->email],
                            'title' => 'Form Data Perpustakaan sudah di verifikasi lapangan',
                            'status' => 'profil_perpustakaan',
                            'role' => 'Verifikator Desk',
                            'role_to' => 'PIC & Operator',
                            'body' => $user->library,
                        ];

                        dispatch(new SendEmailJob($postMail));
            
                        $user->library->save();
                    
                    } elseif ($val['type'] == 'subkomponen') {
                        $subKomponen = $user->with(['komponen' => function ($query) use ($val, $detail) {
                            $query->where('id', $val['id'])->update(['verifikasi_lapangan' =>  $detail]);
                        }])->find($val['user_id']);
                        
                    } elseif ($val['type'] == 'bukti_fisik') {
                        $buktiFisik = $user->with(['buktiFisik' => function ($query) use ($val, $detail) {
                            $query->where('id', $val['id'])->update(['verifikasi_lapangan' =>  $detail]);
                        }])->find($val['user_id']);
        
                    }
                }
               
                $user->save();
                DB::commit();
            });

            if( auth()->user()->currentAccessToken()->getAttributeValue('abilities')[0] == 'role:verifikator_desk' ) {
                if(count($setStatusSubKomponen) == 9 && $setTypeData[0] == 'subkomponen') {
                    $user->status_subkomponent = (boolean) true;
                    
                    $postMail = [
                        'email' => [$user->email, $operator->email],
                        'title' => 'Form Data komponen sudah Sesuai',
                        'status' => 'komponen_perpustakaan',
                        'role' => 'Verifikator Desk',
                        'role_to' => 'PIC & Operator',
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
                            'role' => 'Verifikator Desk',
                            'role_to' => 'PIC & Operator',
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
                        'role' => 'Verifikator Desk',
                        'role_to' => 'PIC & Operator',
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
                            'role' => 'Verifikator Desk',
                            'role_to' => 'PIC & Operator',
                            'body' => $user,
                        ];
    
                        dispatch(new SendEmailJob($postMail));
                    }
                }
    
                $user->save();
            } else if (auth()->user()->currentAccessToken()->getAttributeValue('abilities')[0] == 'role:operator') {
                if (count($countdataPleno) == 9) {
                    $user->is_pleno = (boolean) true;
                }
                $user->save();
            }

            return response()->json(['message' => 'success save notes'], HttpResponse::HTTP_CREATED);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while store data: ' . $e->getMessage()], 400);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while store data in database: ' . $ex->getMessage()], 400);
        } 
    }



}
