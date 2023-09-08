<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\support\facades\Hash;
use Illuminate\support\facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{

    public function register(Request $request)
    {
        return User::create([
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

    public function user(){
        return Auth::user();
    }

    public function logout(){
        $cookie= Cookie::forget('jwt');

        return response([
            'message'=>'success'
        ])->withCookie($cookie);
    }
}