<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AdminTestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('id', 'asc')->get();
        return view('admin.testimonial.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonial.create');
    }

    public function store(Request $request)
    {
        // validation
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'comment' => 'required',
        ]);

        // store data
        $testimonial = new Testimonial();
        $testimonial->name = $request->name;
        $testimonial->designation = $request->designation;
        $testimonial->comment = $request->comment;

        $final_name = 'testimonial_' .time() . '.' . $request->photo->extension();
        $request->photo->move(public_path('uploads'), $final_name);

        $testimonial->photo = $final_name;
        $testimonial->save();

        return redirect()->route('admin_testimonial_index')->with('success', 'Testimonial created successfully.');
    }
    public function edit($id)
    {
        $testimonial = Testimonial::where('id', $id)->first();
        return view('admin.testimonial.edit', compact('testimonial'));
    }
    public function update(Request $request, $id)
    {
        // validation
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'comment' => 'required',
        ]);

        // update data
        $testimonial = Testimonial::where('id', $id)->first();
        $testimonial->name = $request->name;
        $testimonial->designation = $request->designation;
        $testimonial->comment = $request->comment;
        

         // photo upload
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $final_name = 'testimonial_' . time() . '.' . $request->photo->extension();
            // delete old photo
            if ($testimonial->photo != '') {
                unlink(public_path('uploads/' . $testimonial->photo));
            }

           
            $request->photo->move(public_path('uploads'), $final_name);
            $testimonial->photo = $final_name;
        }

        $testimonial->save();

        return redirect()->route('admin_testimonial_index')->with('success', 'Testimonial updated successfully.');
    }
    public function delete($id)
    {
        $testimonial = Testimonial::where('id', $id)->first();

        // delete photo
        if ($testimonial->photo != '') {
            unlink(public_path('uploads/' . $testimonial->photo));
        }

        $testimonial->delete();
        return redirect()->route('admin_testimonial_index')->with('success', 'Testimonial deleted successfully.');
    }
}
