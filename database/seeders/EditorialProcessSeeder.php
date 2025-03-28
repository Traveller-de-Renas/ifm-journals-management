<?php

namespace Database\Seeders;

use App\Models\EditorialProcess;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EditorialProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = array(
            [
                'title' => 'Supporting Editor Send to Managing Editor',
                'code' => '001',
                'description' => 'Editorial Process',
                'status' => '1'
            ],
            [
                'title' => 'Managing Editor Send to Associate Editor and Associate Editor Send to Reviewer',
                'code' => '002',
                'description' => 'Editorial Process',
                'status' => '1'
            ],
            [
                'title' => 'Managing Editor Send to author Rejection Decision',
                'code' => '003',
                'description' => 'Editorial Process',
                'status' => '1'
            ],
            [
                'title' => 'Associate Editor Send to Managing Editor Rejection Decision',
                'code' => '004',
                'description' => 'Editorial Process',
                'status' => '1'
            ],
            [
                'title' => 'Associate Editor Send to Managing Editor Major Revision',
                'code' => '005',
                'description' => 'Editorial Process',
                'status' => '1'
            ],
            [
                'title' => 'Managing Editor Send to author Major Revision',
                'code' => '006',
                'description' => 'Editorial Process',
                'status' => '1'
            ],
            [
                'title' => 'Associate Editor Send to Managing Editor Minor Revision',
                'code' => '007',
                'description' => 'Editorial Process',
                'status' => '1'
            ],
            [
                'title' => 'Managing Editor Send to author Minor Revision',
                'code' => '008',
                'description' => 'Editorial Process',
                'status' => '1'
            ],
            [
                'title' => 'Associate Editor Send to Managing Editor Acceptance decision',
                'code' => '009',
                'description' => 'Editorial Process',
                'status' => '1'
            ],
            [
                'title' => 'Managing Editor Send to author Acceptance Decision',
                'code'  => '010',
                'description' => 'Editorial Process',
                'status' => '1'
            ],
            [
                'title' => 'Supporting Editor publish online Manuscript Qualifies for Publication',
                'code' => '011',
                'description' => 'Editorial Process',
                'status' => '1'
            ]
        );

        foreach ($array as $key => $value) {
            EditorialProcess::create(
                $value
            );
        }
    }
}
