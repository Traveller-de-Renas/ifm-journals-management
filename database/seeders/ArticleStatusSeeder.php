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
            ['Pending', '001', 'bg-yellow-200'],
            ['Submitted', '002', 'bg-blue-400'],
            ['From Editor', '003', 'bg-indigo-500'],
            ['On Review', '004', 'bg-purple-700'],
            ['From Reviewer', '005', 'bg-pink-600'],
            ['Published', '006', 'bg-green-700'],
            ['Declined', '007', 'bg-gray-200'],
            ['Declined Revision', '008', 'bg-red-700'],
            ['Unpublished', '009', 'bg-red-300'],
            ['Banned', '010', 'bg-gray-700'],
            ['Publication Process', '011', 'bg-green-200'],
            ['Cancelled Submission', '012', 'bg-gray-200'],
            ['From Editorial Board', '013', 'bg-yellow-200'],
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
