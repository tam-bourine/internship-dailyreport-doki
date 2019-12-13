<?php

namespace App\Http\Controllers\Api;

use App\Post;
use App\User;
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
        $current_user = User::find($id);
        $posts = Post::where('user_id', $current_user->id)->get();
        return $posts;
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
