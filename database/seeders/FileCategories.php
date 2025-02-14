<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FileCategories extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = array(
            array('name'=>"Title Page", 'description'=>'Title Page', 'code'=>'001', 'submitted'=>'submission'),
            array('name'=>"Anonymous Manuscript File", 'description'=>'Anonymous Manuscript File', 'code'=>'002', 'submitted'=>'submission'),
            array('name'=>"Title Page", 'description'=>'Title Page', 'code'=>'003', 'submitted'=>'resubmission'),
            array('name'=>"Revised Anonymous Manuscript File", 'description'=>'Revised Anonymous Manuscript File', 'code'=>'004', 'submitted'=>'resubmission'),
            array('name'=>"Reviewer Comments Matrix", 'description'=>'Reviewer Comments Matrix', 'code'=>'005', 'submitted'=>'resubmission'),
        );

        foreach($notifications as $notification){
            \App\Models\FileCategory::create([
                'name'        => $notification['name'],
                'description' => $notification['description'],
                'code'        => $notification['code'],
                'submitted'   => $notification['submitted']
            ]);
        }
    }
}
