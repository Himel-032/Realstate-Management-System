<?php

namespace App\Http\Controllers\Admin;
use App\Models\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'asc')->get();
        return view('admin.post.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.post.create');
    }

    public function store(Request $request)
    {
        // validation
        $request->validate([
            'title' => 'required',
            'slug' => 'required|regex:/^[A-Za-z0-9]+(?:-[A-Za-z0-9]+)*$/|unique:posts,slug',
            'short_description' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required',
        ]);
        $final_name = 'post_' . time() . '.' . $request->photo->extension();
        $request->photo->move(public_path('uploads'), $final_name);

        // store data
        $post = new Post();
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->short_description = $request->short_description;
        $post->description = $request->description;
        $post->photo = $final_name;
        $post->save();

        return redirect()->route('admin_post_index')->with('success', 'Post created successfully.');
    }
    public function edit($id)
    {
        $post = Post::where('id', $id)->first();
        return view('admin.post.edit', compact('post'));
    }
    public function update(Request $request, $id)
    {
        // validation
        $request->validate([
            'title' => 'required',
            'slug' => 'required|regex:/^[A-Za-z0-9]+(?:-[A-Za-z0-9]+)*$/|unique:posts,slug,' . $id,
            'short_description' => 'required',
            'description' => 'required',
        ]);

        // update data
        $post = Post::where('id', $id)->first();

        // photo upload
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $final_name = 'post_' . time() . '.' . $request->photo->extension();
            // delete old photo
            if ($post->photo != '') {
                unlink(public_path('uploads/' . $post->photo));
            }


            $request->photo->move(public_path('uploads'), $final_name);
            $post->photo = $final_name;
        }
        
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->short_description = $request->short_description;
        $post->description = $request->description;


        

        $post->save();

        return redirect()->route('admin_post_index')->with('success', 'Post updated successfully.');
    }
    public function delete($id)
    {
        $post = Post::where('id', $id)->first();

        // delete photo
        if ($post->photo != '') {
            unlink(public_path('uploads/' . $post->photo));
        }

        $post->delete();
        return redirect()->route('admin_post_index')->with('success', 'Post deleted successfully.');
    }
}
