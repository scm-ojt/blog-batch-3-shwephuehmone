<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Exports\PostExport;
use App\Imports\PostImport;
use App\Models\CategoryPost;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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
        $imageName = time().rand(1, 99).'.' . $request->image->extension();
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
    public function show(Post $posts)
    {
        $categories=CategoryPost::where('post_id', $id)->pluck('category_id');
        return response()->json([
            'posts'=>$posts,
            'categories'=>$categories
        ]);
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
        if (isset($_FILES['file'])) {
            $file = $request->file('file');
            $image = $file->getClientOriginalName();
            $file->move('public/images', $image);
            if (file_exists(public_path($image =  $file->getClientOriginalName()))) {
                unlink(public_path($image));
            };
            //Update Image
            $posts->file = $image;
        }
        $posts->user_id = $request->user_id;
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
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post has been deleted successfully'], 200);
    }

    public function export(Request $request)
    {
        return Excel::download(new PostExport($request->keyword), 'posts.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new PostImport(), $request->file('file'));
        return response(200);
    }
}