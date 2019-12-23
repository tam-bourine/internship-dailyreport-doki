<?php

namespace App\Http\Controllers\Api;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'body' => 'required|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $post = new Post;
        $user = User::where('name', $request->name)->first();
        $post->user_id = $user->id;
        $post->body = $request->body;
        $post->save();
        return "succeed";
    }

    public function show($id)
    {
        $posts = Post::with(['user', 'likes'])->where('user_id', $id)->get();
        return $posts;
    }

    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $post->body = request()->body;
        $post->save();
        return "succeed";
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return "succeed";
    }
}
