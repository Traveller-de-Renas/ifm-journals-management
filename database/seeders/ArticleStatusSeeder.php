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
            ['Pending', '001', 'background-color:#4a00db; color:white;', 5],
            ['Submitted', '002', 'background-color: #0b5345; color: white;', 5],
            ['Passed Screening Stage', '003', 'background-color:#469e98; color:white;', 5],
            ['Returned to Author', '004', 'background-color:#317b80; color:white;', 5],
            ['Pending Resubmission', '005', 'background-color:#310036; color:white;', 5],
            ['Resubmitted with Comment Matrix', '006', 'background-color:#004366; color:white;', 5],
            ['Closed', '007', 'background-color:#eaa600;color:white;', 5],
            ['Assigned to Associate Editor', '008', 'background-color:#6a5acd; color: white;', 5],
            ['Returned to Chief Editor', '009', 'background-color:#46505d;', 5],
            ['Sent to Reviewers', '010', 'background-color:#f5ac81; color:black;', 30],

            ['Publication Process', '011', 'background-color:#b5e95d; color:white;', 5],
            ['Cancelled Submission', '012', 'background-color:#f52981; color:white;', 5],
            ['Pending for Publication', '013', 'background-color:#ffb999; color:black;', 5],

            ['Published', '014', 'background-color:#46c747; color:white;', 5],
            ['Not Accepted', '015', 'background-color:#ea0000; color:white;', 5],
            ['Returned with Reviewer Comments', '016', 'background-color:#641e16;color:white;', 5],

            ['On Production', '018', 'background-color: #2e86c1;color:white;', 5],
            ['Minor Revisions', '019', 'background-color: #2e86c1;color:white;', 5],
            ['Major Revisions', '020', 'background-color: #2e86c1;color:white;', 5],
        );

        
        foreach($statuses as $status){
            $data = ArticleStatus::create([
                'name' => $status[0],
                'code' => $status[1],
                'color' => $status[2],
                'max_days' => $status[3],
            ]);
        }
    }
}
