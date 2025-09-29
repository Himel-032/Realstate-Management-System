<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenity;
use App\Models\Property;

class AdminAmenityController extends Controller
{
    public function index()
    {
        $amenities = Amenity::orderBy('id', 'asc')->get();
        return view('admin.amenity.index', compact('amenities'));
    }

    public function create()
    {
        return view('admin.amenity.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:amenities,name'],
        ]);

        $amenity = new Amenity();

        $amenity->name = $request->name;

        $amenity->save();

        return redirect()->route('admin_amenity_index')->with('success', 'Amenity created successfully.');
    }

    public function edit($id)
    {
        $amenity = Amenity::where('id', $id)->first();

        return view('admin.amenity.edit', compact('amenity'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'unique:amenities,name,' . $id],
        ]);

        $amenity = Amenity::where('id', $id)->first();



        $amenity->name = $request->name;
        $amenity->save();

        return redirect()->route('admin_amenity_index')->with('success', 'Amenity updated successfully.');
    }
    public function delete($id)
    {
        // in properties table amenities are stored like 1,2,3 . each of these is an amenity id
        // So if any property has this amenity id in its amenities field , then you cannot delete this amenity
        $properties = Property::get();
        foreach ($properties as $item) {
            $temp_arr = explode(',', $item->amenities);
            if (in_array($id, $temp_arr)) {
                return redirect()->route('admin_amenity_index')->with('error', 'You cannot delete this amenity. It is associated with some properties.');
            }
        }
        $amenity = Amenity::where('id', $id)->first();
        $amenity->delete();

        return redirect()->route('admin_amenity_index')->with('success', 'Amenity deleted successfully.');

    }
}
