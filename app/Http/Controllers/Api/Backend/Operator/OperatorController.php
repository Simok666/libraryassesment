<?php

namespace App\Http\Controllers\Api\Backend\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operator;
use App\Models\User;
use App\Models\Komponen;
use App\Models\SubKomponen;
use App\Models\pimpinan;
use App\Models\Pleno;
use App\Models\BuktiFisikData;
use App\Models\BuktiFisik;
use App\Models\VerifikatorDesk;
use App\Models\VerifikatorField;
use App\Models\Library;
use Mail;
use App\Mail\PostMail;
use App\Jobs\SendEmailJob;
use App\Http\Requests\Backend\Operator\PlenoUploadRequest;
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
use PDF;
use DB;
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
        }])->when($request->has('id'), function ($query) use ($request) {
             $query->where('id', request("id"));
        })->paginate($request->limit ?? "10");

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
        $komponen =  User::with(['komponen.komponen'])
        ->whereHas('komponen', function ($query) use ($request) {
            $query->where('status', $request->status);
        })->when($request->has('id'), function ($query) use ($request){
            $query->where('id', request("id"));
        })->paginate($request->limit ?? "10");
    
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
        $buktiFisik = User::with(["buktiFisik.buktiFisikData"])
                    ->whereHas("buktiFisik", function ($query) use ($request) {
                        $query->where("status", $request->status);
                    })->when($request->has("id"), function($query) use ($request){
                        $query->where("id", $request->id);
                    })->paginate($request->limit ?? "10");
        
        return  OperatorListBuktiFisik::collection($buktiFisik);
    }

    /**
     * get list verifikator desk user
     * 
     * @param VerifikatorDesk $desk
     * 
     * @return JsonResponse
     * 
     */
    public function getListVerifikatorDesk(VerifikatorDesk $desk) 
    {
        return  VerifikatorDeskResource::collection($desk::when(request()->filled("id"), function ($query){
            $query->where('id', request("id"));
        })->paginate(request("limit") ?? "10"));
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
        return  VerifikatorFieldResource::collection($field::when(request()->filled("id"), function ($query){
            $query->where('id', request("id"));
        })->paginate(request("limit") ?? "10"));
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
     * function generate pdf
     * 
     * @param Request $request
     * @param SubKomponen $sk
     * 
     */
    public function generatepdf(Request $request, SubKomponen $sk) 
    {
        $subKomponen  = User::with(['komponen.komponen'])
                        ->where('id', $request->id)->first();
        
        $pdf = PDF::loadView('pdf.pleno', $subKomponen);

        return $pdf->download('pleno-'."$subKomponen->id"."-"."$subKomponen->library_name".'.pdf');
    }

    /**
     * function get list pleno
     * 
     * @param Request $request
     * @param User $user
     * 
     */
    public function getListPleno(Request $request) {
        $komponen =  User::with(['pleno'])
        ->whereHas('komponen', function ($query) use ($request) {
            $query->where('status', $request->status);
        })->when($request->has('id'), function ($query) use ($request){
            $query->where('id', request("id"));
        })->paginate($request->limit ?? "10");
    }
    
    /**
     * function upload pleno dan draft sk 
     * 
     * @param Request $request
     * @param Pleno $pleno
     * 
     */
    public function upload(PlenoUploadRequest $request, Pleno $pleno) 
    {
        try {
            DB::beginTransaction();
                if((auth()->user()->currentAccessToken()->getAttributeValue('abilities')[0] == 'role:operator')) {
                    
                    $store = $pleno::create(array_merge($request->validated(), ['user_id' => request("id")]));
                    if ($images = $request->pleno_upload) {
                        foreach ($images as $image) {
                            $store->addMedia($image)->toMediaCollection('pleno_file');
                        }
                    }
                    if ($draftSk = $request->draft_sk_upload) {
                        foreach ($draftSk as $sk) {
                            $store->addMedia($sk)->toMediaCollection('sk_file');
                        }
                    }

                } elseif ((auth()->user()->currentAccessToken()->getAttributeValue('abilities')[0] == 'role:pimpinan_sesban')) {
                    $sesban = Pleno::where('user_id', request("id"));
                    $sesban->update();
                    if($skPimpinan = $request->sk_upload_pimpinan) {
                        foreach ($skPimpinan as $pimpinan) {
                            $sesban->addMedia($pimpinan)->toMediaCollection('sk_upload_pimpinan');
                        }
                    }
                } elseif (auth()->user()->currentAccessToken()->getAttributeValue('abilities')[0] == 'role:pimpinan_kaban') {
                    $kaban = Pleno::find(request("id"));
                    User::with(['komponen.komponen'])->whereHas('komponen', function ($query) use ($request) {
                        $query->update('is_pleno', 1);
                    })->when($request->has("id"), function ($query) use ($request){
                        $query->where('id', request("id"));
                    });

                    $kaban->update();
                    if($skPimpinanKaban = $request->sk_upload_pimpinan_kaban) {
                        foreach ($skPimpinanKaban as $pimpinanKaban) {
                            $sesban->addMedia($pimpinanKaban)->toMediaCollection('sk_upload_pimpinan_kaban');
                        }
                    }
                }
            DB::commit();
            
            if($store) {
                $pimpinan = pimpinan::first();
                $postMail = [
                    'email' => $pimpinan->email,
                    'title' => 'Operator Has Been Upload Pleno and Draft Sk',
                    'status' => 'pleno',
                    'body' => User::with(['pleno'])->whereHas("pleno", function ($query) use ($request) {
                        $query->where("user_id", $request->id);
                    })->first(),
                ];
                dispatch(new SendEmailJob($postMail));
            }
            return response()->json(['success' => 'success save data'], HttpResponse::HTTP_CREATED);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while creating account: '. $ex->getMessage()], 400);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while upload pleno: ' . $e->getMessage()], 400);
        }

        /**
         * public function
         * 
         * 
         * 
         */
        
    }

}
