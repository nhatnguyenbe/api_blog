<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function respond($data, $statusCode=200, $headers=[])
    {
        return response()->json($data, $statusCode, $headers);
    }

    public function respondSuccess($data = [], $message, $statusCode=200, $headers=[])
    {
        if(empty($data)) {
            return $this->respond([
                "status"=> true,
                "message" => $message,
            ], $statusCode, $headers);
        }else {
            return $this->respond([
                "status"=> true,
                "message" => $message,
                "records" =>$data,
            ], $statusCode, $headers);
        }
    }

    public function respondSuccessPaginate($data, $message, $total, $statusCode=200, $headers=[])
    {
        return $this->respond([
            "status"=> true,
            "message" => $message,
            "records"=>$data,
            "meta" => [
                "total" => $total
            ]
        ], $statusCode, $headers);
    }

    public function respondError($message, $statuscode)
    {
        return $this->respond([
            "status" => false,
            "error" => [
                "message"=>$message,
                "status"=> $statuscode,
            ]
        ], $statuscode);
    }
    public function respondNoContent($message="No Content")
    {
        return $this->respondError($message, 204);
    }
    // Không được xác thực 
    public function respondUnauthorixed($message="Unthorized")
    {
        return $this->respondError($message, 401);
    }
    // Không có quyền truy cập
    public function respondForbidden($message= "Forbidden")
    {
        return $this->respondError($message, 403);
    }

    // Không tồn tại 
    public function respondNotFound($message="Not Found")
    {
        return $this->respondError($message, 404);
    }

    // Phương thức không được cho phép
    public function respondMethodNotAllowed($message = "Method Not Allowed")
    {
        return $this->respondError($message, 405);
    }

    public function respondInternalServerError($message="Internal Server Error")
    {
        return $this->respondError($message,500);
    }
}
