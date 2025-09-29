<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\Property;
use App\Mail\WebsiteMail;

class AdminAgentController extends Controller
{
    public function index()
    {
        $agents = Agent::orderBy('id', 'asc')->get();
        return view('admin.agent.index', compact('agents'));
    }

    public function create()
    {
        return view('admin.agent.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'unique:agents,email', 'email'],
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'company' => ['required'],
            'designation' => ['required'],
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password'],

        ]);

        


        $final_name = 'agent_' . time() . '.' . $request->photo->extension();

        $request->photo->move(public_path('uploads'), $final_name);

        $agent = new Agent();

        $agent->name = $request->name;
        $agent->email = $request->email;
        $agent->photo = $final_name;
        $agent->company = $request->company;
        $agent->designation = $request->designation;
        $agent->phone = $request->phone;
        $agent->address = $request->address;
        $agent->country = $request->country;
        $agent->state = $request->state;
        $agent->city = $request->city;
        $agent->zip = $request->zip;
        $agent->facebook = $request->facebook;
        $agent->twitter = $request->twitter;
        $agent->linkedin = $request->linkedin;
        $agent->instagram = $request->instagram;
        $agent->website = $request->website;
        $agent->password = bcrypt($request->password);
        $agent->biography = $request->biography;
        $agent->status = $request->status;
         
        if($request->status == '0') {
            $status = 'pending';
        }
        else if($request->status == '2') {
            $status = 'suspended';
        }
        else if($request->status == '1') {
            $status = 'active';
        }

        $agent->save();

        // send email to agent
        $link = route('agent_login');
        $subject = "Your account is created.";
        $message = '<h3>Account information: </h3><br>';
        $message .= 'Name: ' . $request->name . '<br>';
        $message .= 'Email: ' . $request->email . '<br>';
        $message .= 'Status: ' . $status . '<br>';
        $message .= 'Password: ' . $request->password . '<br><br>';
        $message .= 'Please login to your account: <br><a href="' . $link . '">' . $link . '</a>';

        \Mail::to($request->email)->send(new WebsiteMail($subject, $message));

        return redirect()->route('admin_agent_index')->with('success', 'Agent created successfully.');
    }

    public function edit($id)
    {
        $agent = Agent::where('id', $id)->first();

        return view('admin.agent.edit', compact('agent'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:agents,email,' . $id],
            'company' => ['required'],
            'designation' => ['required'],
        ]);

        $agent = Agent::where('id', $id)->first();
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $final_name = 'agent_' . time() . '.' . $request->photo->extension();
            //unlink the old photo
            if ($agent->photo != '') {
                unlink(public_path('uploads/' . $agent->photo));
            }
            $request->photo->move(public_path('uploads'), $final_name);
            $agent->photo = $final_name;
        }
        if ($request->password != '') {
            $request->validate([
                'password' => 'required',
                'confirm_password' => ['required', 'same:password'],
            ]);
            $agent->password = bcrypt($request->password);
        }
        
        $agent->name = $request->name;
        $agent->email = $request->email;
        $agent->company = $request->company;
        $agent->designation = $request->designation;
        $agent->phone = $request->phone;
        $agent->address = $request->address;
        $agent->country = $request->country;
        $agent->state = $request->state;
        $agent->city = $request->city;
        $agent->zip = $request->zip;
        $agent->facebook = $request->facebook;
        $agent->twitter = $request->twitter;
        $agent->linkedin = $request->linkedin;
        $agent->instagram = $request->instagram;
        $agent->website = $request->website;
        $agent->password = bcrypt($request->password);
        $agent->biography = $request->biography;
        $agent->status = $request->status;


        $agent->save();

        return redirect()->route('admin_agent_index')->with('success', 'Agent updated successfully.');
    }
    public function delete($id)
    {
        // agent can't be deleted if he has properties
        $property = Property::where('agent_id', $id)->first();
        if($property) {
            return redirect()->route('admin_agent_index')->with('error', 'Agent can\'t be deleted. He has some properties.');
        }
        $agent = Agent::where('id', $id)->first();
        if ($agent->photo != '') {
            unlink(public_path('uploads/' . $agent->photo));
        }
        $agent->delete();

        return redirect()->route('admin_agent_index')->with('success', 'Agent deleted successfully.');

    }
}
