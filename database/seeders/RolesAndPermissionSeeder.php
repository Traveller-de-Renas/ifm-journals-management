<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'Administrator']);

        $permissions = array(
            'website',
            'configurations',
            'users',
            'Editorial Board',
            'Journals',
            'Subjects',
            'Categories',
        );

        foreach($permissions as $permission){
            $array = array('', 'View ', 'Add ', 'Edit ', 'Delete ');
            foreach($array as $prefix){
                $data = Permission::create([
                    'name' => $prefix.$permission
                ]);

                $data->assignRole('Administrator');
            }
        }
        
    }
}
