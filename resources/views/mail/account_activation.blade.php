<br>
    {!! 
        str_replace("[RecipientName]", $user->first_name.' '.$user->middle_name.' '.$user->last_name, 
        str_replace('[Activation Link]', '<center><a href="'.route('account_activation', ['journal'=>$journal->uuid, 'user'=>$user->uuid]).'" ><b>ACTIVATE ACCOUNT</b></a></center>', 
        str_replace('[Journal Name]', $journal->title, $review_message->description)))
    !!}
<br>