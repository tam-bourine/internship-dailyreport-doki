<?php

namespace App\Http\Controllers\Api;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return $posts;
    }

    public function store(Request $request)
    {
        $post = new Post;
        $post->user_id = $request->user_id;
        $post->body = $request->body;
        $post->save();
    }

    public function show($id)
    {
        $post = Post::find($id);
        return $post;
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->body = $request->body;
        $post->save();
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect('api/posts');
    }
}
