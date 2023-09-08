<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store_comment(Request $request)
    {
        if (Auth::check()) {
            return Comment::create([
                'message' => $request->input('message'),
                'post_id' => $request->post_id,
                'commentedBy' => $request->commentedBy
            ]);
        }
    }

    public function guest_store_comment(Request $request)
    {
        return Comment::create([
                'message' => $request->input('message'),
                'post_id' => $request->post_id
        ]);
    }

    public function delete_comment($id)
    {
        if(!Auth::check())
        {
            return response([
                'message' => 'Authentication required'
            ], 401); 
        }
        else
        {
            $comment=Comment::find($id);
            $post=Post::find($comment->id);
            if(($post->user_id == auth()->user()->id))
            {
                $comment->delete();
                return response()->json([
                    'message'=>'Successfully deleted'
                ]);
            }
            else
            {
                return response()->json(['message' => 'Authentication required'], 401);
            }
        }

    }
    public function update_comment(Request $request,$id)
    {
        if(!Auth::check())
        {
            return response([
                'message' => 'Authentication required'
            ], 401); 
        }
        else
        {
            $comment=Comment::find($id);
            $post=Post::find($comment->id);
            if(($post->user_id == auth()->user()->id))
            {
                $comment->message=$request->message;
                $comment->save();
                
                return response()->json([
                    'message'=>'Successfully Updated'
                ]);
            }
            else
            {
                return response()->json(['message' => 'Authentication required'], 401);
            }
        }

    }
}
