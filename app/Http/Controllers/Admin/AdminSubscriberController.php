<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class AdminSubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::where('status', 1)->orderBy('id', 'asc')->get();
        return view('admin.subscriber.index', compact('subscribers'));
    }
    public function delete($id)
    {
        $subscriber = Subscriber::where('id', $id)->first();
        if ($subscriber) {
            $subscriber->delete();
            return redirect()->route('admin_subscriber_index')->with('success', 'Subscriber deleted successfully.');
        } else {
            return redirect()->route('admin_subscriber_index')->with('error', 'Subscriber not found.');
        }
    }

    
}
