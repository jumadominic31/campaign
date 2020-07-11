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
// use Validator;

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

    public function update(Request $request, $id)
    {
        $contact = Contact::where('id', '=', $id)->first();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required'
        ]);
        $groups = [];

        if ($validator->fails())
        {
            $error = $validator->errors()->all();
            return response()->json(['error' => $error, 'message' => 'error']);
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

        // return redirect('/contacts', ['success' => 'Contact updated', 'groups' => $groups]);
        return response()->json(['contact' => $contact, 'groups' => $groups], 204);
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        // return redirect('/contacts')->with('success', 'Contact Deleted');
        return response()->json(['message' => 'success'], 204);
    }
    
    public function getgroups($contact_id)
    {
        $groups = Contactgroupcombo::join('groups', 'contactgroupcombos.group_id', '=', 'groups.id')->select('contactgroupcombos.group_id', 'groups.name' )->where('contact_id', '=', $contact_id)->get();
        return response()->json(['groups' => $groups], 200);
    }
}
