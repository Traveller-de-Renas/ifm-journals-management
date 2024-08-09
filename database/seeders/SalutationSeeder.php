<?php

namespace Database\Seeders;

use App\Models\Salutation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SalutationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $titles = array(
            'Mr.',
            'Miss.',
            'Dr.',
            'Prof.',
            'CPA.',
            'Fr.',
            'Hon.'
        );

        foreach ($titles as $key => $value) {
            Salutation::create(['title' => $value]);
        }
    }
}
