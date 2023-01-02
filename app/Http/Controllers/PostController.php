<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        //get all posts from Models
        $posts = Post::latest()->get();

        //return view with data
        return view('posts', compact('posts'));
    }
}
