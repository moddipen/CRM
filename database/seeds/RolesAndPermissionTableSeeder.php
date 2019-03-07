<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$permissions = [
			'login',
			'create-user',
			'edit-user',
			'delete-user',
			'view-user',
			'create-role',
			'edit-role',
			'delete-role',
			'view-role',
			'dashboard',
			'create-permission',
			'edit-permission',
			'delete-permission',
			'view-permission',
			'create-general-leave',
			'edit-general-leave',
			'delete-general-leave',
			'view-general-leave',
			'create-employee-leave',
			'edit-employee-leave',
			'delete-employee-leave',
			'view-employee-leave',
			'send-leave-doc',
			'apply-for-leave',
			'show-general-leave',
			'show-employee-leave',
			'show-error-view',
			'view-error',
			'edit-error',
			'delete-error',
			'create-error',
			'view-ticket',
			'create-ticket',
			'edit-ticket',
			'show-ticket',
			'delete-ticket',
			'env-setting',
			'approve-ticket',
			'denied-ticket',
		];


		$employeePermissions = [
			'login',
			'dashboard',
			'view-ticket',
			'create-ticket',
			'show-ticket',
			'apply-for-leave',
			'view-general-leave',
			'view-error',
			'create-error',
			'show-employee-leave',
			'show-general-leave',
			'show-error-view',
		];

		foreach($permissions as $permission){
			Permission::create(['name'=>$permission]);
		}

		$role = Role::create(['name'=>'Admin']);
        $role->givePermissionTo(Permission::all());

        $roleEmployee = Role::create(['name'=>'Employee']);
        
        foreach($employeePermissions as $employee){
        	$roleEmployee->givePermissionTo($employee);
        }
    }
}
