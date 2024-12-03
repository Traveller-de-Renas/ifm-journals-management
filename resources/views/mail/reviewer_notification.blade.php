@php
    $user = $record->article_users()->wherePivot('role', 'reviewer')->first();
@endphp
Hello, <b>{{ $user->salutation?->title }}. {{ $user->last_name }}</b>
<br>
<br>
We are requesting your review on the article: <b>{{ $record->title }}</b>
<br>
Submited in the Journal: <b>{{ $record->journal->title }}</b>
<br>
<br>

Please find the Review Link / Evaluation Form, Click on the link to access the form : <a href="{{ route('journals.article_evaluation', [$record->uuid, $user->uuid]) }}" ><u>{{ $record->title }}</u></a>
<br>
we expect you will reach out to us if you have any questions or concerns. 
<br>
<br>

<b>
From chief Editor of the Journal Editorial Board.
<br>
Regards,
<br>
{{ $record->journal->chief_editor->salutation?->title }}. {{ $record->journal->chief_editor->first_name }} {{ $record->journal->chief_editor->middle_name }} {{ $record->journal->chief_editor->last_name }}
</b>