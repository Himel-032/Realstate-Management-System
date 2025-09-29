<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Websitemail;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyPhoto;
use App\Models\PropertyVideo;

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

    public function delete($id)
    {
        $property = Property::where('id', $id)->first();
        if (!$property) {
            return redirect()->back()->with('error', 'Property not found');
        }
        if ($property->featured_photo != '') {
            unlink(public_path('uploads/' . $property->featured_photo));
        }

        // delete all property photos
        $photos = PropertyPhoto::where('property_id', $property->id)->get();
        foreach ($photos as $photo) {
            if ($photo->photo != '') {
                unlink(public_path('uploads/' . $photo->photo));
            }
            $photo->delete();
        }
        // delete all property videos
        $videos = PropertyVideo::where('property_id', $property->id)->get();
        foreach ($videos as $video) {
            $video->delete();
        }
        $property->delete();
        return redirect()->back()->with('success', 'Property deleted successfully');
    }
   
}
