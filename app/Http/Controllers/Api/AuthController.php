<?php

namespace App\Http\Controllers\Api;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        $validatedData = $request->validate([
            'username' =>'required|string|max:55|min:2',
            'email'=>'email|required|string|unique:users',
            'password'=>'required|confirmed',
            // 'name'=>'nullable|string'
        ]);
        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user'=>$user, 'access_token'=>$accessToken]);
    }

    public function login(Request $request){
        $loginData = $request->validate([
            'email'=>'email|required',
            'password'=>'required',
            // 'name'=>'nullable|string'
        ]);
        if(!Auth::attempt($loginData)){
            return response(['message'=>'Invalid Login credentials']);
        }
        $accessToken = Auth::user()->createToken('authToken')->accessToken;

        return response(['user'=>Auth::user(), 'access_token'=>$accessToken]);
    }

    public function logout (Request $request) {

        $token = $request->user()->token();
        $token->revoke();

        $response = 'You have been succesfully logged out!';
        return response($response, 200);

    }
}
