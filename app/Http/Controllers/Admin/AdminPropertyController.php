<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

   
}
