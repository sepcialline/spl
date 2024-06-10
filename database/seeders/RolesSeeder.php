<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Super Admin','guard_name'=>'admin']);


        $permissions = Permission::where('guard_name','admin')->pluck('id','id')->all();
        $role1->syncPermissions($permissions);

        $user1 = Admin::create([
            'name' => ['ar' => 'سوبر أدمن', 'en' => 'Super Admin'],
            'email' => 'super.admin@sp.ae',
            'mobile' => '97100000000',
            'password' => Hash::make('19961996'),
            'emirate_id' => '1',
            'status' => '1',
            'photo' => 'avatar.png',
            'branch_id'=>'1',
            'department_id'=>'2',
            'is_department_head'=>'1',
        ]);
        $user1->assignRole([$role1->id]);

        // $role2 = Role::create(['name' => 'Admin','guard_name'=>'admin']);
        // $role3 = Role::create(['name' => 'Editor','guard_name'=>'admin']);
        // $role4 = Role::create(['name' => 'Accounting','guard_name'=>'admin']);
        // $role5 = Role::create(['name' => 'Store Keeper','guard_name'=>'admin']);
        // $role6 = Role::create(['name' => 'HR','guard_name'=>'admin']);
        // $role7 = Role::create(['name' => 'Graphic Design','guard_name'=>'admin']);
        // $role8 = Role::create(['name' => 'Data Entry','guard_name'=>'admin']);
        // $role9 = Role::create(['name' => 'Sales Manager','guard_name'=>'admin']);
        // $role10 = Role::create(['name' => 'Sales','guard_name'=>'admin']);


        $role11 = Role::create(['name' => 'Admin','guard_name'=>'employee']);

        $permissions_employee = Permission::where('guard_name','employee')->pluck('id','id')->all();
        $role11->syncPermissions($permissions_employee);


        // $role12 = Role::create(['name' => 'Editor','guard_name'=>'employee']);
        // $role13 = Role::create(['name' => 'Accounting','guard_name'=>'employee']);
        // $role14 = Role::create(['name' => 'Store Keeper','guard_name'=>'employee']);
        // $role15 = Role::create(['name' => 'Data Entry','guard_name'=>'employee']);
        // $role16 = Role::create(['name' => 'Sales Manager','guard_name'=>'employee']);
        // $role17 = Role::create(['name' => 'Sales','guard_name'=>'employee']);

        $role18 = Role::create(['name' => 'Admin','guard_name'=>'vendor']);

        // $role19 = Role::create(['name' => 'Data Entry','guard_name'=>'vendor']);

    }
}
