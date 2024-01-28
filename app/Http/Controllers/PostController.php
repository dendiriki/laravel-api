<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
