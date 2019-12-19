<?php

namespace App\Http\Controllers\Api;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware('can:update,post')->only("update");
        $this->middleware('can:delete,post')->only('destroy');
    }

    public function index()
    {
        $posts = Post::with('user')->get();
        return $posts;
    }

    public function store(Request $request)
    {
        $post = new Post;
        $user = User::where('name', $request->name)->first();
        $post->user_id = $user->id;
        $post->body = $request->body;
        $post->save();
        return "succeed";
    }

    public function show($id)
    {
        $posts = Post::with('user')->where('user_id', $id)->get();
        return $posts;
    }

    public function update(Post $post)
    {
        $post->body = request()->body;
        $post->save();
    }

    public function destroy(Post $post)
    {
        $post->delete();
    }
}
