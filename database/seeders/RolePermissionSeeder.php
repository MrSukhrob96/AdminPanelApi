<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$permissions = Permission::all();
		
        $admin = Role::whereName("ADMIN")->first();
		
		foreach($permissions as $permission){
			DB::table("role_permission")->insert([
				"role_id" => $admin->id,
				"permission_id" => $permission->id
			]);
		}
		
		
		$editor = Role::whereName("EDITOR")->first();
		
		foreach($permissions as $permission){
			if(!in_array($permission->name, ["edit_roles"])){
				DB::table("role_permission")->insert([
					"role_id" => $editor->id,
					"permission_id" => $permission->id
				]);
			}
		}
		
		$viewer = Role::whereName("VIEWER")->first();

		$viewerRoles = [
			"view_users",
			"view_roles",
			"view_products",
			"view_orders"
		];
		
		foreach($permissions as $permission){
			if(!in_array($permission->name, $viewerRoles)){
				DB::table("role_permission")->insert([
					"role_id" => $viewer->id,
					"permission_id" => $permission->id
				]);
			}
		}
    }
}
