<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\Location;

class AdminLocationController extends Controller
{
    public function index()
    {
        $locations = Location::orderBy('id', 'asc')->get();
        return view('admin.location.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.location.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            //valid slug needed
            'slug' => ['required','unique:locations,slug','regex:/^[A-Za-z0-9]+(?:-[A-Za-z0-9]+)*$/'],
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',

        ]);

        ;


        $final_name = 'location_' . time() . '.' . $request->photo->extension();
       
        $request->photo->move(public_path('uploads'), $final_name);
        
        $location = new Location();

        $location->name = $request->name;
        $location->slug = strtolower($request->slug);
        $location->photo = $final_name;
       
        $location->save();

        return redirect()->route('admin_location_index')->with('success', 'Location created successfully.');
    }

    public function edit($id)
    {
        $location = Location::where('id', $id)->first();

        return view('admin.location.edit', compact('location'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            //slug will be unique except for the current record
            'slug' => ['required','regex:/^[A-Za-z0-9]+(?:-[A-Za-z0-9]+)*$/','unique:locations,slug,'.$id],
        ]);

        $location = Location::where('id', $id)->first();
        if($request->hasFile('photo')){
            $request->validate([
                'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            ]);
            $final_name = 'location_'.time(). '.'.$request->photo->extension();
            //unlink the old photo
            if($location->photo != ''){
                unlink(public_path('uploads/'.$location->photo));
            }
            $request->photo->move(public_path('uploads'),$final_name);
            $location->photo = $final_name;
        }

        $location->name = $request->name;
        $location->slug = strtolower($request->slug);
       
        $location->save();

        return redirect()->route('admin_location_index')->with('success', 'Location updated successfully.');
    }
    public function delete($id)
    {
        // If location has any property , then you cannot delete this location
        $property = Property::where('location_id', $id)->first();
        if ($property) {
            return redirect()->route('admin_location_index')->with('error', 'You cannot delete this location. It is associated with some properties.');
        }
        $location = Location::where('id', $id)->first();
        if ($location->photo != '') {
            unlink(public_path('uploads/' . $location->photo));
        }

        // If location has any property , then you cannot delete this location
        $property = Property::where('location_id', $id)->first();
        if($property){
            return redirect()->route('admin_location_index')->with('error', 'You cannot delete this location. It is associated with some properties.');
        }

        $location->delete();

        return redirect()->route('admin_location_index')->with('success', 'Location deleted successfully.');

    }
}
