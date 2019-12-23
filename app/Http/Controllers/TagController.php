<?php

namespace App\Http\Controllers;

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
            return "already exists";
        }

        $tag = new Tag;
        $tag->name = $request->name;
        $tag->save();

        $tag2 = Tag::where('name', $request->name)->first();
        $tag2->post()->attach($tag->id);
        $tag2->post()->attach($tag->id);
        $tag2->save();

        return "success";
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
    }
}
