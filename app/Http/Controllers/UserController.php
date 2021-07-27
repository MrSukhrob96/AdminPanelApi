<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\Users\UserCreateRequest;
use App\Http\Requests\Users\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate();
		
		return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $user = User::create($request->only("first_name","last_name", "email", "role_id") + array(
			"password" => Hash::make($request->input('password'))
		));
		
		return response(new UserResource($user), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
		
		return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
       $user = User::find($id);
	   
	   $user->update($request->only("first_name","last_name", "email", "role_id"));
		
		return response(new UserResource($user), 202);
	   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
		
		return response(null, 204);
    }
	
	public function user()
	{
		return new UserResource(Auth::user());
	}
	
	public function updateInfo(UserUpdateRequest $request)
	{
		$user = Auth::user();
		
		$user->update($request->only("first_name", "last_name", "email"));
		
		return response(new UserResource($user), 202);
	}
	
	public function updatePassword(Request $request)
	{
		$user = Auth::user();
		
		$user->update(array(
			"password" => Hash::make($request->input("password"))
		));
	
		return response(new UserResource($user), 202); 
	}
	
}
