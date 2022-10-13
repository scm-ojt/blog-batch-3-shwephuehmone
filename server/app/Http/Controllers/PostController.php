<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->search) {
            return Post::where('name', 'like', '%' . $request->search . '%')
            ->orderBy('id', 'DESC')->get();
        } else {
            return Post::orderBy('id', 'DESC')->get();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $posts = Post::all();
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
            //'user_id'=> 1,
            //'category_id'=>$request->category_id,
            'image'=>$imageName,
            'title'=> $request->title,
            'body'=> $request->body,
        ]);
        return response()->json($posts);
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
        return response()->json(
            $posts
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //$posts->category_id = $request->category_id;
        //$posts->image = $request->image;
        $posts->title = $request->title;
        $posts->body = $request->body;
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

    // /**
    //  * Search the specified resource from storage.
    //  *
    //  * @param  $param
    //  * @return Object
    //  */
    // public function searchPost($param)
    // {
    //     $categories = Category::all();
    //     $search_data = "%" . $param . "%";
    //     $posts = Post::where('title', 'like', $search_data)
    //         ->orWhere('body', 'like', $search_data)
    //         ->orWhereHas('category', function ($category) use ($search_data) {
    //             $category->where('name', 'like', $search_data);
    //         })->get();
    //     return $posts;
    // }
}