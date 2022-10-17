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
    public function index($id)
    {
        $comments = Comment::where('post_id', $id)
                            ->with('user')
                            ->orderBy('id', 'DESC')
                            ->get();
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
            // 'user_id'=>Auth::user()->id,
            'user_id'=>2,
            'post_id'=>36,
            'body'=> $request->body
        ]);

        
        return response([
            "results" => "1",
            "message" =>"Comment is Created successfully",
            "data" => $comments
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //$comment = Comment::find($id);
        $comment->delete();
        return response()->json(['message' => 'Comment has been deleted successfully'], 200);
    }
}