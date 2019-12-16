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
        $user = User::where('name', $request->name);
        $post->user_id = $user->id;
        $post->body = $request->body;
        $post->save();
    }

    public function show($id)
    {
        $current_user = User::find($id);
        $posts = Post::where('user_id', $current_user->id)->get();
        //return $posts;
        return response()->json([
            "id" => $posts->id,
            "user_id" => $posts->user_id,
            'user_name' => $current_user->name,
            "body" => $posts->body,
            "created_at" => $posts->created_at,
            "updated_at" => $posts->updated_at,
        ]);
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
