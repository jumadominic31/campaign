<?php

namespace App\Http\Controllers;

use App\Group;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function update(Request $request, $id)
    {
        $group = Group::where('id', '=', $id)->first();
        $this->validate($request, [
            'name' => 'required'
        ]);
        
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
        $group = Group::find($id);
        $group->delete();
        return redirect('/groups')->with('success', 'Group Deleted');
    }    
}
