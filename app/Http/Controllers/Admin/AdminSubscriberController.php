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

    public function export()
    {
        $fileName = 'subscribers.csv';
        $subscribers = Subscriber::where('status', 1)->orderBy('id', 'asc')->get();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('ID', 'Email', 'Created At');

        $callback = function () use ($subscribers, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($subscribers as $subscriber) {
                $row['ID']  = $subscriber->id;
                $row['Email']    = $subscriber->email;
                $row['Created At']    = $subscriber->created_at->format('d M, Y');

                fputcsv($file, array($row['ID'], $row['Email'], $row['Created At']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
