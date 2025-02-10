<?php

namespace Database\Seeders;

use App\Models\ArticleStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = array(
            ['Pending', '001'],
            ['Submitted', '002'],
            ['From Editor', '003'],
            ['On Review', '004'],
            ['From Reviewer', '005'],
            ['Published', '006'],
            ['Declined', '007'],
            ['Declined Revision', '008'],
            ['Unpublished', '009'],
            ['Banned', '010'],
            ['Publication Process', '011'],
            ['Cancelled Submission', '012'],
            ['From Editorial Board', '013'],
        );

        
        foreach($statuses as $status){
            $data = ArticleStatus::create([
                'name' => $status[0],
                'code' => $status[1],
            ]);
        }
    }
}
