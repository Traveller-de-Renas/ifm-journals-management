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


    @foreach ($sections as $key => $sub_sections)
        <div class="p-3 bg-[#175883] text-white ">
            {{ $sub_sections->title }}
        </div>

        @foreach ($sub_sections->reviewSections as $skey => $section)
            @foreach($section->reviewSectionsComment()->where('user_id', $reviewer->user->id)->get() as $comment)
                <div class="text-justify">
                    {{ $comment->comment }}
                </div>
            @endforeach
        @endforeach
    @endforeach
    
    <br>
    <br>

    @endforeach
@endif




