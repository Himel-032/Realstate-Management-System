<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Websitemail;
use Illuminate\Http\Request;
use App\Models\Property;

class AdminPropertyController extends Controller
{
    public function index()
    {
        $properties = Property::orderBy('id', 'desc')->get();
        return view('admin.property.index', compact('properties'));
    }
    public function detail($id)
    {
        $property = Property::where('id', $id)->first();
        return view('admin.property.detail', compact('property'));
    }

    public function change_status($id)
    {
        $property = Property::where('id', $id)->first();
        if ($property->status == 'Pending') {
            $property->status = 'Active';
        } else {
            $property->status = 'Pending';
        }
        $property->save();
        // send email to agent
        $link = route('agent_property_index');
        $msg = "Your property status has been changed to " . $property->status . ". Please click on the link to view your properties. <a href='" . $link . "'>Click Here</a>";
        $to = $property->agent->email;
        $subject = "Property Status Changed";
        \Mail::to($to)->send(new Websitemail($subject, $msg));
        return redirect()->back()->with('success', 'Property status changed successfully.');
    }

   
}
