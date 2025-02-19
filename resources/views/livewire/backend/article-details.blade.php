<div class="bg-white shadow-md p-4 rounded">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="w-full flex text-lg mt-8">
            <p class="underline mr-1 cursor-pointer">
                <a href="{{ route('journal.detail', $record?->journal->uuid) }}">
                {{ $record?->journal->title }}
                </a>
            </p>
            @if ($record->issue?->volume?->description)
                <p class="mr-1"> > </p> 
                <p class="underline mr-1 cursor-pointer"> {{ $record->issue?->volume?->description }} </p>
            @endif

            @if ($record->issue?->description)
                <p class="mr-1"> > </p>
                <p class="underline mr-1 cursor-pointer"> {{ $record->issue?->description }} </p>
            @endif

        </div>
        
        <p class="text-2xl font-bold mt-4 mb-4">
            {{ __($record->title) }}
        </p>

        <p> ISSN : {{ $record?->journal->issn }} </p>

        <div class="mt-6 mb-6">
            @foreach ($record->article_journal_users()->orderBy('number', 'ASC')->get() as $key => $article_user)
            <span class="hover:text-blue-600 hover:underline cursor-pointer mr-2">

                @if($article_user->user->salutation) {{ $article_user->user->salutation?->title }}. @endif
            
                {{ $article_user->user->last_name }}, {{ strtoupper(substr($article_user->user->first_name, 0, 1)) }}.
                
                @if($article_user->user->affiliation) ({{ $article_user->user->affiliation }}) @endif

            </span>
            @endforeach 

            <p class="text-sm text-gray-400">Aticle Submission Date : {{ \Carbon\Carbon::parse($record->submission_date)->format('d-m-Y') }} </p>

            @if($record->article_status->code == '014')
                <p class="text-sm text-gray-400">Aticle Publication Date : {{ \Carbon\Carbon::parse($record->publication_date)->format('d-m-Y') }}</p>
            @endif
        </div>

    </div>

    <hr>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        <div class="w-full mb-8">
            <p class="text-lg font-bold mb-2">Abstract</p>
            <div class="w-full text-justify mb-4">
                {!! $record->abstract !!}
            </div>
        </div>

        <div class="w-full mb-8 grid grid-cols-12 gap-2">
            <div class="col-span-8">

                @if($record->keywords != '')
                <div class="w-full mb-4">
                    <p class="text-lg font-bold mb-4">Keywords</p>
                    <div class="flex gap-2">
                        @php
                            $keywords = explode(',', $record->keywords);
                        @endphp
                        @foreach ($keywords as $key => $keyword)
                            <span class="shadow px-4 py-2 hover:bg-gray-100 cursor-pointer border rounded-xl"> {{ $keyword }} </span>
                        @endforeach
                    </div>
                </div>
                @endif

                @php
                    $coauthors = $record->article_journal_users()->get()
                @endphp

            </div>
        </div>

        <div class="w-full mb-8 grid grid-cols-12 gap-2">
            <div class="col-span-12">

                <div class="w-full mb-4">
                    <p class="text-lg font-bold mb-4">Manuscript Documents</p>
                    @if(!empty($record?->files))
                        @foreach ($record?->files as $key => $file)
                            <div class="grid grid-cols-12  bg-gray-200 rounded-lg ">
                                <div class="col-span-3 items-center  p-2 px-4">
                                    {{ $file->file_category->name }}
                                </div>

                                <div class="col-span-8 p-2 px-4">
                                    <a href="{{ asset('storage/articles/'.$file->file_path) }}"><span class="font-bold text-blue-500 hover:text-blue-700 cursor-pointer ml-4">{{ $file->file_description }}</span></a>
                                </div>
                                
                                <div class="col-span-1 p-2 px-4">
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                @php
                    $coauthors = $record->article_journal_users()->get()
                @endphp

            </div>
        </div>

        @if($record->article_status->code == '014')
        <div class="w-full mb-8 grid grid-cols-12 gap-2">
            <div class="col-span-8">
                <p class="text-lg font-bold">Citation</p>
                <span class="hover:text-blue-600 hover:underline cursor-pointer">{{ $record->author->last_name }}, {{ strtoupper(substr($record->author->first_name, 0, 1)) }}.
                </span>
                @foreach ($coauthors as $key => $user)
                    <span class="hover:text-blue-600 hover:underline cursor-pointer">{{ $user->last_name }}, {{ strtoupper(substr($user->first_name, 0, 1)) }}.  </span>
                @endforeach

                ({{ \Carbon\Carbon::parse($record->publication_date)->format('Y') }}),

                "{{ __($record->title) }}",

                <span class="font-bold italic hover:text-blue-600 hover:underline cursor-pointer"><a href="{{ route('journal.detail', $record?->journal->uuid) }}">{{ __($record->journal?->title) }}</a></span>,
                {{ $record->issue?->volume->description }}, {{ $record->issue?->description }}, {{ $record->issue?->volume->journal->issn }}. {{ $record->issue?->volume->journal->doi }}
            </div>
        </div>
        @endif
    </div>

</div>