<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Tag;

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
        $tag = new Tag;
        $tag->name = $request->name;
        $tag->save();

        $tag2 = Tag::where('name', $request->name)->first();
        $tag2->post()->attach($tag->id);
        $tag2->post()->attach($tag->id);
        $tag2->save();
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
    }
}
