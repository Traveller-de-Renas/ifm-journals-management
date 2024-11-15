Hello, <b>{{ $record->editors()->first()->salutation?->title }}. {{ $record->editors()->first()->last_name }}</b>
<br>
You have been assigned to review the article: <b><h4>{{ $record->title }}<h4></b><br>
Submited in the Journal: <b><h5>{{ $record->journal->title }}</h5></b>
<br>
<br>

From chief Editor of the Journal Editorial Board.
<br>
Regards,
<br>
{{ $record->journal->chief_editor->salutation?->title }} {{ $record->journal->chief_editor->first_name }} {{ $record->journal->chief_editor->middle_name }} {{ $record->journal->chief_editor->last_name }}