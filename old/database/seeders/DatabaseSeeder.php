<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SalutationSeeder::class);
        $this->call(SocialMediaSeeder::class);
        $this->call(RolesAndPermissionSeeder::class);
        $this->call(AdminSeeder::class);
    }
}
