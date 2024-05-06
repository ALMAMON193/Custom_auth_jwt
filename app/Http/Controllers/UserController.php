<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Helper\JWTToken;
use Illuminate\Http\Request;


class UserController extends Controller
{


    function UserRegistration(Request $request)
    {
        // User::create($request->all());
        try {
            $request->validate([
               
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'phone' => 'required',

            ]);
            User::create([
           
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'phone' => $request->input('phone'),
                
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully'

            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not created successfully'

            ], 400);
        }
    }

    public function Login(Request $request){
        try {
            $count =  User::where('email', $request->input('email'))->where('password', $request->input('password'))->count();
            if($count > 0){
                //jwt token issue
                $token = JWTToken::generateToken($request->input('email'));
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login Successfully',
                    'token' => $token,
                ] , 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Login Failed',
                ] , 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Login Failed',
            ] , 500);
        }
    }
}
