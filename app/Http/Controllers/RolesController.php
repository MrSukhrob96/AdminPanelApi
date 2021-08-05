<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

use App\Http\Resources\RoleResource;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{

  public function index()
  {
    return RoleResource::collection(Role::all());
  }


  public function store(Request $request)
  {
    $role = Role::create($request->only("name"));

    if ($permissions = $request->input('permissions')) {
      foreach ($permissions as $permission_id) {
        DB::table('role_permission')->insert([
          'role_id' => $role->id,
          'permission_id' => $permission_id
        ]);
      }
    }

    return response(new RoleResource($role), 201);
  }


  public function show($id)
  {
    return new RoleResource(Role::find($id));
  }

  public function update(Request $request, $id)
  {
    $role = Role::find($id);
    $role->update($request->only("name"));

    DB::table('role_permission')->where('role_id', $role->id)->delete();

    if ($permissions = $request->input('permissions')) {
      foreach ($permissions as $permission_id) {
        DB::table('role_permission')->insert([
          'role_id' => $role->id,
          'permission_id' => $permission_id
        ]);
      }
    }

    return response(new RoleResource($role), 202);
  }

  public function destroy($id)
  {
    DB::table('role_permission')->where('role_id', $id)->delete();
    Role::destroy($id);

    return response(null, 204);
  }
}
