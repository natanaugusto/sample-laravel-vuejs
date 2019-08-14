<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public static $roles = [
        'admin' => '*',
    ];

    public static $permissions = [
        'list products',
        'view product',
        'add product',
        'update product',
        'delete product',
        'list categories',
        'add category',
        'view category',
        'update category',
        'delete category',
    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach(self::$permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        foreach(self::$roles as $role => $permission) {
            $role = Role::firstOrCreate(['name' => $role]);
            if(!is_null($permission)) {
                $role->givePermissionTo(
                    $permission === '*' ? 
                    Permission::all() :
                    $permission
                );
            }
        }
    }
}
