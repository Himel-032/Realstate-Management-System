<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use App\Models\Agent;
use App\Models\Wishlist;
use App\Models\Property;
use App\Models\Message;
use App\Models\MessageReply;
use App\Mail\WebsiteMail;

class UserController extends Controller
{
    public function dashboard()
    {
        $total_messages = Message::where('user_id', Auth::guard('web')->user()->id)->count();
        $total_wishlists = Wishlist::where('user_id', Auth::guard('web')->user()->id)->count();
        return view('user.dashboard.index', compact('total_messages', 'total_wishlists'));
    }
    public function registration()
    {
        return view('user.auth.registration');
    }

    public function registration_submit(Request $request)
    {
        // Handle user registration logic here
        // Validate input, create user, etc.
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|max:255|email|unique:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);
        $token = hash('sha256', time());

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->token= $token;
        $user->status= 0;
        $user->save();
        
        $link = url('registration-verify/'.$token.'/'.$request->email);
        $subject = "Registration Verification";
        $message = 'Click the link to verify your email: <br><a href="'.$link. '">'.$link.'</a>';

        \Mail::to($request->email)->send(new WebsiteMail($subject, $message));

        return redirect()->back()->with('success', 'Registration successful! Please check your email to verify your account.');
    }

    public function registration_verify($token, $email)
    {
        $user = User::where('email', $email)->where('token', $token)->first();
        if(!$user) {
            return redirect()->route('login')->with('error', 'Invalid token or email.');
        }
        $user->token= '';
        $user->status= 1;
        $user->update();
        return redirect()->route('login')->with('success', 'Email verified successfully. You can now login.');
    }

    public function login()
    {
        if(Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }
        // check cookies
        $email = Cookie::get('remember_email');
        $password = Cookie::get('remember_password');

        if ($email && $password) {
            try {
                $credentials = [
                    'email' => $email,
                    'password' => decrypt($password),
                    'status' => 1,
                ];

                if (Auth::attempt($credentials)) {
                    return redirect()->route('dashboard')->with('success', 'Auto-login successful');
                }

            } catch (\Exception $e) {
                // If decrypt fails or invalid cookie, forget them
                Cookie::queue(Cookie::forget('remember_email'));
                Cookie::queue(Cookie::forget('remember_password'));
            }
        }

      //  return view('user.auth.login');

        return view('user.auth.login');
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
            'status' => 1,
        ];

        if(Auth::guard('web')->attempt($data)) {
            if ($request->has('remember')) {
                $minutes = 60 * 24 * 30; // 30 days
                Cookie::queue('remember_email', $request->email, $minutes);
                Cookie::queue('remember_password', encrypt($request->password), $minutes);
            }
            return redirect()->route('dashboard')->with('success', 'Login successful');
        } else {
            return redirect()->back()->with('error', 'Invalid credentials');
        }

    }

    public function logout()
    {
        Auth::guard('web')->logout();
        Cookie::queue(Cookie::forget('remember_email'));
        Cookie::queue(Cookie::forget('remember_password'));
        return redirect()->route('login')->with('success', 'Logout successful');
    }

    public function forget_password()
    {
        return view('user.auth.forget_password');
    }
    public function forget_password_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        
        $user = User::where('email', $request->email)->first();

        if (!$user) {
           return redirect()->back()->with('error', 'Email not found'); 
        }     
        
        $token = hash('sha256', time());
        $user->token= $token;
        $user->update();

        $link = route('reset_password', [$token, $request->email]);
        $subject = 'Reset Password';
        $message = 'Click the link to reset your password: <br>' ;
        $message .= '<a href="'.$link.'">'.$link.'</a>';
        \Mail::to($request->email)->send(new WebsiteMail($subject, $message));
        return redirect()->back()->with('success', 'Reset password link sent to your email');
        
    }

    public function reset_password($token, $email)
    {
        $user = User::where('email', $email)->where('token', $token)->first();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Invalid token or email');
        }
        return view('user.auth.reset_password', compact('token', 'email'));
    }

    public function reset_password_submit(Request $request, $token, $email)
    {
        $request->validate([
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::where('email', $email)->where('token', $token)->first();
     

        $user->password = Hash::make($request->password);
        $user->token = ''; // Clear the token after password reset
        $user->update();

        return redirect()->route('login')->with('success', 'Password reset successful');
    }

    public function profile()
    {
        
        return view('user.profile.index');
    }
    public function profile_submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.Auth::guard('web')->user()->id,
        ]);
        $user = User::where('id', Auth::guard('web')->user()->id)->first();

        if($request->photo){
            $request->validate([
                'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            
            $final_name = 'user_'.time().'.'.$request->photo->extension();
            if($user->photo != ''){
                unlink(public_path('uploads/'.$user->photo));
            }
            $request->photo->move(public_path('uploads'), $final_name);
            $user->photo = $final_name;
        }

        if ($request->password) {
            $request->validate([
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ]);
            $user->password = Hash::make($request->password);
        } 
        
        $user->name = $request->name;
        $user->email = $request->email;
        
        $user->update();

        return redirect()->back()->with('success', 'Profile updated successfully');
     }
    public function wishlist()
    {
        $wishlists = Wishlist::where('user_id', Auth::guard('web')->user()->id)->get();
        return view('user.wishlist.index', compact('wishlists'));
    }
    public function wishlist_delete($id)
    {
        $wishlist = Wishlist::where('id', $id)->first();
        if($wishlist) {
            $wishlist->delete();
            return redirect()->back()->with('success', 'Wishlist item deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Wishlist item not found');
        }
    }
    public function message()
    {
        $messages = Message::where('user_id', Auth::guard('web')->user()->id)->get();
        return view('user.message.index', compact('messages'));
    }
    public function message_create()
    {
        $agents = Agent::where('status', 1)->get();
        return view('user.message.create', compact('agents'));
    }
    public function message_store(Request $request)
    {
        $request->validate([
            'agent_id' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $message = new Message();
        $message->user_id = Auth::guard('web')->user()->id;
        $message->agent_id = $request->agent_id;
        $message->subject = $request->subject;
        $message->message = $request->message;
        $message->save();
        // send email to agent 
        $agent = Agent::where('id', $request->agent_id)->first();
        if($agent) {
            $subject = "New Message from Customer";
            $msg = "You have received a new message from ".Auth::guard('web')->user()->name."<br>";
            $msg .= "Subject: ".$request->subject."<br>";
            $msg .= "Message: ".$request->message."<br>";
            \Mail::to($agent->email)->send(new WebsiteMail($subject, $msg));
        }

        return redirect()->route('message')->with('success', 'Message sent successfully');
    }
    public function message_reply($id)
    {
        $message = Message::where('id', $id)->first();
        $replies = MessageReply::where('message_id', $id)->get();
        return view('user.message.reply', compact('message', 'replies'));
    }
    public function message_reply_submit(Request $request, $m_id, $a_id)
    {
        $request->validate([
            'reply' => 'required',
        ]);

        $reply = new MessageReply();
        $reply->message_id = $m_id;
        $reply->user_id = Auth::guard('web')->user()->id;
        $reply->agent_id = $a_id;
        $reply->sender = 'Customer';
        $reply->reply = $request->reply;
        $reply->save();

        return redirect()->back()->with('success', 'Reply sent successfully');
    }
    public function message_delete($id)
    {
        // delete message
        Message::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Message deleted successfully');
    }
}