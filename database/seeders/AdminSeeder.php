<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'first_name'    => 'Super',
            'last_name'     => 'Administrator',
            'email'         => 'admin@ifm.ac.tz',
            'gender'        => 'Male',
            'salutation_id' => '1',
            'password'      => Hash::make('admin@ifm123EMS'),
        ]);

        $admin->assignRole('Administrator');
    }
}
