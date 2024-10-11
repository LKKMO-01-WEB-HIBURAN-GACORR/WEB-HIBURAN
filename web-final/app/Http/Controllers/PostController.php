<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function showList()
    {
        $posts = Post::with('user')->latest()->get();

        return view('posts.list', compact('posts'));
    }

    public function showDetail($id)
    {
        $post = Post::with('user')->findOrFail($id);

        return view('posts.detail', compact('post'));
    }

    public function showCreate()
    {
        return view('posts.create');
    }

    public function handleCreate(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = new Post();

        $post->title = $data['title'];
        $post->content = $data['content'];
        $post->user_id = Auth::user()->id;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('post_images'), $filename);
            $post->image = '\/post_images\/' . $filename;
        }

        $post->save();

        return redirect()->route('posts.list')->with('success', 'Post has been created.');
    }

    public function handleDelete($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            return redirect()->route('posts.list')->with('error', 'You have no permission.');
        }

        $post->delete();

        return redirect()->route('posts.list')->with('success', 'Post has been deleted.');
    }
}
