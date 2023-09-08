<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//main user
Route::post('register',[UserController::class, 'register']); // main user registration
Route::post('login',[UserController::class, 'login']); // main user login

Route::middleware('auth:sanctum')->group(function(){ // authentication middleware for main user
    Route::get('user',[UserController::class, 'user']); // authenticated
    Route::post('logout',[UserController::class, 'logout']); //logged in main user logout
    
    Route::get('userpost/{id}',[PostController::class, 'user_post_only']); // logged in user can only see their post
    Route::get('delpost/{id}',[PostController::class, 'delete_post']); // logged in user can only delete their post
    Route::post('user/post',[PostController::class, 'create_post']); // logged in main user can create post 

    Route::post('post/comment',[CommentController::class, 'store_comment']); // main user can only comment
    Route::get('post/comment/delete/{id}',[CommentController::class, 'delete_comment']); // main user can only delete comment
    Route::put('post/comment/update/{id}',[CommentController::class, 'update_comment']);
});



// Admin Routes
Route::post('admin/register',[AdminController::class, 'register']); // admin registration
Route::post('admin/login',[AdminController::class, 'login']); // admin login

Route::middleware('auth:sanctum')->group(function(){ // Admin authentication middleware for main user
    Route::get('admin/user',[AdminController::class, 'adminuser']); // Admin authenticated
    Route::post('admin/logout',[AdminController::class, 'logout']); //logged in admin can only logout
    Route::get('admin/delpost/{id}',[AdminController::class, 'delete_post']); // logged in user can only delete their post
    Route::get('admin/deluser/{id}',[AdminController::class, 'delete_user']); // logged in admin can only delete user
    Route::get('admin/delcomment/{id}',[AdminController::class, 'delete_comments']); // logged in admin can only delete comments
    Route::put('admin/updateuser/{id}', [AdminController::class, 'update_user']); // admin can update users
});



//Post Routes (it's outside the middleware because anyone can see the post)
Route::get('post',[PostController::class, 'show_all_post']); // anyone can see all posts

//Comment route for guest users only
Route::post('post/comment/guest',[CommentController::class, 'guest_store_comment']); // main user can only comment