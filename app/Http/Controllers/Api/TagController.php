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
        $tag = Tag::with('post')->where('name', $tag->name)->get();
        return $tag;
    }

    public function store(Request $request, Post $post)
    {
        foreach($request->tags as $tag){
            $existence = Tag::where('name', $tag)->first();

            if (empty($existence)) {
                $tag2 = new Tag;
                $tag2->name = $tag;
                $tag2->save();

                $tag3 = Tag::where('name', $tag)->first();
                $tag3->post()->attach($post->id);
            } else {
                $tag1 = Tag::where('name', $tag)->first();
                $tag1->post()->attach($post->id);
            }
        };
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
    }
}
