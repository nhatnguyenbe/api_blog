<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\SubComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $comments = Comment::orderBy("id");

            if($request->has("limit") && is_numeric($request->limit)){
                $comments =  $comments->limit($request->limit);
            }
            if($request->has("offset") && is_numeric($request->offset)){
                $comments =  $comments->offset($request->offset);
            }
            $comments = $comments->get();
            $comments = CommentResource::collection($comments);
            if(count($comments) > 0) {
                return Response::json([
                    "status"=> true,
                    "message" => "All comments",
                    "records" => $comments,
                ], 200);
            }else {
                return Response::json([
                    "status"=> true,
                    "message" => "No rescords",
                    "records" => $comments,
                ], 200);
            }
        } catch (\Throwable $th) {
            return Response::json([
                "status"=> false,
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function detail($id)
    {
        try {
            $comment = new CommentResource(Comment::find($id));
            if($comment) {
                return Response::json([
                    "status"=> true,
                    "message" => "Single comment",
                    "records" => $comment,
                ], 200);
            }else {
                return Response::json([
                    "status"=> true,
                    "message" => "Comment not found!",
                    "records" => $comment,
                ], 200);
            }
        } catch (\Throwable $th) {
            return Response::json([
                "status"=> false,
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function comments($id)
    {
        try {
            $comments = CommentResource::collection(Comment::where('post_id', $id)->get());
            if(count($comments) > 0) {
                return Response::json([
                    "status"=> true,
                    "message" => "All comment by post",
                    "records" => $comments,
                ], 200);
            }else {
                return Response::json([
                    "status"=> true,
                    "message" => "No rescords",
                    "records" => $comments,
                ], 200);
            }
        } catch (\Throwable $th) {
            return Response::json([
                "status"=> false,
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            if($request->comment_parent != 0){
                $rules = [
                    'comment' => "required",
                    'comment_id' => "required|integer"
                ];
            }else {
                $rules = [
                    "comment" => "required",
                    "post_id" => "required|integer",
                ];
            }
            $validator = Validator::make($request->all(),$rules);
    
            if($validator->fails()) {
                return Response::json([
                    "status" => false,
                    "message" => $validator->getMessageBag()
                ]);
            }

            if($request->has("comment_parent") && $request->comment_parent != 0){
                $subComment =  new SubComment();
                $subComment->comment_id = $request->comment_id;
                $subComment->user_id = Auth::user()->id;
                $subComment->comment = $request->comment;
                $subComment->save();
                if($subComment) {
                    return Response::json([
                        "status" => true,
                        "message" => "Comment created successfully !",
                        "records" => $subComment
                    ]);
                }else {
                    return Response::json([
                        "status" => false,
                        "message" => "Comment created error !",
                    ]);
                }
            }else {
                $comment = new Comment();
                $comment->post_id = $request->post_id;
                $comment->user_id = Auth::user()->id;
                $comment->comment =  $request->comment;
                $comment->save();
                if($comment) {
                    return Response::json([
                        "status" => true,
                        "message" => "Comment created successfully !",
                        "records" => $comment
                    ]);
                }else {
                    return Response::json([
                        "status" => false,
                        "message" => "Comment created error !",
                    ]);
                }
            }
        } catch (\Throwable $th) {
            return Response::json([
                "status"=> false,
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            if($request->comment_parent != 0){
                $rules = [
                    'comment' => "nullable",
                ];
            }else {
                $rules = [
                    "comment" => "nullable",
                    "post_id" => "nullable|integer",
                ];
            }
            $validator = Validator::make($request->all(),$rules);
    
            if($validator->fails()) {
                return Response::json([
                    "status" => false,
                    "message" => $validator->getMessageBag()
                ]);
            }

            if($request->has("comment_parent") && $request->comment_parent != 0){ 
                $subComment = SubComment::find($id);
                if($subComment) {
                    if($request->comment){
                        $subComment->comment = $request->comment;
                    }

                    $subComment->save();
                    if($subComment) {
                        return Response::json([
                            "status" => true,
                            "message" => "Comment updated successfully !",
                            "records" => $subComment
                        ]);
                    }else {
                        return Response::json([
                            "status" => false,
                            "message" => "Comment updated error !",
                        ]);
                    }
                }else {
                    return Response::json([
                        "status"=> false,
                        "message" => "No comments exist"
                    ]);
                }
            }else {
                $comment = Comment::find($id);
                if($comment) {
                    if($request->post_id) {
                        $comment->post_id = $request->post_id;
                    }
                    $comment->user_id = Auth::user()->id;
                    if($request->comment) {
                        $comment->comment =  $request->comment;
                    }
                    $comment->save();
                    if($comment) {
                        return Response::json([
                            "status" => true,
                            "message" => "Comment updated successfully !",
                            "records" => $comment
                        ]);
                    }else {
                        return Response::json([
                            "status" => false,
                            "message" => "Comment updated error !",
                        ]);
                    }
                }else {
                    return Response::json([
                        "status"=> false,
                        "message" => "No comments exist"
                    ]);
                }
            }
        } catch (\Throwable $th) {
            return Response::json([
                "status"=> false,
                "message" => $th->getMessage()
            ], 500);
        }
    }
    
    public function delete(Request $request, $id)
    {
        try {
            if($request->has("comment_parent") && $request->comment_parent != 0){
                $subComment = SubComment::where("id", $id)->where("user_id", Auth::user()->id)->first();
                if($subComment){
                    $result = $subComment->destroy($id);
                    if($result) {
                        return Response::json([
                            "status" => true,
                            "message" =>"Comment delete successfully! "
                        ]);
                    }else {
                        return Response::json([
                            "status" =>false,
                            "message" => "Comment delete error!"
                        ]);
                    }
                }else {
                    return Response::json([
                        "status"=> false,
                        "message" => "No comments exist"
                    ]);
                }
            }else {
                $comment = Comment::where("id", $id)->where("user_id", Auth::user()->id)->first();
                if($comment){
                    $subCommentCount = $comment->subComment->count();
                    if($subCommentCount > 0) {
                        foreach ($comment->subComment as $value) {
                            SubComment::destroy($value->id);
                        }
                    }
                    $result = Comment::destroy($id);
                    if($result) {
                        return Response::json([
                            "status" => true,
                            "message" =>"Comment delete successfully! "
                        ]);
                    }else {
                        return Response::json([
                            "status" =>false,
                            "message" => "Comment delete error!"
                        ]);
                    }
                    
                }else {
                    return Response::json([
                        "status"=> false,
                        "message" => "No comments exist"
                    ]);
                }
            }
        } catch (\Throwable $th) {
            return Response::json([
                "status"=> false,
                "message" => $th->getMessage()
            ], 500);
        }
    }
}
