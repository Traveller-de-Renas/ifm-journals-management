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
                <span class="hover:text-blue-600 hover:underline cursor-pointer">
                    @if($record->author->salutation) {{ $record->author->salutation?->title }}. @endif
                    
                    {{ $record->author->last_name }}, {{ strtoupper(substr($record->author->first_name, 0, 1)) }}.
                    
                    @if($record->author->affiliation) ({{ $record->author->affiliation }}) @endif
                </span>

                <p class="text-lg text-gray-400 font-bold">Aticle Publication Date : {{ date("Y-m-d") }} </p>
            </div>

        </div>
    </div>


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 mb-8">
        @php
            $file = $record->files()->where('publish', 1)->first();
        @endphp
        <div class="flex items-center">
            <a href="{{ route('journal.article_download', $file?->id) }}" >
                <div class="flex items-center text-blue-700 hover:text-blue-600 cursor-pointer">
                    <img src="{{ asset('storage/favicon/pdf.png') }}" class="h-5"> <p class="ml-2 text-lg font-bold">Download Article @if(!empty($file)) {{ Storage::size('storage/articles/'.$file?->file) }} @endif</p>
                </div>
            </a>
            <p class="ml-2 text-lg text-gray-600 font-bold">{{ $file?->downloads ?? 0 }} Downloads </p>
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
                    $coauthors = $record->article_users()->wherePivot('role', '<>', 'reviewer')->get()
                @endphp

                {{-- @if(count($coauthors) > 0)
                <div class="w-full mb-4">
                    <p class="text-lg font-bold">Co Authors</p>
                    <div class="text-sm text-blue-700 hover:text-blue-600 cursor-pointer mb-2 mt-2">
                        @foreach ($coauthors as $key => $user)
                        <div class="flex items-center">
                            {{ $user->salutation?->title }} {{ $user->first_name }} ({{ $user->affiliation }})
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif --}}

            </div>
        </div>


        <div class="w-full mb-12 grid grid-cols-12 gap-2">
            <div class="col-span-8">
                <p class="text-lg font-bold">Citation</p>
                <span class="hover:text-blue-600 hover:underline cursor-pointer">{{ $record->author->salutation?->title }} {{ $record->author->last_name }}, {{ strtoupper(substr($record->author->first_name, 0, 1)) }}.
                </span>
                @foreach ($coauthors as $key => $user)
                    <span class="hover:text-blue-600 hover:underline cursor-pointer"> {{ $user->salutation?->title }} {{ $user->last_name }}, {{ strtoupper(substr($user->first_name, 0, 1)) }}.  </span>
                @endforeach

                ({{ \Carbon\Carbon::parse($record->publication_date)->format('Y') }}),

                "{{ __($record->title) }}",

                <span class="font-bold italic hover:text-blue-600 hover:underline cursor-pointer"><a href="{{ route('journal.detail', $record?->journal->uuid) }}">{{ __($record->journal?->title) }}</a></span>,
                {{ $record->issue?->volume->description }}, {{ $record->issue?->description }}, {{ $record->issue?->volume->journal->issn }}. {{ $record->issue?->volume->journal->doi }}
            </div>
        </div>
    </div>

</div>