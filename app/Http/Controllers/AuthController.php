<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\Users\UserCreateRequest;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
	{
		if(Auth::attempt($request->only('email', 'password'))){
			$user = Auth::user();
			
			$token = $user->createToken('admin')->accessToken;
			
			return response(array(
				"token" => $token
			));
		}
		
		return response(array(
			"error" => "Invalid Credentials"
		), 401);
	}
	
	public function register(RegisterRequest $request)
	{
		$user = User::create($request->only("first_name","last_name", "email") + array(
			"password" => Hash::make($request->input('password'))
		));
		
		return response($user, 201);
	}
	
}
