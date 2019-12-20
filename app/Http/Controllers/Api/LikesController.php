<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Like;
use App\Post;
use Illuminate\Http\Request;


class LikesController extends Controller
{
    public function store(Request $request, Post $post, $userId)
    {
        $like = new Like;
        $like->post_id = $post->id;
        $like->user_id = $userId;
        $like->save();
    }

    public function destroy(Post $post, $userId)
    {
        $like = Like::where('post_id', $post->id)
            ->where('user_id', $userId)
            ->first();
        $like->delete();
    }
}
