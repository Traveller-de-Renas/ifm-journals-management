<br>
    @php
        $reviewer = $user->user->first_name.' '.$user->user->middle_name.' '.$user->user->last_name
    @endphp

    {!! 
        str_replace('[email address] or [phone number]', $record->journal->email,
        str_replace('[Manuscript Evaluation Form]', '<a href="'.route('journal.article_evaluation', [$record->uuid, $user->user->uuid]).'" ><u>'.$record->title.'</u></a>',
        str_replace('[ReviewersName]', $reviewer,
        str_replace('[Title of the Paper]', $record->title, 
        str_replace('[Journal Name]', $record->journal->title, $review_message->description)))))
    !!}
<br>