<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
       
        $adminRole = Role::create(['name' => 'admin']);
        $vendorRole = Role::create(['name' => 'vendor']);
        $customerRole = Role::create(['name' => 'customer']);

       
        $viewPermission = Permission::create(['name' => 'view']);
        $createPermission = Permission::create(['name' => 'create']);
        $updatePermission = Permission::create(['name' => 'update']);
        $deletePermission = Permission::create(['name' => 'delete']);

        
        $adminRole->givePermissionTo([$viewPermission, $createPermission, $updatePermission, $deletePermission]);
        $vendorRole->givePermissionTo([$createPermission, $updatePermission]);
        $customerRole->givePermissionTo([$viewPermission]);

    //     $customer=User::create([
    //         'name'=>'customer',
    //         'email'=>'customer@123',
    //         'password' => Hash::make('password'),
    //     ]);
    //     $customer->assignRole($customerRole);

    //     $vendor=User::create([
    //         'name'=>'vendor',
    //         'email'=>'vendor@123',
    //         'password' => Hash::make('password'),
    //     ]);
    //     $vendor->assignRole($vendorRole);
    }
}
