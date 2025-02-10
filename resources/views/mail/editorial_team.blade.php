<br>
    @php
        $recipient = $user->user->first_name.' '.$user->user->middle_name.' '.$user->user->last_name;
    @endphp

    {!!
        str_replace('[RecipientName]', $recipient, 
        str_replace('[Journal Name]', $journal->title, $review_message->description))
    !!}
<br>