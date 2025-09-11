<br>
{!!
    str_replace('[ReviewersName]', $journal_user->user->first_name.' '.$journal_user->user->middle_name.' '.$journal_user->user->last_name.' <br>'.$remarks,
    str_replace('[Article Status]', ucfirst($article_journal_user->pivot->review_status),
    str_replace('[Manuscript ID]', '<strong>'.$record->paper_id.'</strong>',
    str_replace('[Title of the Paper]', '<strong>'.$record->title.'</strong>',
    str_replace('[Journal Name]', '<strong>'.$record->journal->title.'-'.$record->journal->code.'</strong>', $review_message->description)))))
!!}
<br>