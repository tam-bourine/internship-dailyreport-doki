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
        $posts = Post::with(['user', 'likes', 'tags'])->get();
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


        // slack api
        $headers = [
            'Authorization: Bearer '.config('slack.my-env'),
            'Content-Type: application/json;charset=utf-8'
        ];

        $url = "https://slack.com/api/chat.postMessage";
        $post_fields = [
            "channel" => "#testapi",
            "text" => $user->name . "さんが日報を投稿しました。確認しにいきましょう！\nhttps://dreport-201912.herokuapp.com/users/".$user->id,
            "as_user" => false
        ];
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($post_fields)
        ];
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);

        return $post->id;
    }

    public function show($id)
    {
        $posts = Post::with(['user', 'likes', 'tags'])->where('user_id', $id)->get();
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
