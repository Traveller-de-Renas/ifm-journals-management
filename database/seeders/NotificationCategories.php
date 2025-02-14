<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationCategories extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = array(
            array('name'=>"Journal Account", 'description'=>'Journal Account', 'code'=>'001'),
            array('name'=>"Submission", 'description'=>'Submission', 'code'=>'002'),
            array('name'=>"Article Revisions", 'description'=>'Article Revisions', 'code'=>'003'),
            array('name'=>"Article Rejection", 'description'=>'Article Rejection', 'code'=>'004'),
            array('name'=>"Article Assignment", 'description'=>'Article Assignment', 'code'=>'005'),
            array('name'=>"Review Request", 'description'=>'Review Request', 'code'=>'006'),
            array('name'=>"Review Reminder", 'description'=>'Review Reminder', 'code'=>'007'),
            array('name'=>"Acceptance Letter", 'description'=>'Acceptance Letter', 'code'=>'008'),
            array('name'=>"Completed Review", 'description'=>'Completed Review', 'code'=>'009'),
            array('name'=>"Declined Review", 'description'=>'Declined Review', 'code'=>'010'),
            array('name'=>"Call for Papers", 'description'=>'Call for Papers', 'code'=>'011'),
            array('name'=>"Assign Chief Editor", 'description'=>'Assign Chief Editor', 'code'=>'012'),
            array('name'=>"Add Associate Editor", 'description'=>'Add Associate Editor', 'code'=>'013'),
            array('name'=>"Add Supporting Editor", 'description'=>'Add Supporting Editor', 'code'=>'014'),
            array('name'=>"Access Credentials", 'description'=>'Access Credentials', 'code'=>'015'),
            array('name'=>"Account Activation", 'description'=>'Account Activation', 'code'=>'016')
        );

        foreach($notifications as $notification){
            \App\Models\NotificationCategory::create([
                'name'        => $notification['name'],
                'description' => $notification['description'],
                'code'        => $notification['code']
            ]);
        }
        
    }
}
