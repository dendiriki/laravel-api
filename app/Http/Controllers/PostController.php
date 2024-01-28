<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post; // Sesuaikan dengan namespace model Post
use App\Http\Resources\PostResource; // Sesuaikan dengan namespace
use App\Http\Resources\PostDetailResource; // Sesuaikan dengan namespace

class PostController extends Controller
{
    public function index(){
        $posts = Post::all();
        return PostResource::collection($posts);
    }

    public function show ($id){
        $post = Post::with('writer:id,username')->findOrFail($id);
        return New PostDetailResource($post);
    }

    public function store(Request $request){
        $validate = $request->validate([
            'title' => 'required',
            'news_content' => 'required',
        ]);

            $request['author'] = Auth::user()->id;
            $post = Post::create($request->all());
            return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    public function update(Request $request ,$id){
        $validate = $request->validate([
            'title' => 'required',
            'news_content' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());
        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    public function destroy($id){
        $post = Post::findOrFail($id);
        $post->delete();
        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }
}
