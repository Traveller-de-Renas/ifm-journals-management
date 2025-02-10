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
        $roles = array(
            [
                'name' => 'Administrator',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Chief Editor',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Supporting Editor',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Associate Editor',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Reviewer',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Author',
                'guard_name' => 'web'
            ]
        );

        foreach($roles as $role){
            Role::create($role);
        }

        $permissions = array(
            'Add Journals',
            'configurations',
            'users',
            'Editorial Board',
            'Journals',
            'Publication Process',
            'Subjects',
            'Categories',
        );

        // foreach($permissions as $permission){
        //     $array = array('', 'View ', 'Add ', 'Edit ', 'Delete ');
        //     foreach($array as $prefix){
        //         $data = Permission::create([
        //             'name' => $prefix.$permission
        //         ]);

        //         $data->assignRole('Administrator');
        //     }
        // }
        
    }
}
