<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Property;
use App\Models\Location;
use App\Models\Type;
use App\Models\Amenity;
use App\Models\PropertyPhoto;
use App\Models\PropertyVideo;
use App\Models\Agent;
use App\Models\User;
use App\Models\Testimonial;
use App\Mail\Websitemail;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Auth;

class FrontController extends Controller
{
    public function index()
    {
        // get wishlist id of the logged in user
        $wishlist_ids = [];
        if(Auth::guard('web')->check()) {
            $user_id = Auth::guard('web')->user()->id;
            $wishlist_ids = Wishlist::where('user_id', $user_id)->pluck('property_id')->toArray();
        }

        // only featured and package is up to date property
        $properties = Property::where('status', 'Active')->where('is_featured', 'Yes')
            ->whereHas('agent', function ($query) {
                $query->whereHas('orders', function ($q) {
                    $q->where('currently_active', 1)
                        ->where('status', 'Completed')
                        ->where('expire_date', '>=', now());
                });
            })
            ->orderBy('id', 'asc')->take(3)->get();
        // get the total location wise property
        $locations = Location::withCount([
            'properties' => function ($query) {
                $query->where('status', 'Active')
                ->whereHas('agent', function($q) {
                    $q->whereHas('orders', function ($qq) {
                        $qq->where('currently_active', 1)
                            ->where('status', 'Completed')
                            ->where('expire_date', '>=', now());
                    });
                });
            }
        ])->orderBy('name', 'asc')->orderBy('properties_count', 'desc')->take(4)->get();

        $agents = Agent::where('status', 1)->orderBy('id', 'asc')->take(4)->get();

        $search_locations = Location::orderBy('name', 'asc')->get();
        $search_types = Type::orderBy('name', 'asc')->get();

        $testimonials = Testimonial::orderBy('id', 'asc')->get();

        return view('front.home', compact('properties', 'locations', 'agents', 'search_locations', 'search_types', 'wishlist_ids', 'testimonials'));
    }
    public function contact()
    {
        return view('front.contact');
    }
    public function select_user()
    {
        return view('front.select_user');
    }
    public function pricing()
    {
        $packages = Package::orderBy('id', 'asc')->get();
        return view('front.pricing', compact('packages'));
    }

    public function property_detail($slug)
    {
        $property = Property::where('slug', $slug)->first();
        if (!$property) {
            return redirect()->route('front.home')->with('error', 'Property not found');
        }

        return view('front.layouts.property_detail', compact('property'));
    }
    public function property_send_message(Request $request, $id)
    {
        $property = Property::find($id);
        if (!$property) {
            return redirect()->route('home')->with('error', 'Property not found');
        }
        //send email to agent
        $subject = "Property Enquiry";
        $message = "You have received an enquiry for the property: " . $property->name . '<br><br>';
        $message .= 'Visitor Name: ' . $request->name . '<br>';
        $message .= 'Visitor Email: ' . $request->email . '<br>';
        $message .= 'Visitor Phone: ' . $request->phone . '<br>';
        $message .= 'Visitor Message: ' . nl2br($request->message);
        $agent_email = $property->agent->email;
        \Mail::to($agent_email)->send(new Websitemail($subject, $message));
        return redirect()->back()->with('success', 'Your message has been sent successfully. Agent will contact you soon.');
    }

    public function locations()
    {
       // get total property in a particular location
        // $locations = Location::withCount([
        //     'properties' => function ($query) {
        //         $query->where('status', 'Active');
        //     }
        // ])->orderBy('properties_count', 'desc')->paginate(20);

        // Hide property whose package is expired
        $locations = Location::withCount([
            'properties' => function ($query) {
                $query->where('status', 'Active')
                    ->whereHas('agent', function ($q) {
                        $q->whereHas('orders', function ($qq) {
                            $qq->where('currently_active', 1)
                                ->where('status', 'Completed')
                                ->where('expire_date', '>=', now());
                        });
                    });
            }
        ])->orderBy('name', 'asc')->orderBy('properties_count', 'desc')->paginate(20);
        return view('front.locations', compact('locations'));

    }

    public function location($slug)
    {
        $location = Location::where('slug', $slug)->first();
        if (!$location) {
            return redirect()->route('front.locations')->with('error', 'Location not found');
        }
        //  $properties = Property::where('location_id',$location->id)->where('status','Active')->orderBy('id','asc')->paginate(6);


        $properties = Property::where('location_id', $location->id)
            ->where('status', 'Active')
            ->whereHas('agent', function ($query) {
                $query->whereHas('orders', function ($q) {
                    $q->where('status', 'Completed')
                        ->where('expire_date', '>=', now());
                });
            })
            ->orderBy('id', 'asc')->paginate(6);

        return view('front.location', compact('location', 'properties'));
    }

    public function agents()
    {
        $agents = Agent::where('status', 1)->orderBy('id', 'asc')->paginate(20);
        return view('front.agents', compact('agents'));
    }
    public function agent($id)
    {
        $agent = Agent::where('id', $id)->first();
        if (!$agent) {
            return redirect()->route('home')->with('error', 'Agenttt not found');
        }
        // $properties = Property::where('agent_id',$agent->id)->where('status','Active')->orderBy('id','asc')->paginate(6);

        $properties = Property::where('agent_id', $agent->id)
            ->where('status', 'Active')
            ->whereHas('agent', function ($query) {
                $query->whereHas('orders', function ($q) {
                    $q->where('status', 'Completed')
                        ->where('expire_date', '>=', now());
                });
            })
            ->orderBy('id', 'asc')->take(3)->paginate(6);
        return view('front.agent', compact('agent', 'properties'));
    }

    public function property_search(Request $request)
    {
        $form_location = $request->location;
        $form_type = $request->type;
        $form_name = $request->name;
        $form_purpose = $request->purpose;
        $form_bedroom = $request->bedroom;
        $form_bathroom = $request->bathroom;
        $form_min_price = $request->min_price;
        $form_max_price = $request->max_price;
        $form_amenity = $request->amenity;

        $properties = Property::where('status', 'Active')
            ->whereHas('agent', function ($query) {
                $query->whereHas('orders', function ($q) {
                    $q->where('currently_active', 1)
                        ->where('status', 'Completed')
                        ->where('expire_date', '>=', now());
                });
            });
        if($request->name != null){
            $properties = $properties->where('name', 'like', '%' . $request->name . '%');
        }
        if($request->location != null){
            $properties = $properties->where('location_id', $request->location);
        }
        if($request->type != null){
            $properties = $properties->where('type_id', $request->type);
        }
        if($request->purpose != null){
            $properties = $properties->where('purpose', $request->purpose);
        }
        if($request->bedroom != null){
            $properties = $properties->where('bedroom', $request->bedroom);
        }
        if($request->bathroom != null){
            $properties = $properties->where('bathroom', $request->bathroom);
        }
        if($request->min_price != null){
            $properties = $properties->where('price', '>=', $request->min_price);
        }
        if($request->max_price != null){
            $properties = $properties->where('price', '<=', $request->max_price);
        }
        if($request->amenity != null){
            $properties = $properties->whereRaw('FIND_IN_SET(?, amenities)', [$request->amenity]);
        }
        $properties =  $properties->orderBy('id', 'asc')->paginate(10);


        $locations = Location::orderBy('name', 'asc')->get();
        $types = Type::orderBy('name', 'asc')->get();
        $amenities = Amenity::orderBy('name', 'asc')->get();

        return view('front.property_search', compact('locations', 'types', 'amenities', 'properties', 'form_location',
         'form_type', 'form_name', 'form_purpose', 'form_bedroom', 'form_bathroom', 'form_min_price', 'form_max_price', 'form_amenity'));
    }

    public function wishlist_add($id)
    {
        if(!Auth::guard('web')->check()) {
            return redirect()->route('front.login')->with('error', 'You must be logged in to add to wishlist');
        }
        // check if the property is already in wishlist
        $existingWishlist = Wishlist::where('user_id', Auth::guard('web')->user()->id)->where('property_id', $id)->first();
        if($existingWishlist) {
            return redirect()->back()->with('error', 'Property is already in your wishlist');
        }
        $obj = new Wishlist();
        $obj->user_id = Auth::guard('web')->user()->id;
        $obj->property_id = $id;
        $obj->save();
        return redirect()->back()->with('success', 'Property added to wishlist');
    }
}
