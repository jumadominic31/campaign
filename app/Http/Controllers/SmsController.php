<?php

namespace App\Http\Controllers;

use App\Group;
use App\Customer;
use App\Contactgroupcombo;
use App\Contact;
use App\Atgcredential;
use App\Smslog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SmsController extends Controller
{
     public function compose()
     {
        $groups = Group::select('id', 'name')->get();
        $contacts = Contact::select('id', 'name')->get();
        return view('compose.index', ['groups' => $groups, 'contacts' => $contacts]);
     }

     public function sendmsg(Request $request)
     {
         $user = Auth::user();
         $user_id = $user->id;
         $apidetails = Atgcredential::where('customer_id', '=', '1')->first();
         $atgusername   = $apidetails->atgusername;
         $atgapikey     = $apidetails->atgapikey;

         $message = $request->msgarea;
         $contacts = $request->input('contacts');
         if ($contacts == null){
            $contacts = [];
         }
         $groups = $request->input('groups');
         if ($groups == null){
            $groups = [];
         }

         if (!empty($groups)) 
         {
            $groupcontacts = [];
            foreach ($groups as $group){
               $groupcontacts = Contactgroupcombo::select('contact_id')->where('group_id', '=', $group)->pluck('contact_id')->toArray();
               foreach ($groupcontacts as $groupcontact){
                  $contacts[] = $groupcontact;
               }
            }
         }

         $contacts = array_unique($contacts);

         if (!empty($contacts)) 
         {
            foreach ($contacts as $contact){
               $phone = Contact::select('phone')->where('id', '=', $contact)->pluck('phone')->first();
               $recipients = "+". $phone;
               $from = $apidetails->atgsender_id;

               $gateway    = new AfricasTalkingGateway($atgusername, $atgapikey);
               
               try 
               { 
                  $results = $gateway->sendMessage($recipients, $message, $from);
                           
                  foreach($results as $result) {

                        // echo " Number: " .$result->number;
                        // echo " Status: " .$result->status;
                        // echo " StatusCode: " .$result->statusCode;
                        // echo " MessageId: " .$result->messageId;
                        // echo " Cost: "   .$result->cost."\n";
                        $smslog = new Smslog();
                        $smslog->customer_id = "1";
                        $smslog->contact_id = $contact;
                        $smslog->message = $message;
                        $smslog->cost = $result->cost;
                        $smslog->status = $result->status;
                        $smslog->save();
 
                  }
                  
               }
               catch ( AfricasTalkingGatewayException $e )
               {
                  echo "Encountered an error while sending: ".$e->getMessage();
               }
            }
         }

         return redirect('/compose')->with('success', 'Messages sent');

     }

     public function sent()
     {
        $sentmsgs = Smslog::where('customer_id', '=', '1')->get();
        return view('sent.index', ['sentmsgs' => $sentmsgs]);
     }
}
