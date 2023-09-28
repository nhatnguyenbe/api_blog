<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, "login"])->name("login");
Route::post('/register', [AuthController::class, "register"])->name("register");
Route::post('/logout', [AuthController::class, "logout"])->name("logout")->middleware('auth:api');
Route::get('/users', [AuthController::class, "userDetail"])->middleware("auth:api");
Route::post("/refresh-token", [AuthController::class, 'refreshToken'])->middleware("auth:api");


Route::prefix("categories")->name(".categories")->middleware(['auth:api', 'header.middleware'])->group(function(){
    Route::get("/", [CategoryController::class, "index"]);
    Route::get("/{id}", [CategoryController::class, "detail"]);
    Route::post("/", [CategoryController::class, "store"]);
    Route::post("/{id}", [CategoryController::class, "update"]);
    Route::post("/delete/{id}", [CategoryController::class, "delete"]);
});
Route::prefix("posts")->name("posts.")->middleware(['auth:api', 'header.middleware'])->group(function(){
    Route::get("/", [PostController::class, 'index']);
    Route::get("/{id}", [PostController::class, 'detail'])->name("detail");
    Route::get("/{id}/comments", [PostController::class , 'comments']);
    Route::get("/user/{id}", [PostController::class, "user"]);
    Route::post("/", [PostController::class, "store"]);
    Route::post("/{id}", [PostController::class, "update"]);
    Route::post("/delete/{id}", [PostController::class, "delete"]);
});

Route::prefix("comments")->name("comments.")->middleware(['auth:api', 'header.middleware'])->group(function(){
    Route::get("/", [CommentController::class, "index"]);
    Route::get("/{id}", [CommentController::class, "detail"]);
    Route::get("/post/{id}", [CommentController::class, "comments"]);
    Route::post("/", [CommentController::class, "store"]);
    Route::post("/{id}", [CommentController::class, "update"]);
    Route::post("/delete/{id}", [CommentController::class, "delete"]);
});

Route::fallback(function(){
    return response()->json([
        'message' => 'contact nhat@website.com'], 404);
});
