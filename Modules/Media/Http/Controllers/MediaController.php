<?php

namespace Modules\Media\Http\Controllers;

use Modules\Media\Entities\Post;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(3);
        return view('media::post.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('media::post.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'content' => 'required|min:50',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
          ]);
      
        $imageName = time() . '.' . $request->file->extension();
        $request->file->storeAs('public/images', $imageName);
      
        $postData = ['title' => $request->title, 'category' => $request->category, 'content' => $request->content, 'image' => $imageName];
      
        Post::create($postData);
        return redirect('/post')->with(['message' => 'Post added successfully!', 'status' => 'success']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Post $post)
    {
        return view('media::post.show', ['post' => $post]);
        // return view('media::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Post $post)
    {
        return view('media::post.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Post $post)
    {
        $imageName = '';
        if ($request->hasFile('file')) {
            $imageName = time() . '.' . $request->file->extension();
            $request->file->storeAs('public/images', $imageName);
            if ($post->image) {
                Storage::delete('public/images/' . $post->image);
            }
        } else {
            $imageName = $post->image;
        }
        $postData = ['title' => $request->title, 'category' => $request->category, 'content' => $request->content, 'image' => $imageName];
        $post->update($postData);
        return redirect('/post')->with(['message' => 'Post updated successfully!', 'status' => 'success']);
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Post $post)
    {
        Storage::delete('public/images/' . $post->image);
        $post->delete();
        return redirect('/post')->with(['message' => 'Post deleted successfully!', 'status' => 'info']);
    }
}
