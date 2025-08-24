<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\Admin;
use App\Mail\WebsiteMail;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard.index');
    }
    public function login()
    {
        return view('admin.auth.login');
    }
    
    public function login_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        
        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
        ];

        if(Auth::guard('admin')->attempt($data)) {
            return redirect()->route('admin_dashboard')->with('success', 'Login successful');
        } else {
            return redirect()->back()->with('error', 'Invalid credentials');
        }

    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin_login')->with('success', 'Logout successful');
    }

    public function forget_password()
    {
        return view('admin.auth.forget_password');
    }
    public function forget_password_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        
        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
           return redirect()->back()->with('error', 'Email not found'); 
        }     
        
        $token = hash('sha256', time());
        $admin->token= $token;
        $admin->save();

        $link = route('admin_reset_password', [$token, $request->email]);
        $subject = 'Reset Password';
        $message = 'Click the link to reset your password: <br>' ;
        $message .= '<a href="'.$link.'">'.$link.'</a>';
        \Mail::to($request->email)->send(new WebsiteMail($subject, $message));
        return redirect()->back()->with('success', 'Reset password link sent to your email');
        
    }

    public function reset_password($token, $email)
    {
        $admin = Admin::where('email', $email)->where('token', $token)->first();
        if (!$admin) {
            return redirect()->route('admin_login')->with('error', 'Invalid token or email');
        }
        return view('admin.auth.reset_password', compact('token', 'email'));
    }

    public function reset_password_submit(Request $request, $token, $email)
    {
        $request->validate([
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        $admin = Admin::where('email', $email)->where('token', $token)->first();
     

        $admin->password = Hash::make($request->password);
        $admin->token = ''; // Clear the token after password reset
        $admin->save();

        return redirect()->route('admin_login')->with('success', 'Password reset successful');
    }

    public function profile()
    {
        
        return view('admin.profile.index');
    }
    public function admin_profile_submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,'.Auth::guard('admin')->user()->id,
        ]);
        $admin = Admin::where('id', Auth::guard('admin')->user()->id)->first();

        if($request->photo){
            $request->validate([
                'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            
            $final_name = 'admin_'.time().'.'.$request->photo->extension();
            if($admin->photo != ''){
                unlink(public_path('uploads/'.$admin->photo));
            }
            $request->photo->move(public_path('uploads'), $final_name);
            $admin->photo = $final_name;
        }

        if ($request->password) {
            $request->validate([
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ]);
            $admin->password = Hash::make($request->password);
        } else {
            $admin->password = Auth::guard('admin')->user()->password; // Keep the old password if not changed
        }
        
        $admin->name = $request->name;
        $admin->email = $request->email;

        $admin->update();

        return redirect()->back()->with('success', 'Profile updated successfully');
     }
}
