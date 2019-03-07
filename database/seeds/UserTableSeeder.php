<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $admin = new User;
        $admin->name = 'Admin';
        $admin->email = 'admin@teknomines.com';
        $admin->password = bcrypt('admin');
        $admin->save();

        $admin->assignRole('Admin');

        $employee = new User;
        $employee->name = 'Employee';
        $employee->email = 'employee@teknomines.com';
        $employee->password = bcrypt('employee');
        $employee->save();
        
        $employee->assignRole('Employee');

    }
}
