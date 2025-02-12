<div class="w-full">
    <div class="bg-gray-800 text-white py-12 bg-blend-overlay" style="background-image: url({{ asset('images/auth-image.jpg') }}); background-position: top;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="w-full flex text-lg">
                <p class="underline mr-1 cursor-pointer hover:text-gray-500">
                    <a href="{{ route('journal.detail', $record?->journal->uuid) }}">
                    {{ $record?->journal->title }}
                    </a>
                </p>
                @if ($record->issue?->volume?->description)
                    <p class="mr-1"> > </p> 
                    <p class="underline mr-1 cursor-pointer hover:text-gray-500"> {{ $record->issue?->volume?->description }} </p>
                @endif

                @if ($record->issue?->description)
                    <p class="mr-1"> > </p>
                    <p class="underline mr-1 cursor-pointer hover:text-gray-500"> {{ $record->issue?->description }} </p>
                @endif

            </div>
            
            <p class="text-white text-3xl font-bold mt-4 mb-4">
                {{ __($record->title) }}
            </p>

            <a href="{{ route('journal.detail', $record?->journal->uuid) }}">
                <p class="text-xl text-gray-300">{{ $record?->journal->title }}</p>
            </a>

            <p> ISSN : {{ $record?->journal->issn }} </p>

            <div class="mt-6 mb-6">
                @if($record->user_id == 1)
                    @foreach ($record->co_authors()->whereNotNull('first_name')->get() as $co_author)
                    <span class="hover:text-blue-600 hover:underline cursor-pointer mr-2">{{ $co_author->last_name }}, {{ strtoupper(substr($co_author->first_name, 0, 1)) }}.</span>
                    @endforeach
                @else
                <span class="hover:text-blue-600 hover:underline cursor-pointer">
                    @if($record->author->salutation) {{ $record->author->salutation?->title }}. @endif
                    
                    {{ $record->author->last_name }}, {{ strtoupper(substr($record->author->first_name, 0, 1)) }}.
                    
                    @if($record->author->affiliation) ({{ $record->author->affiliation }}) @endif
                </span>
                @endif

                <p class="text-lg text-gray-400 font-bold">Aticle Publication Date : {{ \Carbon\Carbon::parse($record->publication_date)->format('d-m-Y') }} </p>
            </div>

        </div>
    </div>

    <div class="border-b bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
            <div class="flex items-center">
                <a href="{{ route('journal.article_download', $record->uuid) }}" >
                    <div class="flex items-center text-blue-700 hover:text-blue-600 cursor-pointer">
                        <img src="{{ asset('storage/favicon/pdf.png') }}" class="h-5"> <p class="ml-2 text-lg font-bold">Download Article @if(Storage::exists('publications/'.$record?->manuscript_file))({{ round((Storage::size('publications/'.$record?->manuscript_file) / 1048576), 2) }} MB)@endif</p>
                    </div>
                </a>
                <p class="ml-2 text-lg text-gray-600 font-bold">{{ $record?->downloads ?? 0 }} Downloads </p>
            </div>
        </div>
    </div>

    <hr>


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">

        <div class="w-full mb-12">
            <p class="text-lg font-bold mb-2">Abstract</p>
            <div class="w-full text-justify mb-4">
                {!! $record->abstract !!}
            </div>
        </div>

        <div class="w-full mb-12 grid grid-cols-12 gap-2">
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

        <div class="w-full mb-12 grid grid-cols-12 gap-2">
            <div class="col-span-8">
                <p class="text-lg font-bold">Citation</p>
                @if($record->user_id == 1)
                    @foreach ($record->co_authors()->whereNotNull('first_name')->get() as $co_author)
                    <span class="hover:text-blue-600 hover:underline cursor-pointer mr-2">{{ $co_author->last_name }}, {{ strtoupper(substr($co_author->first_name, 0, 1)) }}.</span>
                    @endforeach
                @else
                    <span class="hover:text-blue-600 hover:underline cursor-pointer">{{ $record->author->last_name }}, {{ strtoupper(substr($record->author->first_name, 0, 1)) }}.
                    </span>
                    @foreach ($coauthors as $key => $user)
                        <span class="hover:text-blue-600 hover:underline cursor-pointer">{{ $user->last_name }}, {{ strtoupper(substr($user->first_name, 0, 1)) }}.  </span>
                    @endforeach
                @endif

                ({{ \Carbon\Carbon::parse($record->publication_date)->format('Y') }}),

                "{{ __($record->title) }}",

                <span class="font-bold italic hover:text-blue-600 hover:underline cursor-pointer"><a href="{{ route('journal.detail', $record?->journal->uuid) }}">{{ __($record->journal?->title) }}</a></span>,
                {{ $record->issue?->volume->description }}, {{ $record->issue?->description }}, {{ $record->issue?->volume->journal->issn }}. {{ $record->issue?->volume->journal->doi }}
            </div>
        </div>
    </div>

</div>