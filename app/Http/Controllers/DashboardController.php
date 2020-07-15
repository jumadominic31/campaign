<?php

namespace App\Http\Controllers;

use App\Group;
use App\Contact;
use App\Smslog;
use App\Atgcredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $numgroups = Group::where('customer_id', '=', '1')->count();
        $numcontacts = Contact::where('customer_id', '=', '1')->count();
        $numsentmsgs = Smslog::where('customer_id', '=', '1')->count();

        $apidetails = Atgcredential::where('customer_id', '=', '1')->first();
        $atgusername   = $apidetails->atgusername;
        $atgapikey     = $apidetails->atgapikey;
        $response = Http::asForm()->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'apiKey' => $atgapikey
        ])->get('https://api.africastalking.com/version1/user?username='.$atgusername);
        $balance = json_decode($response->body())->UserData->balance;

        return view('dashboard.index', ['numgroups' => $numgroups, 'numcontacts' => $numcontacts, 'numsentmsgs' => $numsentmsgs, 'balance' => $balance]);
    }
}
