<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\User;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function postRegister(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|min:2',
            'password' => 'required|alphaNum|min:6|same:password_confirmation',
        ]);

        if ($validator->fails()) {
            $message = ['errors' => $validator->messages()->all()];
            $response = Response::json($message,202);
        } else {

            $user = new User(array(
                'email' => trim($request->email),
                'name' => trim($request->name),
                'password' => bcrypt($request->password),
            ));

            $user->save();

            $message = 'The user has been created successfully';

            $response = Response::json([
                'message' => $message,
                'user' => $user,
            ], 201);
        }
        return $response;
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $message = ['errors' => $validator->messages()->all()];
            $response = Response::json($message, 202);
        } else {
            $credentials = $request->only('email', 'password');

            try {
                $token = JWTAuth::attempt($credentials);

                if ($token) {
                    $message = ['success' => $token];
                    return $response = Response::json(["token" => $token], 200);
                } else {
                    $message = ['errors' => "Invalid credentials"];
                    return $response = Response::json($message, 202);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }
        }
    }
}
