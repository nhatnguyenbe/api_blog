<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = CategoryResource::collection(Category::get());
            if(count($categories)>0) {
                return Response::json([
                    "status" => true,
                    "message" => "All categories",
                    "records" => $categories
                ]);
            }else {
                return Response::json([
                    "status" => true,
                    "message" => "No records categories",
                    "records" => $categories
                ]);
            }
        } catch (\Throwable $th) {
            return Response::json([
                "status"=> false,
                "message" => $th->getMessage()
            ],500);
        }
    }

    public function detail($id)
    {
        try {
            $category = Category::find($id);
            if($category){
                $category = new CategoryResource($category);
                return Response::json([
                    "status" => true,
                    "message" => "Single category",
                    "records" => $category
                ]);
            }else {
                return Response::json([
                    "status" => true,
                    "message" => "Category not found!",
                    "records" => $category
                ]);
            }
        } catch (\Throwable $th) {
            return Response::json([
                "status"=> false,
                "message" => $th->getMessage()
            ],500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "title"=> "required|min:4",
                "slug"=> "required",
                "description" => "nullable|min:6"
            ]);

            if($validator->fails()){
                return Response::json([
                    "status" => false,
                    "message" => $validator->getMessageBag()
                ], 422);
            }

            $category = new Category();
            $category->title = $request->title;
            $category->slug = Str::slug($request->slug);
            if($request->description) {
                $category->description = $request->description;
            }
            $category->parent_id = 0;
            $category->save();
            
            if($category->id) {
                return Response::json([
                    "status" => true,
                    "message"=> "Category created successfully  !!",
                    "records" => new CategoryResource($category)
                ], 201);
            }else {
                return Response::json([
                    "status" => false,
                    "message"=> "Category created error  !!",
                ]);
            }
        } catch (\Throwable $th) {
            return Response::json([
                "status"=> false,
                "message" => $th->getMessage()
            ],500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                "title"=> "required|min:4",
                "slug"=> "required",
                "description" => "nullable|min:6"
            ]);

            if($validator->fails()){
                return Response::json([
                    "status" => false,
                    "message" => $validator->getMessageBag()
                ], 422);
            }
            $category = Category::find($id);
            if($category) {
                $category->title =  $request->title;
                $category->slug = Str::slug($request->slug);
                $category->description = $request->description;
                $category->parent_id =  0;
                $category->save();
                if($category) {
                    return Response::json([
                        "status" => true,
                        "message" => "Category updated successfully!",
                        "records" => new CategoryResource($category)
                    ]);
                }else {
                    return Response::json([
                        "status" => false,
                        "message" => "Category updated error!",
                    ]);
                }
            }else {
                return Response::json([
                    "status" => true,
                    "message" => "Category not found!",
                    "records" => $category
                ]);
            }
            
        } catch (\Throwable $th) {
            return Response::json([
                "status"=> false,
                "message" => $th->getMessage()
            ],500);
        }    
    }

    public function delete($id)
    {
        try {
            $category = Category::find($id);
            if($category) {
                $postCount = $category->posts->count();
                if($postCount > 0){
                    return Response::json([
                        "status" => false,
                        "message" => "Cannot delete category, Because have {$postCount} post belong category",
                    ], 404);
                }else {
                    return Response::json([
                        "status" => true,
                        "message" => "Category delete successfully!",
                    ], 204);
                }
            }else {
                return Response::json([
                    "status" => true,
                    "message" => "Category not found!",
                    "records" => $category
                ]);
            }
        } catch (\Throwable $th) {
            return Response::json([
                "status"=> false,
                "message" => $th->getMessage()
            ],500);
        }
    }
}
