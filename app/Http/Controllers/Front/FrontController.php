<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Property;
use App\Models\Location;
use App\Models\PropertyPhoto;
use App\Models\PropertyVideo;
use App\Models\Agent;
use App\Mail\Websitemail;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $properties = Property::where('status','Active')->orderBy('id','asc')->take(3)->get();
        // get the total location wise property
        $locations = Location::withCount(['properties' => function ($query) {
            $query->where('status', 'Active');
        }])->orderBy('name', 'asc')->orderBy('properties_count','desc')->take(4)->get();

        $agents = Agent::where('status',1)->orderBy('id','asc')->take(4)->get();

        return view('front.home', compact('properties', 'locations', 'agents'));
    }
    public function contact()
    {
        return view('front.contact');
    }
    public function select_user()
    {
        return view('front.select_user');
    }
    public function pricing(){
        $packages = Package::orderBy('id','asc')->get();
        return view('front.pricing', compact('packages'));
    }

    public function property_detail($slug){
        $property = Property::where('slug',$slug)->first();
        if(!$property){
            return redirect()->route('front.home')->with('error','Property not found');
        }
        
        return view('front.layouts.property_detail', compact('property'));
    }
    public function property_send_message(Request $request, $id){
        $property = Property::find($id);
        if(!$property){
            return redirect()->route('home')->with('error','Property not found');
        }
        //send email to agent
        $subject = "Property Enquiry";
        $message = "You have received an enquiry for the property: ".$property->name. '<br><br>';
        $message .= 'Visitor Name: '.$request->name.'<br>';
        $message .= 'Visitor Email: '.$request->email.'<br>';
        $message .= 'Visitor Phone: '.$request->phone.'<br>';
        $message .= 'Visitor Message: '.nl2br($request->message);
        $agent_email = $property->agent->email;
        \Mail::to($agent_email)->send(new Websitemail($subject, $message));
        return redirect()->back()->with('success','Your message has been sent successfully. Agent will contact you soon.');
    }

    public function locations()
    {
        // get total property in a particular location
        $locations = Location::withCount(['properties' => function ($query) {
            $query->where('status', 'Active');
        }])->orderBy('properties_count','desc')->paginate(20);
        return view('front.locations', compact('locations'));

    }

    public function location($slug)
    {
        $location = Location::where('slug',$slug)->first();
        if(!$location){
            return redirect()->route('front.locations')->with('error','Location not found');
        }
        $properties = Property::where('location_id',$location->id)->where('status','Active')->orderBy('id','asc')->paginate(6);
        return view('front.location', compact('location','properties'));
    }

    public function agents()
    {
        $agents = Agent::where('status',1)->orderBy('id','asc')->paginate(20);
        return view('front.agents', compact('agents'));
    }
    public function agent($id)
    {
        $agent = Agent::where('id', $id)->first();
        if(!$agent){
            return redirect()->route('home')->with('error','Agenttt not found');
        }
        $properties = Property::where('agent_id',$agent->id)->where('status','Active')->orderBy('id','asc')->paginate(6);
        return view('front.agent', compact('agent','properties'));
    }

}
