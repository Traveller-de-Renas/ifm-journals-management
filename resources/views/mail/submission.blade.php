<br>
    @php
        $author = $record->author->first_name.' '.$record->author->middle_name.' '.$record->author->last_name
    @endphp

    {!! 
        str_replace('[email address] or [phone number]', $record->journal->email,
        str_replace('[Manuscript ID]', $record->paper_id,
        str_replace('[Title of the Paper]', $record->title, 
        str_replace('[AuthorsName]', $author, 
        str_replace('[Journal UUID]'), $record->journal->uuid,
        str_replace('[Journal Name]', $record->journal->title, $review_message->description)))))
    !!}
<br>
