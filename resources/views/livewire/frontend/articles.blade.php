<div class="w-full">
    <div class="bg-gray-800 text-white bg-blend-overlay" style="background-image: url({{ asset('images/auth-image.jpg') }}); background-position: top;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-2 ">
                
                <div class="col-span-10 w-full mb-2 mt-2">
                    <p class="text-4xl font-bold">
                        {{ __($record->journal->title) }} ({{ strtoupper($record->journal->code) }})
                    </p>

                    <br>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">ISSN </p>
                        <p class="col-span-11">: {{ $record->journal->issn }}</p>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">EISSN </p>
                        <p class="col-span-11">: {{ $record->journal->eissn }}</p>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">EMAIL </p>
                        <p class="col-span-11">: {{ $record->journal->email }}</p>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">CREATED </p>
                        <p class="col-span-11">: {{ $record->journal->created_at }}</p>
                    </div>

                    <br>
                    <hr>

                    <div class="w-full text-justify mt-4 mb-4">
                        {!! $record->journal->description !!}
                    </div>

                    
                </div>
                <div class="col-span-2">
                    @if($record->journal->image == '')
                    <div class="p-2">
                        <svg class="w-full text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/>
                        </svg>
                    </div>
                    @else
                        <img class="w-full rounded-md rounded-bl-md mt-4" src="{{ asset('storage/journals/'.$record->journal->image) }}" alt="{{ strtoupper($record->journal->code) }}">
                    @endif

                    <a href="{{ route('journals.submission', $record->journal->uuid) }}">
                        <x-button class="mb-4 mt-2 w-full">Submit a Paper </x-button>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="border-b bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-lg font-bold py-4 mb-4">{{ __($record->journal->title) }} ({{ strtoupper($record->journal->code) }}) : {{ $record->volume->description }}, {{ $record->description }}</div>
        </div>
    </div>

    <div class="border-gray-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
 
            <div class="mt-4">
                @if($record?->editorial_file != '' && Storage::exists('editorial/'.$record?->editorial_file))
                    <div class="bg-white hover:shadow-lg cursor-pointer p-4 border rounded-lg mb-4 mt-4 shadow grid grid-cols-12 ">
                        <div class="col-span-10">
                            <div class="text-xl font-bold hover:underline hover:text-blue-600">
                                <a href="{{ route('journal.editorial', $record->uuid) }}">
                                    Editorial
                                </a>
                            </div>
                            <div>
                                {!! Str::limit(strip_tags($record->editorial), 250) !!}
                            </div>
                        </div>
                        <div class="col-span-2 border-l p-4">
                            <div class="flex gap-1 items-center hover:underline">
                                <svg class="w-8 h-8 text-blue-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 17v-5h1.5a1.5 1.5 0 1 1 0 3H5m12 2v-5h2m-2 3h2M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m6 4v5h1.375A1.627 1.627 0 0 0 14 15.375v-1.75A1.627 1.627 0 0 0 12.375 12H11Z"/>
                                </svg>
                                <span class=" text-blue-700 font-semibold">
                                    <a href="{{ route('journal.editorial_download', $record->uuid) }}" >
                                    PDF
                                    @if(Storage::exists('editorial/'.$record?->manuscript_file))({{ round((Storage::size('editorial/'.$record?->editorial_file) / 1048576), 2) }} MB)@endif
                                    </a>
                                </span>
                            </div>
        
                            <br>
                            <span class="text-xs text-gray-500 font-bold ml-1">DOWNLOADS</span>
                            <div class="flex gap-1 items-center">
                                <svg class="h-8 w-8 text-blue-700"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M14 3v4a1 1 0 0 0 1 1h4" />  <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />  <line x1="12" y1="11" x2="12" y2="17" />  <polyline points="9 14 12 17 15 14" /></svg>
                                <span class="text-xl text-blue-700 font-semibold">{{ $record?->editorial_downloads }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            @if ($articles->count() > 0)
            @foreach ($articles as $key => $article)
            
            <div class="bg-white hover:shadow-lg cursor-pointer p-4 border rounded-lg mb-4 mt-4 shadow grid grid-cols-12 ">
                <div class="col-span-10">
                    <div class="text-xl font-bold hover:underline hover:text-blue-600">
                        <a href="{{ route('journal.article', $article->uuid) }}">
                        {{ $article->title }}
                        </a>
                    </div>

                    <div class="text-sm text-blue-700 font-semibold hover:text-blue-600 mb-2">
                        @if($article->user_id == 1)
                            @foreach ($article->co_authors()->whereNotNull('first_name')->get() as $co_author)
                            <span class="hover:text-blue-600 hover:underline cursor-pointer mr-2">{{ $co_author->last_name }}, {{ strtoupper(substr($co_author->first_name, 0, 1)) }}.</span>
                            @endforeach
                        @else
                            @foreach ($article?->article_journal_users()->whereHas('roles', function($query){ $query->where('name', 'Author');})->get() as $key => $article_user)
                                {{ $article_user->user->first_name }} {{ $article_user->user->middle_name }} {{ $article_user->user->last_name }},
                            @endforeach
                        @endif
                    </div>
                    <div>
                        {!! Str::limit(strip_tags($article->abstract), 250) !!}
                    </div>
                    
                    <div class="w-full text-xs text-gray-500 mt-4">
                        {{ $article->publication_date }}
                    </div>
                </div>
                <div class="col-span-2 border-l p-4">
                    <div class="flex gap-1 items-center hover:underline">
                        <svg class="w-8 h-8 text-blue-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 17v-5h1.5a1.5 1.5 0 1 1 0 3H5m12 2v-5h2m-2 3h2M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m6 4v5h1.375A1.627 1.627 0 0 0 14 15.375v-1.75A1.627 1.627 0 0 0 12.375 12H11Z"/>
                        </svg>
                        <span class=" text-blue-700 font-semibold">
                            <a href="{{ route('journal.article_download', $article->uuid) }}" >
                            PDF
                            @if(Storage::exists('publications/'.$article?->manuscript_file))({{ round((Storage::size('publications/'.$article?->manuscript_file) / 1048576), 2) }} MB)@endif
                            </a>
                        </span>
                    </div>

                    <br>
                    <span class="text-xs text-gray-500 font-bold ml-1">DOWNLOADS</span>
                    <div class="flex gap-1 items-center">
                        <svg class="h-8 w-8 text-blue-700"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M14 3v4a1 1 0 0 0 1 1h4" />  <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />  <line x1="12" y1="11" x2="12" y2="17" />  <polyline points="9 14 12 17 15 14" /></svg>
                        <span class="text-xl text-blue-700 font-semibold">{{ $article?->downloads }}</span>
                    </div>
                </div>
            </div>
                
            @endforeach

            <div class="mt-4 w-full">
                {{ $articles->links() }}
            </div>
            @else
            
                <div class="w-full bg-blue-400 rounded shadow p-2">No Articles Found</div>

            @endif
        </div>
    </div>
</div>