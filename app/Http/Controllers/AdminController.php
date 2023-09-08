<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\support\facades\Hash;
use Illuminate\support\facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;

class AdminController extends Controller
{
    public function register(Request $request)
    {
        return Admin::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($request->input('password'))
        ]);
    }

    public function login(Request $request){
        if(!Auth::attempt($request->only('email', 'password'))){
            return response([
                'message'=>'Invalid Credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user= Auth::user();
        $token=$user->createToken('token')->plainTextToken;
        $cookie=cookie('jwt',$token,60*24);

        return response([
            'message'=>'successful'
        ])->withCookie($cookie);

    }

    public function adminuser(){
        return Auth::user();
    }

    public function logout(){
        $cookie= Cookie::forget('jwt');

        return response([
            'message'=>'success'
        ])->withCookie($cookie);
    }

    public function delete_post($id){
        if(Auth::check()){
            $post=Post::find($id);
            $post->delete();
            return response()->json([
                'message'=>'successfully deleted'
            ]);
        }
        else{
            return response()->json(['message' => 'Authentication required'], 401);
        }
    }

    public function delete_user($id){
        if(Auth::check()){
            $user=User::find($id);
            $user->delete();
            return response()->json([
                'message'=>'successfully deleted'
            ]);
        }
        else{
            return response()->json(['message' => 'Authentication required'], 401);
        }
    }

    public function delete_comment($id)
    {
        if(Auth::check()){
            $comment=Comment::find($id);
            $comment->delete();
            return response()->json([
                'message'=>'successfully deleted'
            ]);
        }
        else{
            return response()->json(['message' => 'Authentication required'], 401);
        }
    }

    public function update_user(Request $request, $id)
    {
        $user= User::find($id);
        
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=$request->password;
        $user->save();

        return response()->json(['message' => 'Updated']);
    }
}