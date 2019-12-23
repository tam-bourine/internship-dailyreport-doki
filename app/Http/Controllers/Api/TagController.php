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

    // fixme: validationがうまくいっていません
    public function store(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'tags.*' => [
                'required',
                'max:20',
                Rule::unique('tags'),
            ]
        ]);

        foreach($request->tags as $tag){
            if ($validator->fails()) {
                $tag1 = Tag::where('name', $tag)->first();
                $tag1->post()->attach($post->id);
                return "already exists";
            }

            $tag2 = new Tag;
            $tag2->name = $tag;
            $tag2->save();

            $tag3 = Tag::where('name', $tag)->first();
            $tag3->post()->attach($post->id);
            return "success";
        };
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
    }
}
