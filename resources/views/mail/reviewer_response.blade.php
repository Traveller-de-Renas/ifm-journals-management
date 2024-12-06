@php
    $reviewr = $record->article_users()->wherePivot('role', 'reviewer')->first();
    $editor  = $record->journal->journal_users()->where('role', 'editor')->first();
@endphp
Hello, <b>{{ $editor->salutation?->title }}. {{ $editor->last_name }}</b>
<br>
<br>
This is a review response for the article: <b>{{ $record->title }}</b>
<br>
Paper Submitted in the Journal: <b>{{ $record->journal->title }}</b>

<br>
<br>

{!! $description !!}
<br>
From the reviewer: <b>{{ $reviewr->salutation?->title }}. {{ $reviewr->last_name }}</b>
<br>
<br>
<br>
<br>

<b>
    This is auto reply email from the reviewer. 
    <br>
    Please do not reply to this email.
    <br>
    Regards,
</b>