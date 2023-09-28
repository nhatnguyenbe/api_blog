<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;
use Laravel\Passport\TokenRepository;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "email"=> "required|email",
                "password"=> "required",
            ]);
            if($validator->fails()) {
                return Response::json([
                    "status" => false,
                    "message" => $validator->getMessageBag()
                ]);
            }
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                $client =  Client::where("password_client", 1)->first();
                if($client){
                    $clientId = $client->id;
                    $clientSecret = $client->secret;
                    $response = Http::asForm()->post('/oauth/token', [
                        'grant_type' => 'password',
                        'client_id' => $clientId,
                        'client_secret' => $clientSecret,
                        'username' => $request->email,
                        'password' => $request->password,
                        'scope' => '',
                    ]);
                    return $response->json();
                }
            }else {
                return Response::json([
                    'status' => false,
                    "message" => "Account or password is incorrect"
                ]);
            }
        } catch (\Throwable $th) {
            return $this->respondInternalServerError($th->getMessage());
        }
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required|min:6",
                "email"=> "required|email|unique:users,email",
                "password"=> "required|min:8",
            ]);
            if($validator->fails()) {
                return Response::json([
                    "status" => false,
                    "message" => $validator->getMessageBag()
                ]);
            }

            $user = new User();
            $user->name =  $request->name;
            $user->email =  $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            if($user){
                return $this->respondSuccess($user, "User created successfully !!", 201);
            }else {
                return Response::json([
                    "status"=> false,
                    "message" => "User create error !!"
                ]);
            }
        } catch (\Throwable $th) {
            return $this->respondInternalServerError($th->getMessage());
        }
    }

    public function refreshToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "refresh" => "required",
        ]);
        if($validator->fails()) {
            return Response::json([
                "status" => "false",
                "message" => $validator->getMessageBag()
            ]);
        }
        try {
            $refreshToken = $request->refresh;
            $client = Client::where("password_client",1)->first();
            if($client) {
                $clientId = $client->id;
                $clientSecret = $client->secret;
                $response = Http::asForm()->post('/oauth/token', [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'scope' => '',
                ]);
                return $response->json();
            }
        } catch (\Throwable $th) {
            return $this->respondInternalServerError($th->getMessage());
        }
    }
    public function userDetail()
    {
        try {
            return Response::json([
                "status" => true,
                "message" => "User detail",
                "records" => Auth::user()
            ]);
        } catch (\Throwable $th) {
            return $this->respondInternalServerError($th->getMessage());
        }
    }
    public function logout(Request $request)
    {
        $user =  $request->user();
        $status = $user->token()->revoke();
        if($status) {
            return $this->respondSuccess([],  "Logout successfully!");
        }else {
            return response()->json([
                "status" => false,
                "message" => "Logout fail!!",
            ]);
        }
    }
}
