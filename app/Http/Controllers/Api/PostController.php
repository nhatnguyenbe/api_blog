<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\SubComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends ApiController
{
    public function index(Request $request)
    {
        try {
            $perPage =  1;
            $posts = Post::orderBy("id", 'asc');
            if($request->has('limit') && is_numeric($request->limit)){
                $posts = $posts->limit($request->limit);
            }
            if($request->has('offset')  && is_numeric($request->offset)){
                $posts = $posts->offset($request->offset);
            }
            if($request->has('keyword') && $request->keyword){
                $posts = $posts->where("title", 'like', "%{$request->keyword}%");
            }
            if($request->has('page') && is_numeric($request->page)){
                $posts = $posts->paginate($perPage)->withQueryString();
            }else {
                $posts = $posts->get();
            }
            $total = $posts->count();
            $posts = PostResource::collection($posts);
            if(count($posts) == 0) {
                return $this->respondSuccess($posts, "No posts match found !");
            }
            return $this->respondSuccessPaginate($posts, "All Posts", $total);
        } catch (\Throwable $th) {
            return $this->respondInternalServerError($th->getMessage());
        }
    }

    public function detail(Request $request, $id)
    {
        try {
            $post = Post::where("id", $id)->first();
            if($post){
                $post = new PostResource($post);
                return $this->respondSuccess($post, "Single Post");
            }else {
                return Response::json([
                    "status" => true,
                    "message" => "Post not found !",
                    "records" => $post
                ]);
            }
        } catch (\Throwable $th) {
            return $this->respondInternalServerError($th->getMessage());
        }
    }

    public function comments($id)
    {
        try {
            $comments = Comment::where("post_id", $id)->get();
            if(count($comments)>0) {
                return $this->respondSuccessPaginate($comments, 'Comments by post', count($comments));
            }else {
                return $this->respondSuccess([], "No comments by post");
            }
            $comments = CommentResource::collection($comments);
        } catch (\Throwable $th) {
            return $this->respondInternalServerError($th->getMessage());
        }
    }

    // Lấy bài viết theo user
    public function user($id)
    {
        try {
            $user = User::find($id);
            if($user) {
                $posts = Post::where("user_id", $user->id)->get();
                if(count($posts)){
                    $total =  count($posts);
                    return $this->respondSuccessPaginate($posts,"Posts by user", $total);
                }else {
                    return $this->respondSuccess([], "Posts not found !");
                }
            }else {
                return Response::json([
                    "status" => true,
                    "message" => "User not found !!"
                ]);
            }
        } catch (\Throwable $th) {
            return $this->respondInternalServerError($th->getMessage());
        }
    }
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'title'=>"required",
            'slug' => "required",
            'thumbnail' => "required|image|mimes:jpeg,png,jpg",
            'summary' => "required",
            'category_id' => "required|integer"
        ]);
        if($validator->fails()) {
            return response()->json([
                "status" => false, 
                "message" => $validator->getMessageBag()
            ]);
        }
        try {
            $post = new Post();
            $post->title = trim($request->title);
            $post->slug = trim(Str::slug($request->slug).'.html');
            $post->summary = trim($request->summary);
            // handle images;
            // $newName  = $request->thumbnail->getClientOriginalName();
            $extension = $request->thumbnail->extension();
            $newName = time().".".$extension;
            $request->thumbnail->move(public_path("images"), $newName);
            $post->thumbnail =  $newName;
            if($request->content) {
                $post->content = $request->content;
            }
            $post->user_id = $request->user()->id;
            $post->category_id =  $request->category_id;
            $post->save();
            if($post) {
                return $this->respondSuccess($post, "Post created successfully !", 201);
            }else {
                return $this->respondInternalServerError("Post created error !");
            }
        } catch (\Throwable $th) {
            return $this->respondInternalServerError($th->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        $validator =  Validator::make($request->all(), [
            'title'=>"nullable",
            'slug' => "nullable",
            'thumbnail' => "nullable|image|mimes:jpeg,png,jpg",
            'summary' => "nullable",
            'category_id' => "nullable|integer"
        ]);
        if($validator->fails()) {
            return response()->json([
                "status" => false, 
                "message" => $validator->getMessageBag()
            ]);
        }
        try {
            $post = Post::find($id);
            if($post) {
                if($request->title){
                    $post->title = $request->title;
                }
                if($request->slug) {
                    $post->slug =  Str::slug($request->slug);
                }
                if($request->summary) {
                    $post->summary = $request->summary;
                }
                $post->user_id = $request->user()->id;
                if($request->category_id) {
                    $post->category_id = $request->category_id;
                }

                if($request->content) {
                    $post->content = $request->content;
                }

                if($request->hasFile("thumbnail")){
                    if($post->thumbnail) {
                        if(file_exists(public_path("images/{$post->thumbnail}"))){
                            unlink(public_path("images/{$post->thumbnail}"));
                        }
                    }
                    //  handle thumbnail
                    $extension = $request->thumbnail->extension();
                    $newName =  time().".".$extension;
                    $request->thumbnail->move(public_path("images"), $newName);
                    $post->thumbnail = $newName;

                    $post->save();
                    if($post) {
                        $post = new PostResource($post);
                        return $this->respondSuccess($post, "Post updated successfully!");
                    }
                }
            }else {
                return $this->respondSuccess([], "Post not found !");
            }
        } catch (\Throwable $th) {
            return $this->respondInternalServerError($th->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $post = Post::where("id", $id)->where("user_id", Auth::user()->id)->first();
            if($post) {
                $commentCount =  $post->comments->count();
                if($commentCount > 0) {
                    foreach ($post->comments as $comment) {
                        $subCommCount = $comment->subComment->count();
                        if($subCommCount > 0) {
                            foreach ($comment->subComment as $subComm) {
                                SubComment::destroy($subComm->id);
                            }
                        }
                        Comment::destroy($comment->id);
                    }
                }
                if(file_exists(public_path("images/{$post->thumbnail}"))){
                    unlink(public_path("images/{$post->thumbnail}"));
                }
                $result =  Post::destroy($post->id);
                if($result) {
                    return $this->respondSuccess([], "Post delete successfully!");
                }else {
                    return Response::json([
                        "status" =>false,
                        "message" => "Post delete error!"
                    ]);
                }
            }else {
                return Response::json([
                    "status" => false,
                    "message" => "Post not found !!"
                ]);
            }
        } catch (\Throwable $th) {
            return $this->respondInternalServerError($th->getMessage());
        }
    }
}
