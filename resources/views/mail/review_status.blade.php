<br>
    @php
        $author = $record->author->first_name.' '.$record->author->middle_name.' '.$record->author->last_name
    @endphp

    {!! 
        str_replace('[email address] or [phone number]', $record->journal->email,
        str_replace('[Manuscript ID]', $record->paper_id,
        str_replace('[Title of the Paper]', $record->title, 
        str_replace('[AuthorsName]', $author, 
        str_replace('[Journal Name]', $record->journal->title, $review_message->description)))))
    !!}
<br>

@if(in_array($record->article_status->code, ['019','020']))
    @if($comments != '')
        <b>OTHER COMMENTS FROM EDITOR</b>
        <br>
        {!! $comments !!}
        <br>
        <br>
    @endif


    <b>REVIEWER(S)' COMMENTS TO AUTHOR</b>
    <br>

    @foreach($reviewers as $key => $reviewer)

    <p style="font-weight: bold; width: 100%; background-color: #BEBEBE; padding: 5px">Reviewer {{ $key + 1 }}</p>

    @foreach ($sections as $section)
        @foreach($section->reviewSectionQuery()->where('confidential', 0)->get() as $query)
            <p style="font-weight: bold; width: 100%;">{{ $query->title }}</p>
            <div>{!! $query->article_review()->where('article_id', $record->id)->where('user_id', $reviewer->user->id)->where('comment', '!=', '')->first()?->comment !!}</div>
        @endforeach
    @endforeach
    <br>
    <br>

    @endforeach
@endif


DEADLINE: 03-May-2025. If you need additional time to complete your revision please visit our Online Submission System to apply for an extension. Please note that the deadline expires at the start of the day and not the end of the day.

<br>

To go straight to your paper, click this link: 
<a href="https://journals.ifm.ac.tz/journal/detail/{{ $record->journal->uuid }}">https://journals.ifm.ac.tz/journal/detail/{{ $record->journal->uuid }}.</a>


