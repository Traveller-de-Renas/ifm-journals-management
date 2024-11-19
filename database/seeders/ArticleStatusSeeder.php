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
            ['Pending', 'yellow'],
            ['Submitted', 'blue'],
            ['From Editor', 'indigo'],
            ['On Review', 'purple'],
            ['From Reviewer', 'pink'],
            ['Published', 'green'],
            ['Declined', 'gray'],
            ['Declined Revision', 'red'],
            ['Unpublished', 'red'],
            ['Banned', 'black'],
            ['Publication Process', 'blue'],
        );

        
        foreach($statuses as $status){
            $data = ArticleStatus::create([
                'name' => $status[0],
                'description' => $status[0],
                'color' => $status[1]
            ]);
        }
    }
}
