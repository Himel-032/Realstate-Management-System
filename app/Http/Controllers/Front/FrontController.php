<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Property;
use App\Models\PropertyPhoto;
use App\Models\PropertyVideo;
use App\Models\Agent;
use App\Mail\Websitemail;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $properties = Property::where('status','Active')->orderBy('id','asc')->take(6)->get();
        return view('front.home', compact('properties'));
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
}
