<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class AdminFaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('created_at', 'asc')->get();
        return view('admin.faq.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        $faq = new Faq();
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();

        return redirect()->route('admin_faq_index')->with('success', 'FAQ created successfully.');
    }

    public function edit($id)
    {
        $faq = Faq::where('id', $id)->first();
        return view('admin.faq.edit', compact('faq'));
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::where('id', $id)->first();
        if (!$faq) {
            return redirect()->route('admin_faq_index')->with('error', 'FAQ not found.');
        }
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();

        return redirect()->route('admin_faq_index')->with('success', 'FAQ updated successfully.');
    }

    public function delete($id)
    {
        $faq = Faq::where('id', $id)->first();
        if (!$faq) {
            return redirect()->route('admin_faq_index')->with('error', 'FAQ not found.');
        }
        $faq->delete();

        return redirect()->route('admin_faq_index')->with('success', 'FAQ deleted successfully.');
    }
}
