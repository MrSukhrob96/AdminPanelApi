<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

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
		
        $admin = Role::whereName("Admin")->first();
		
		foreach($permissions as $permission){
			DB::table("role_permission")->insert([
				"role_id" => $admin->id,
				"permission" => $permission->id
			]);
		}
		
		
		$editor = Role::whereName("Editor")->first();
		
		foreach($permissions as $permission){
			if(!in_array($permission->name, ["edit_roles"])){
				DB::table("role_permission")->insert([
					"role_id" => $admin->id,
					"permission" => $permission->id
				]);
			}
		}
		
		$viewer = Role::whereName("Viewer")->first();
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
					"permission" => $permission->id
				]);
			}
		}
    }
}