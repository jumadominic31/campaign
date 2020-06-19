<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Auth;
use Session;

class UsersController extends Controller
{
    public function getSignin()
    {
        return view('users.signin');
    }

    public function postSignin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $request->input('username');

        //Check whether the user active
        $user_id = User::where('username', '=', $username)->pluck('id')->first();
        $user_status = User::where('id', '=', $user_id)->pluck('status')->first();

        //If user is inactive go back
        if ($user_status == '0')
        {
            return redirect()->back()->with('error', 'User Inactive');
        }

        $credentials = array('username' => $request->input('username'), 'password' => $request->input('password'));

        if (Auth::attempt($credentials)) {
            if ($request->session()->has('oldUrl')) {
                $oldUrl = $request->session()->get('oldUrl');
                $request->session()->forget('oldUrl');
                return redirect()->to($oldUrl);
            }

            //Userdetails
            $userdetails = User::where('users.username', '=', $username)->first();

            return redirect()->route('dashboard.index');
        }
        return redirect()->back()->with('error', 'Incorrect username/password');
    }

    public function getLogout() 
    {
        Auth::logout();
        return redirect()->route('users.signin');
    }
}
