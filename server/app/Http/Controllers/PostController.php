<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Post::with('user')->with('categories');
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        $posts = $query->orderBy('id', 'DESC')->get();
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/images', $imageName);
        $posts= Post::create([
            'user_id' => $request->user_id,
            'image'=> $imageName,
            'title'=> $request->title,
            'body'=> $request->body,
        ]);
        $posts->categories()->sync($request->categories);
        return response([
            'result' => 1,
            'message' => 'Created successfully',
            'data' => $posts
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts = Post::findorfail($id);
        return response()->json($posts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $posts = Post::find($id);
        $posts->image = $request->image;
        $posts->title = $request->title;
        $posts->body = $request->body;
        $posts->categories()->sync($request->categories);
        $posts->save();
        return response([
            'posts'=>$posts,
            "message" =>"Updated successfully"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return response()->json(['message' => 'Post has been deleted successfully'], 200);
    }
}