<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use BezhanSalleh\FilamentShield\Support\Utils;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        // Step 0: Clear cached permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Step 1: Create the super_admin role
        $superAdminRole = Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'web',
        ]);

        // Step 2: Create all model & widget permissions
        $this->makeModelPermissions();
        $this->makeWidgetPermissions();

        // Step 3: Re-cache permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Step 4: Assign all permissions to super_admin
        $superAdminRole->syncPermissions(Permission::all());

        // Step 5: Create or update Super Admin user
        // $user = User::updateOrCreate(
        //     ['email' => 'admin@gmail.com'],
        //     [
        //         'name' => 'Super Admin',
        //         'password' => Hash::make('1234'),
        //     ]
        // );

        // // Step 6: Assign role to the user
        // $user->syncRoles(['super_admin']);
    }

    protected function makeModelPermissions(): void
    {
        $permissionModel = Utils::getPermissionModel();

        $models = [
            'user',
            'category',
            'locale',
            'author',
            'license',
            'software',
            'software::translation',
            'license::translation',
            'page',
            'category::translation',
            'platform',
            'software::requirement',
            'requirement',
            'site::setting',
            'site::translation',
            'role',
        ];

        $actions = [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any'
            
 
        ];

        foreach ($models as $model) {
            foreach ($actions as $action) {
                $permissionModel::firstOrCreate([
                    'name' => "{$action}_{$model}",
                    'guard_name' => 'web',
                ]);
            }
        }
    }

    protected function makeWidgetPermissions(): void
    {
        $permissionModel = Utils::getPermissionModel();
    
        $widgets = [
            'StatsOverview',
            'DownloadsChart',
            'SoftwarePostsChart',
        ];
    
        foreach ($widgets as $widget) {
            $permissionModel::firstOrCreate([
                'name' => "widget_{$widget}",
                'guard_name' => 'web',
            ]);
        }
    }
}
