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
use Symfony\Component\HttpFoundation\Response as HttpResponse;


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
                    ($typeNotification) ? $library->status_verifikator  = 1 : $library->status_verifikator  = 2;  
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
     * 
     */
    public function store (Request $request) 
    {
        try {
            $subKomponen = $subkomponen::find($request->id);
            $notes = $request->notes;

            if (!$subKomponen) {
                return response()->json(['message' => 'Subkomponen Not Found'], 404);
            }

            $dom = new \domdocument();
            $dom->loadHtml($notes, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    
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
            $subKomponen->notes = $detail;
            $subKomponen->save();
            
            return response()->json(['message' => 'success save notes'], HttpResponse::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while store data: ' . $e->getMessage()], 400);
        } 
    }



}
