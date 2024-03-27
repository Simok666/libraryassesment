<?php

namespace App\Http\Controllers\Api\Backend\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operator;
use App\Models\User;
use App\Models\Komponen;
use App\Models\SubKomponen;
use App\Models\BuktiFisikData;
use App\Models\BuktiFisik;
use App\Models\VerifikatorDesk;
use App\Models\VerifikatorField;
use App\Models\Library;
use Mail;
use App\Mail\PostMail;
use App\Jobs\SendEmailJob;
use App\Http\Requests\Backend\Operator\OperatorVerifiedRequest;
use App\Http\Resources\Backend\Operator\OperatorResource;
use App\Http\Resources\Backend\Operator\OperatorVerifiedResource;
use App\Http\Resources\Backend\Operator\OperatorListLibrary;
use App\Http\Resources\Backend\Operator\OperatorListKomponen;
use App\Http\Resources\Backend\Operator\OperatorListBuktiFisik;
use App\Http\Resources\Backend\Operator\OperatorDetailLibrary;
use App\Http\Resources\Backend\Operator\OperatorDetailKomponen;
use App\Http\Resources\Backend\Operator\OperatorDetailBukti;
use App\Http\Resources\Backend\Verifikator\VerifikatorDeskResource;
use App\Http\Resources\Backend\Verifikator\VerifikatorFieldResource;
use App\Http\Resources\Backend\User\UserResource;
use App\Http\Resources\Backend\User\UserSubKomponenResource;
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
    public function getUserAccount(Request $request)
    {
        return OperatorResource::collection(
            User::when(request()->filled("id"), function ($query){
                $query->where('id', request("id"));
            })->paginate($request->limit ?? "10")
        );
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
            $users->is_verified = (Boolean) $request->is_verified;
            $users->save();
            
            if($users->is_verified) {

                $postMail = [
                    'email' => $users->email,
                    'title' => 'Your Account Has Been Verified',
                    'status' => 'verifikasi',
                    'body' => $users,
                ];
                
                dispatch(new SendEmailJob($postMail));
                
            }

            return response()->json(['message' => 'User updated successfully'], HttpResponse::HTTP_CREATED);
            
            return response()->json(['message' => 'Your Account has been verified'], 409);
        } catch(\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating data: ' . $e->getMessage()], 400);
        }
        
    }

    /**
     * index of library user
     * 
     * @param Request $request
     * 
     * @return JsonResponse
     * 
     */
    public function getListLibrary(Request $request)
    {
        $library = User::with(['library' => function ($query) use ($request) {
                        $query->where('status', $request->status); 
                    }])->paginate($request->limit);


        return  OperatorListLibrary::collection($library);
       
    }

    /**
     * index of komponen user
     * 
     * @param Request $request
     * 
     * @return JsonResponse
     * 
     */
    public function getListKomponen(Request $request)
    {
        $komponen =  User::with(['komponen' => function ($query) use ($request) {
            $query->where('status', $request->status); 
        }])->paginate($request->limit);
    
        return OperatorListKomponen::collection($komponen);
    }

    /**
     * index of buktifisik user
     * 
     * @param Request $request
     * 
     * @return JsonResponse
     * 
     */
    public function getListBuktiFisik(Request $request)
    {   
        $buktiFisik = User::with(['buktiFisik' => function ($query) use ($request) {
                        $query->where('status', $request->status); 
                    }])->paginate($request->limit);
        
        return  OperatorListBuktiFisik::collection($buktiFisik);
    }

    /**
     * get detail library user
     * 
     * @param Request $request
     * 
     * @return JsonResponse
     * 
     */
    public function getDetailData(Request $request, User $user) {
        try {
            $users = $user::find($request->id);

            if($request->type_form == 'library') 
            {   
                if($users->library == null) {
                    return response()->json(['error' => 'An error data not found'], 404);
                }

                return new OperatorDetailLibrary($users->library);

            } elseif ($request->type_form == 'subkomponen')
            {
                $subKomponen = Komponen::with(['subKomponens'=> function ($query) use ($request) {
                    $query->where('user_id', $request->id);
                }])->where('jenis_perpustakaan', $users->library->jenis_perpustakaan)->get();

                return  OperatorDetailKomponen::collection($subKomponen);
            } elseif ($request->type_form == 'buktifisik')
            {
                $buktiFisik = BuktiFisikData::with(['buktiFisik'=> function ($query) use ($request) {
                    $query->where('user_id', $request->id);
                }])->get();
                
                return  OperatorDetailBukti::collection($buktiFisik);
            }
        } catch(\Exception $e) {
            return response()->json(['error' => 'An error occurred while get data: ' . $e->getMessage()], 400);
        }
        
    }

    /**
     * get list verifikator desk user
     * 
     * @param VerifikatorDesk $desk
     * 
     * @return JsonResponse
     * 
     */
    public function getListVerifikatorDesk( VerifikatorDesk $desk) 
    {
        return  VerifikatorDeskResource::collection($desk::paginate(10));
    }

    /**
     * get list verifikator field user
     * 
     * @param VerifikatorField $field
     * 
     * @return JsonResponse
     * 
     */
    public function getListVerifikatorField( VerifikatorField $field) 
    {
        return  VerifikatorFieldResource::collection($field::paginate(10));
    }

    /**
     * notify email every verifikator field 
     * 
     * @param VerifikatorDesk $desk
     * @param VerifikatorField $field
     * @param User $user
     * 
     * @return JsonResponse
     * 
     */
    public function notifyEmailVerifikator(Request $request, VerifikatorDesk $desk, VerifikatorField $field,User $user)
    {
        try {
            $verifikator = null;
            ($request->type == 'desk') ? $verifikator = $desk::find($request->id) : $verifikator = $field::find($request->id);
            
            $dataLibrary = Library::where('status', 'Baru')->update(['status' => 'Aktif']);
            $dataSubKomponen = SubKomponen::where('status', 'Baru')->update(['status' => 'Aktif']);
            $dataBuktiFisik = BuktiFisik::where('status', 'Baru')->update(['status' => 'Aktif']);
            
            $postMail = [
                'email' => $verifikator->email,
                'title' => 'Status usulan disetujui operator',
                'status' => 'verifikator',
                'body' => 'mohon check usulan dari PIC',
            ];
                
            dispatch(new SendEmailJob($postMail));

            return response()->json(['message' => 'notified with successfully'], HttpResponse::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while notif email: ' . $e->getMessage()], 400);
        }
    }
    
    /**
     * function for store data 
     * 
     * @param Request $request
     * @param SubKomponen $user
     * 
     */
     public function store(Request $request, SubKomponen $subkomponen) 
     {
        try {
            $subKomponen = $subkomponen::find($request->id);
            $notes = $request->notes;
    
            $dom = new \domdocument();
            $dom->loadHtml($notes, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    
            $images = $dom->getelementsbytagname('img');
    
            foreach($images as $key => $img) {
    
            }
        } catch (\Exception $e) {
            
        }
     }





}
