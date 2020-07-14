<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Contact;
use App\Group;
use App\Contactgroupcombo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class ContactsController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        $groups = Group::where('customer_id', '=', '1')->get();
        return view('contacts.index', ['contacts' => $contacts, 'groups' => $groups]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required'
        ]);
        $groups = [];

        if ($validator->fails())
        {
            $error = $validator->errors()->all();
            return response()->json(['error' => $error]);
        }
        
        $contact = new Contact;
        if ($request->input('title') != null) {
            $contact->title = $request->input('title');
        }
        $contact->name = $request->input('name');
        $contact->phone = $request->input('phone');
        if ($request->input('email') != null) 
        {
            $contact->email = $request->input('email');
        }
        if ($request->input('gender') != null) 
        {
            $contact->gender_id = $request->input('gender');
        }
        if ($request->input('opt_in') != null) 
        {
            $contact->opt_in = $request->input('opt_in');
        }
        $contact->customer_id = '1';
        $contact->save();

        $groups = $request->input('groups');
        if (!empty($groups)) 
        {
            foreach ($groups as $group){
                $congrpcombo = new Contactgroupcombo;
                $congrpcombo->customer_id = '1';
                $congrpcombo->contact_id = $contact->id;
                $congrpcombo->group_id = $group;
                $congrpcombo->save();
            }
        }

        // return redirect('/contacts')->with('success', 'Contact added');
        return response()->json(['contact' => $contact, 'groups' => $groups], 201);
    }

    public function edit($id)
    {
        $contact = Contact::where('customer_id', '=', '1')->find($id);
        $groups = Group::where('customer_id', '=', '1')->get();
        $membership = Contactgroupcombo::where('customer_id', '=', '1')->select('group_id')->where('contact_id', '=', $id)->pluck('group_id')->toArray();
        if ($contact == null){
            return redirect('/contacts')->with('error', 'Contact not found');
        }

        return view('contacts.edit',['contact'=> $contact, 'groups' => $groups, 'membership' => $membership]);
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::where('id', '=', $id)->first();
        $membership = Contactgroupcombo::where('customer_id', '=', '1')->select('group_id')->where('contact_id', '=', $id)->pluck('group_id')->toArray();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required'
        ]);
        $groups = [];

        if ($validator->fails())
        {
            $error = $validator->errors()->all();
            return redirect()->back()->with('error', "Please enter the required fields");
            // return response()->json(['error' => $error, 'message' => 'error']);
        }
        
        $user_id = Auth::user()->id;

        if ($request->input('title') != null) {
            $contact->title = $request->input('title');
        }
        $contact->name = $request->input('name');
        $contact->phone = $request->input('phone');
        if ($request->input('email') != null) 
        {
            $contact->email = $request->input('email');
        }
        if ($request->input('gender') != null) 
        {
            $contact->gender_id = $request->input('gender');
        }
        if ($request->input('opt_in') != null) 
        {
            $contact->opt_in = $request->input('opt_in');
        }
        
        $contact->customer_id = '1';
        $contact->save();

        $groups = $request->input('groups');
        // dd($groups);
        if (!empty($groups)) 
        {
            foreach ($groups as $group)
            {
                if (!in_array($group, $membership))
                {
                    $congrpcombo = new Contactgroupcombo;
                    $congrpcombo->customer_id = '1';
                    $congrpcombo->contact_id = $contact->id;
                    $congrpcombo->group_id = $group;
                    $congrpcombo->save();
                }
                
            }
            foreach ($membership as $member)
            {
                if (!in_array($member, $groups))
                {
                    $congrpcombo = Contactgroupcombo::where('group_id', '=', $member)->where('contact_id', '=', $id)->first();
                    $congrpcombo->delete();
                }
            }
        }
        else
        {
            foreach ($membership as $member)
            {
                $congrpcombo = Contactgroupcombo::where('group_id', '=', $member)->where('contact_id', '=', $id)->first();
                $congrpcombo->delete();
            }
        }

        // return redirect('/contacts')->with('success', 'Contact details updated');
        return  redirect()->back()->with('success', 'Contact details updated');
        // return response()->json(['contact' => $contact, 'groups' => $groups], 204);
    }

    public function destroy($id)
    {
        $contactgroupcombo = Contactgroupcombo::where('customer_id', '=', '1')->select('id')->where('contact_id', '=', $id)->pluck('id')->toArray();
        foreach ($contactgroupcombo as $cgc)
        {
            $congrpcombo = Contactgroupcombo::where('id', '=', $cgc)->first();
            $congrpcombo->delete();
        }
        $contact = Contact::find($id);
        $contact->delete();
        
        // return redirect('/contacts')->with('success', 'Contact Deleted');
        return response()->json(['message' => 'success'], 204);
    }

}
