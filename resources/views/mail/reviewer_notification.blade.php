Hello, <b>{{ $record->editors()->first()->salutation?->title }}. {{ $record->editors()->first()->last_name }}</b>
<br>
We are requesting your review for the article: <b><h4>{{ $record->title }}<h4></b><br>
Submited in the Journal: <b><h5>{{ $record->journal->title }}</h5></b>
<br>
<br>
Please find the Review Link / Evaluation Form, Click on the link to access the form : <a href="{{ route('journals.article_evaluation', [$record->uuid, $user->uuid]) }}" ><u>{{ $record->title }}</u></a>
we expect you will reach out to us if you have any questions or concerns. 
<br>
<br>
From chief Editor of the Journal Editorial Board.
<br>
Regards,
<br>
{{ $record->journal->chief_editor->salutation?->title }} {{ $record->journal->chief_editor->first_name }} {{ $record->journal->chief_editor->middle_name }} {{ $record->journal->chief_editor->last_name }}