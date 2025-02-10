<br>
    {!! 
        str_replace("[RecipientName]", $user->user->first_name.' '.$user->user->middle_name.' '.$user->user->last_name, 
        str_replace('[link to submission portal]', '<a href="'.route('login', $journal->uuid).'" ><u>'.$journal->title.'</u></a>', 
        str_replace('[Journal Name]', $journal->title, 
        str_replace('[LoginUsername]', $user->user->email,
        str_replace('[LoginPassword]', $password, $review_message->description)))))
    !!}
<br>