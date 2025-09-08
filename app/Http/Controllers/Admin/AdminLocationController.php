<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

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
        $package = Location::where('id', $id)->first();

        return view('admin.package.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'allowed_days' => 'required|numeric',
            'allowed_properties' => 'required|numeric',
            'allowed_featured_properties' => 'required|numeric',
            'allowed_photos' => 'required|numeric',
            'allowed_videos' => 'required|numeric',
        ]);

        $package = Location::where('id', $id)->first();


        $package->name = $request->name;
        $package->price = $request->price;
        $package->allowed_days = $request->allowed_days;
        $package->allowed_properties = $request->allowed_properties;
        $package->allowed_featured_properties = $request->allowed_featured_properties;
        $package->allowed_photos = $request->allowed_photos;
        $package->allowed_videos = $request->allowed_videos;
        $package->save();

        return redirect()->route('admin_package_index')->with('success', 'Package updated successfully.');
    }
    public function delete($id)
    {
        $package = Location::where('id', $id)->first();
        $package->delete();
        return redirect()->route('admin_package_index')->with('success', 'Package deleted successfully.');

    }
}
