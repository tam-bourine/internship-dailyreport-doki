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
        $posts = Post::with('user')->get();
        return $posts;
    }

    public function store(Request $request)
    {
        $post = new Post;
        $user = User::where('name', $request->name);
        $post->user_id = $user->id;
        $post->body = $request->body;
        $post->save();
    }

    public function show($id)
    {
        $posts = Post::with('user')->where('user_id', $id)->get();
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
    }
}
