<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        // Ambil semua post dari model post
        $posts = Post::latest()->get();

        // mengembalikan view dengan data
        return view('posts', compact('posts'));
    }

    public function store(Request $request)
    {
        // rules untuk validasi
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'content'   => 'required',
        ]);

        // pengecekan jika data yang dimasukkan salah
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // insert data ke post
        $post = Post::create([
            'title'     => $request->title,
            'content'   => $request->content
        ]);

        // mengembalikan response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $post
        ]);
    }
}
