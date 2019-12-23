<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use App\Tag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::with('post')->get();
        return $tags;
    }

    public function show(Tag $tag)
    {
        $tag = Post::with('post')->where('name', $tag->name)->get();
        return $tag;
    }

    public function store(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:20',
                Rule::unique('tags'),
            ]
        ]);

        if ($validator->fails()) {
            $tag1 = Tag::where('name', $request->name)->first();
            $tag1->post()->attach($post->id);
            return "already exists";
        }

        $tag2 = new Tag;
        $tag2->name = $request->name;
        $tag2->save();

        $tag3 = Tag::where('name', $request->name)->first();
        $tag3->post()->attach($post->id);
        return "success";
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
    }
}
