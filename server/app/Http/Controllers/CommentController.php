<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comments = Comment::where('post_id', $id)
        ->with('user')
        ->orderBy('id', 'desc')
        ->get();
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
        info($request->post_id);
        $comments= Comment::create([
            'user_id' =>  $request->user_id,
            'post_id' => $request->post_id,
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
        $comment->delete();
        return response()->json(['message' => 'Comment has been deleted successfully'], 200);
    }
}