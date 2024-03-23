<?php

namespace App\Http\Controllers\Api\Backend\Verifikator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Library;
use App\Models\User;
use App\Models\Operator;
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
     */public function doneNotification(Request $request, User $user) 
     {
        try{
            $users = User::find($request->id);
            $operator = Operator::first();
            
            if($request->type_form == 'library') 
            {
                $library = User::find($request->id)->library;

                if($library)
                {
                    $library->status_verifikator  = 1;  
                    $library->save();
                    
                    $postMail = [
                        'email' => $operator->email,
                        'title' => 'Form Data Profil Perpustakaan Sesuai',
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
                        $value->status_verifikator  = 1;  
                        $value->save();
                    }

                    $postMail = [
                        'email' => $operator->email,
                        'title' => 'Form Data Komponen Sesuai',
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
                        $value->status_verifikator  = 1;  
                        $value->save();
                    }

                    $postMail = [
                        'email' => $operator->email,
                        'title' => 'Form Data Bukti Fisik Perpustakaan Sesuai',
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
      * notifikasi belum sesuai
      * 
      * @param Request $request
      * 
      * @return JsonResponse
      */
      public function notYetNotification(Request $request, User $user) 
      {
        try{
            $users = User::find($request->id);
            
            if($request->type_form == 'library') 
            {
                $library = User::find($request->id)->library;

                if($library)
                {
                    $library->status_verifikator  = 2;  
                    $library->save();
                    
                    $postMail = [
                        'email' => $operator->email,
                        'title' => 'Form Data Profil Perpustakaan belum sesuai',
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
                        $value->status_verifikator  = 2;  
                        $value->save();
                    }

                    $postMail = [
                        'email' => $operator->email,
                        'title' => 'Form Data Komponen Tidak Sesuai',
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
                        $value->status_verifikator  = 2;  
                        $value->save();
                    }

                    $postMail = [
                        'email' => $operator->email,
                        'title' => 'Form Data Bukti Fisik Perpustakaan Tidak Sesuai',
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

}
