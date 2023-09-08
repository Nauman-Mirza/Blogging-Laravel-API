<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\support\facades\Auth;

class PostController extends Controller
{
    public function create_post(Request $request){
        if(auth()->user()->id == $request->user_id)
        {
            return Post::create([
                'title'=>$request->input('title'),
                'description'=>$request->input('description'),
                'user_id'=>$request->user_id,
                'imgUrl'=>$request->input('imgUrl')
            ]);
        }
        else
        {
            return response([
                'message' => 'Authentication required'
            ], 401); 
        }
    }
    public function show_all_post(){
        $posts = Post::all();

        if($posts->isEmpty()){
            return response()->json([
                'message'=>'No post Found'
            ]);
        }

        return response()->json($posts);
    }

    public function user_post_only($id){
        if(!Auth::check())
        {
            return response([
                'message' => 'Authentication required'
            ], 401); 
        }
        else
        {
            $user=Auth::user();
            if($user->id == $id)
            {
                $post=Post::where('user_id',$id)->get();
                if($post->isEmpty())
                {
                    return response()->json([
                        'message'=>'No post Found'
                    ]);
                }
                return response()->json($post);
            }
            else
            {
                return response([
                    'message' => 'Authentication required'
                ], 401); 
            }
        }
    }

    public function delete_post($id)
    {
        if(!Auth::check())
        {
            return response([
                'message' => 'Authentication required'
            ], 401);
        }
        else
        {
            $post=Post::find($id);
            if ($post->user_id == auth()->user()->id) 
            {
                $post->delete();
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
}
