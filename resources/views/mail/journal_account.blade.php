<br>
    {!! 
        str_replace("[AuthorsName]", $user->first_name.' '.$user->middle_name.' '.$user->last_name, 
        str_replace('[link to submission portal]', '<a href="'.route('login', $journal->uuid).'" ><u>'.$journal->title.'</u></a>', 
        str_replace('[Journal Name]', $journal->title, 
        str_replace('[email address] or [phone number]', $journal->email, $review_message->description))))
    !!}
<br>