<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $posts = Post::all();

        return response()->json([
            'success' => true,
            'message' => 'List Semua Post',
            'data' => $posts,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Semua Kolom Wajib diisi!',
                'data' => $validator->errors()
            ], 401);
        } else {
            $post = Post::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
            ]);

            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Disimpan!',
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'mesaage' => 'Post Gagal Disimpan',
                ], 400);
            }
        }
    }

    public function edit($id)
    {
        $post = Post::find($id);
        if ($post) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Post!',
                'data'      => $post
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Tidak Ditemukan!',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Semua Kolom Wajib diisi',
                'data' => $validator->errors()
            ], 401);
        } else {
            $post = Post::whereId($id)->update([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
            ]);

            if ($post) {
                return response()->json([
                    'success' => true,
                    'mesaage' => 'Post Berhasil Diupdate',
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Gagal Diupdate',
                ], 400);
            }
        }
    }

    public function destroy($id)
    {
        $post = Post::whereId($id)->first();

        $post->delete();

        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Post Berhasil Dihapus!',
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Gagal Didelete',
            ], 400);
        }
    }
}
