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
                'name' => 'Research Admin',
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
            'Journals',
            'Add Journals',
            'Edit Journals',
            'Delete Journals',

            'View Notification Messages',
            'View Review Sections',
            'View File Categories',
            'View Submission Confirmation',

            'View Dashboard',

            'Users',
            'View Users',
            'Add Users',
            'Edit Users',
            'Delete Users',

            'View User Logs',

            'View Salutations',
            'View Permissions',
            'View Roles',
            
            'View Journal Subjects',
            'View Journal Categories',

            'Website',
            'View Sliding Images'
        );

        foreach($permissions as $permission){
            $data = Permission::create([
                'name' => $permission
            ]);

            $data->assignRole('Administrator');
        }
        
    }
}
