
Hello, <b>{{ $user->salutation?->title }}. {{ $user->last_name }}</b>
<br>
<br>
Your request to enroll on the Journal: <b>{{ $record->title }}</b>
<br>
<br>

Please confirm enrollment by Clicking on this link : <a href="{{ route('journals.enrollment_confirmation', [$record->uuid, $user->uuid]) }}" ><u>{{ $record->title }}</u></a>
<br>
we expect you will reach out to us if you have any questions or concerns. 
<br>
<br>

<b>
From chief Editor of the Journal Editorial Board.
<br>
Regards,
<br>
{{ $record->chief_editor->salutation?->title }}. {{ $record->chief_editor->first_name }} {{ $record->chief_editor->middle_name }} {{ $record->chief_editor->last_name }}
</b>