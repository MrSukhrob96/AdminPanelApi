<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\Users\UserCreateRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

  public function index()
  {
    $users = User::paginate();
    return UserResource::collection($users);
  }

  public function store(UserCreateRequest $request)
  {
    $user = User::create($request->only("first_name", "last_name", "email", "role_id") + array(
      "password" => Hash::make($request->input('password'))
    ));

    return response(new UserResource($user), 201);
  }

  public function show($id)
  {
    $user = User::find($id);

    return new UserResource($user);
  }

  public function update(UserUpdateRequest $request, $id)
  {
    $user = User::find($id);

    $user->update($request->only("first_name", "last_name", "email", "role_id"));

    return response(new UserResource($user), 202);
  }

  public function destroy($id)
  {
    User::destroy($id);

    return response(null, 204);
  }

  public function user()
  {
    $user = Auth::user();

    return (new UserResource($user))->additional(array(
      'data' => array(
        'permission' => $user->permissions()
      )
    ));
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
