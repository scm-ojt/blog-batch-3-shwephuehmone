<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $comments = Comment::all();
        return response()->json($comments);
    }
    
    /**
     * Summary of createComment
     * @param CommentRequest $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $comments = Comment::all();
        return response()->json($comments);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comments = Comment::findorfail($id);
        return response()->json($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comments= Comment::create([
            'user_id'=>$request->user_id,
            'post_id'=>$request->post_id,
            'body'=> $request->body
        ]);
        return response([
            "results" => "1",
            "message" =>"Created successfully",
            "data" => $comments
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        return response()->json(['message' => 'Comment has been deleted successfully'], 200);
    }
}