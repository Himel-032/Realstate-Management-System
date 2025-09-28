<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Property;
use App\Models\PropertyPhoto;
use App\Models\PropertyVideo;
use App\Models\Agent;
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
}
