<?php

namespace App\Http\Controllers;

use App\Group;
use App\Customer;
use App\Contact;
use App\Contactgroupcombo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class GroupsController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        return view('groups.index', ['groups' => $groups]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        
        $group = new Group;
        $group->name = $request->input('name');
        if ($request->input('description') != null) 
        {
            $group->description = $request->input('description');
        }
        $group->customer_id = '1';
        $group->save();

        return redirect('/groups')->with('success', 'Group added');
    }

    public function edit($id)
    {
        $group = Group::where('customer_id', '=', '1')->find($id);
        $membership = Contactgroupcombo::where('customer_id', '=', '1')->select('contact_id')->where('group_id', '=', $id)->get();
        if ($group == null){
            return redirect('/groups')->with('error', 'Group not found');
        }

        return view('groups.edit',['group' => $group, 'membership' => $membership]);
    }

    public function update(Request $request, $id)
    {
        $group = Group::where('id', '=', $id)->first();
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails())
        {
            $error = $validator->errors()->all();
            return redirect()->back()->with('error', "Please enter the required fields");
        }
        
        $user_id = Auth::user()->id;

        $group->name = $request->input('name');
        if ($request->input('description') != null) 
        {
            $group->description = $request->input('description');
        }
        $group->customer_id = '1';
        $group->save();

        return redirect('/groups')->with('success', 'Group updated');
       
    }

    public function destroy($id)
    {
        $contactgroupcombo = Contactgroupcombo::where('customer_id', '=', '1')->select('id')->where('group_id', '=', $id)->pluck('id')->toArray();

        if (!empty($contactgroupcombo)) 
        {
            return redirect('/groups')->with('error', 'Disassociate contacts before you delete the group');
        }
        $group = Group::find($id);
        $group->delete();
        return redirect('/groups')->with('success', 'Group Deleted');
    }    
}
