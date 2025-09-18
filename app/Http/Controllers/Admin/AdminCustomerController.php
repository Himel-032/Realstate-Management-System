<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\Websitemail;

class AdminCustomerController extends Controller
{
    public function index()
    {
        $customers = User::orderBy('id', 'asc')->get();
        return view('admin.customer.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customer.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'unique:users,email','email'],
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
             'password' => ['required'],
             'confirm_password' => ['required','same:password'],

        ]);

        ;


        $final_name = 'user_' . time() . '.' . $request->photo->extension();

        $request->photo->move(public_path('uploads'), $final_name);

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->photo = $final_name;
        $user->password = bcrypt($request->password);

        $user->save();

        // send email to customer
        $link = route('login');
        $subject = "Your account is created.";
        $message = 'Account information: <br>';
        $message .= 'Name: '.$request->name . '<br>';
        $message .= 'Email: '.$request->email . '<br>';
        $message .= 'Status: '.$request->status . '<br>';
        $message .= 'Password: '.$request->password . '<br><br>';
        $message .= 'Please login to your account: <br><a href="' . $link . '">' . $link . '</a>';

        \Mail::to($request->email)->send(new WebsiteMail($subject, $message));

        return redirect()->route('admin_customer_index')->with('success', 'Customer created successfully.');
    }

    public function edit($id)
    {
        $customer = User::where('id', $id)->first();

        return view('admin.customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email'=> ['required','email','unique:users,email,'.$id],
        ]);

        $user = User::where('id', $id)->first();
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $final_name = 'user_' . time() . '.' . $request->photo->extension();
            //unlink the old photo
            if ($user->photo != '') {
                unlink(public_path('uploads/' . $user->photo));
            }
            $request->photo->move(public_path('uploads'), $final_name);
            $user->photo = $final_name;
        }
        if($request->password != ''){
            $request->validate([
                'password'=> 'required',
                'confirm_password' => ['required','same:password'],
                ]);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;


        $user->save();

        return redirect()->route('admin_customer_index')->with('success', 'Customer updated successfully.');
    }
    public function delete($id)
    {
        $user = User::where('id', $id)->first();
        if ($user->photo != '') {
            unlink(public_path('uploads/' . $user->photo));
        }
        $user->delete();

        return redirect()->route('admin_customer_index')->with('success', 'Customer deleted successfully.');

    }
}
