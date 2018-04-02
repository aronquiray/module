<?php

namespace HalcyonLaravel\Module\AbstractClasses;

// on core test
use Tests\TestCase;

use Hash;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use Spatie\Permission\Models\Permission;

abstract class BaseModuleTest extends TestCase
{
        protected function loginAsAdminModule($moduleName)
        {
   
            $adminRole = factory(Role::class)->create(['name' => config('access.users.admin_role')]);
            $adminRole->givePermissionTo(factory(Permission::class)->create(['name' => 'view backend']));
            $user = factory(User::class)->create();
            $user->assignRole($adminRole);
    
            $user = User::create([
                'first_name'        => ucfirst($moduleName) . ' User',
                'last_name'         => 'Manager',
                'email'             => 'news@system.com',
                'password'          => Hash::make('1234'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
            ]);
    
            // Create Roles
            $role = Role::create(['name' => $moduleName . ' manager']);
            $role->givePermissionTo($this->_permissions($moduleName));
            $role->givePermissionTo('view backend');
    
            $user->assignRole($role);
            
            User::find(1)->assignRole($role);

            $this->actingAs(User::find(1));
        }
    
        private function _permissions($prefix) :array
        {
            $return = [];
    
            foreach([
                'list',
                'create',
                'update',
                'show',
            ] as $p){
                $return[] = $prefix . ' ' . $p;
    
                // Create Permissions
                Permission::create(['name' => $prefix . ' ' . $p]);
            }
    
            return $return;
        }
}