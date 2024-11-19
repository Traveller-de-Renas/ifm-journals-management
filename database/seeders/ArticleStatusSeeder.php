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
            ['Pending', '001', 'yellow'],
            ['Submitted', '002', 'blue'],
            ['From Editor', '003', 'indigo'],
            ['On Review', '004', 'purple'],
            ['From Reviewer', '005', 'pink'],
            ['Published', '006', 'green'],
            ['Declined', '007', 'gray'],
            ['Declined Revision', '008', 'red'],
            ['Unpublished', '009', 'red'],
            ['Banned', '010', 'black'],
            ['Publication Process', '011', 'blue'],
            ['Cancelled Submission', '012', 'gray'],
        );

        
        foreach($statuses as $status){
            $data = ArticleStatus::create([
                'name' => $status[0],
                'code' => $status[1],
                'description' => $status[0],
                'color' => $status[2]
            ]);
        }
    }
}
