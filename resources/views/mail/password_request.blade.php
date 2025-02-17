<br>
    {!! 
        str_replace("[RecipientName]", $user->first_name.' '.$user->middle_name.' '.$user->last_name, 
        str_replace('[Reset Password Link]', '<center><a href="'.route('password_reset', $prequest->uuid).'" ><b>RESET PASSWORD</b></a></center>', $review_message->description))
    !!}
<br>