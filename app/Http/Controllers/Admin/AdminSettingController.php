<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class AdminSettingController extends Controller
{
    public function index()
    {
        $setting = Setting::where('id', 1)->first();
        return view('admin.setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'footer_address' => 'required|string|max:255',
            'footer_email' => 'required|string|email|max:255',
            'footer_phone' => 'required|string|max:255',
            'footer_facebook' => 'required|string|max:255',
            'footer_twitter' => 'required|string|max:255',
            'footer_instagram' => 'required|string|max:255',
            'footer_linkedin' => 'required|string|max:255',
            'footer_copyright' => 'required|string|max:255',
        ]);
       
        $setting = Setting::where('id', 1)->first();

        if ($request->hasFile('logo')) {
            $request->validate([
                'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $final_name = 'logo_' . time() . '.' . $request->logo->extension();
            //unlink the old photo
            if ($setting->logo != '') {
                unlink(public_path('uploads/' . $setting->logo));
            }
            $request->logo->move(public_path('uploads'), $final_name);
            $setting->logo = $final_name;
        }
        if ($request->hasFile('favicon')) {
            $request->validate([
                'favicon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $final_name = 'favicon_' . time() . '.' . $request->favicon->extension();
            //unlink the old photo
            if ($setting->favicon != '') {
                unlink(public_path('uploads/' . $setting->favicon));
            }
            $request->favicon->move(public_path('uploads'), $final_name);
            $setting->favicon = $final_name;
        }
        if ($request->hasFile('banner')) {
            $request->validate([
                'banner' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $final_name = 'banner_' . time() . '.' . $request->banner->extension();
            //unlink the old photo
            if ($setting->banner != '') {
                unlink(public_path('uploads/' . $setting->banner));
            }
            $request->banner->move(public_path('uploads'), $final_name);
            $setting->banner = $final_name;
        }
        $setting->footer_address = $request->footer_address;
        $setting->footer_email = $request->footer_email;
        $setting->footer_phone = $request->footer_phone;
        $setting->footer_facebook = $request->footer_facebook;
        $setting->footer_twitter = $request->footer_twitter;
        $setting->footer_instagram = $request->footer_instagram;
        $setting->footer_linkedin = $request->footer_linkedin;
        $setting->footer_copyright = $request->footer_copyright;
        $setting->save();
        return redirect()->route('admin_setting_index')->with('success', 'Settings updated successfully.');
    }
}
