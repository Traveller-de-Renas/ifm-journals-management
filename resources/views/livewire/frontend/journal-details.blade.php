<div class="w-full">
    <div class="bg-gray-800 text-white bg-blend-overlay" style="background-image: url({{ asset('images/auth-image.jpg') }}); background-position: top;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-2 ">
                
                <div class="col-span-10 w-full mb-2 mt-2">
                    <p class="text-4xl font-bold">
                        {{ __($record->title) }} ({{ strtoupper($record->code) }})
                    </p>

                    <br>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">ISSN </p>
                        <p class="col-span-11">: {{ $record->issn }}</p>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">EISSN </p>
                        <p class="col-span-11">: {{ $record->eissn }}</p>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">EMAIL </p>
                        <p class="col-span-11">: {{ $record->email }}</p>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">CREATED </p>
                        <p class="col-span-11">: {{ $record->created_at }}</p>
                    </div>

                    <br>
                    <hr>

                    <div class="w-full text-justify mt-4 mb-4">
                        {!! $record->description !!}
                    </div>

                    
                </div>
                <div class="col-span-2">
                    @if($record->image == '')
                    <div class="p-2">
                        <svg class="w-full text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/>
                        </svg>
                    </div>
                    @else
                        <img class="w-full rounded-md rounded-bl-md mt-4" src="{{ asset('storage/journals/'.$record->image) }}" alt="{{ strtoupper($record->code) }}">
                    @endif

                    <a href="{{ route('login', $record->uuid) }}">
                        <x-button class="mb-4 mt-2 w-full">Submit a Paper </x-button>
                    </a>
                </div>

            </div>
        </div>
    </div>



<div class="border-b border-gray-200 bg-white">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
            <li class="me-2">
                <button class="font-bold inline-flex items-center justify-center p-4 rounded-t-lg hover:text-gray-600 group border-b-2 @if($tab == 'overview') border-blue-600 @else border-transparent hover:border-gray-300 @endif " wire:click="changeTab('overview')">
                    Overview
                </button>
            </li>
            <li class="me-2">
                <button class="font-bold inline-flex items-center justify-center p-4 rounded-t-lg hover:text-gray-600 group border-b-2 @if($tab == 'table_of_contents') border-blue-600 @else border-transparent hover:border-gray-300 @endif " wire:click="changeTab('table_of_contents')">
                    Table of Contents
                </button>
            </li>
            <li class="me-2">
                <button class="font-bold inline-flex items-center justify-center p-4 rounded-t-lg hover:text-gray-600 group border-b-2 @if($tab == 'author_guidelines') border-blue-600 @else border-transparent hover:border-gray-300 @endif " wire:click="changeTab('author_guidelines')">
                    Author Guidelines
                </button>
            </li>
            <li class="me-2">
                <button class="font-bold inline-flex items-center justify-center p-4 rounded-t-lg hover:text-gray-600 group border-b-2 @if($tab == 'editorial_board') border-blue-600 @else border-transparent hover:border-gray-300 @endif " wire:click="changeTab('editorial_board')">
                    Editorial Team
                </button>
            </li>
            {{-- <li class="me-2">
                <button class="font-bold inline-flex items-center justify-center p-4 rounded-t-lg hover:text-gray-600 group border-b-2 @if($tab == 'reviewer_information') border-blue-600 @else border-transparent hover:border-gray-300 @endif " wire:click="changeTab('reviewer_information')">
                    Reviewer Information
                </button>
            </li> --}}
            <li class="me-2">
                <button class="font-bold inline-flex items-center justify-center p-4 rounded-t-lg hover:text-gray-600 group border-b-2 @if($tab == 'calls_for_papers') border-blue-600 @else border-transparent hover:border-gray-300 @endif " wire:click="changeTab('calls_for_papers')">
                    Calls for Papers
                </button>
            </li>
        </ul>
    </div>
</div>


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">

        <div class="md:grid md:grid-cols-12 gap-4 w-full ">

            <div class="col-span-8">
                <div class="w-full mb-4 @if($tab != 'overview') hidden @endif">

                    <div class="w-full mb-4">
                        <p class="text-lg font-bold mb-2">Aim and Scope</p>
                        <div class="text-justify mb-6">
                            {!! $record->scope !!}
                        </div>


                        <p class="text-lg font-bold mb-2 mt-6">Call for Papers</p>
                        <div class="mb-6">
                            @foreach ($record->call_for_papers as $call)
                                <div class="bg-white shadow-md mb-2">
                                    <div class="p-2 text-xs">
                                        <span class="font-semibold">CLOSES ON</span> : <span class="text-gray-500">{{ \Carbon\Carbon::parse( $call->end_date)->format('d M Y') }}</span>
                                    </div>
                                    <div class="p-2 border-b border-t">

                                        <p class="font-semibold hover:text-blue-600">
                                            <a href="{{ route('journal.call_detail', $call->uuid) }}">{{ $call->title }}</a>
                                        </p>
                                        
                                        <div class="mt-2 text-xs text-gray-500 text-justify">
                                            {!! Str::limit(strip_tags($call->description), 250) !!}
                                        </div>
                                    </div>
                                    <div class="p-2">

                                    </div>
                                </div>
                            @endforeach
                        </div>


                        <p class="text-lg font-bold mb-2">Current Issue <span class="text-gray-500 font-semibold text-sm">{{ $cissue->volume->description.' '.$cissue->description }}</span></p>
                        
                        @if ($cissue->articles->count() > 0)
                        @foreach ($cissue->articles as $key => $article)
                        
                        <div class="bg-white hover:shadow-lg cursor-pointer p-4 border rounded-lg mb-4 mt-4 shadow grid grid-cols-12 ">
                            <div class="col-span-9">
                                <div class="text-sm font-bold hover:underline hover:text-blue-600">
                                    <a href="{{ route('journal.article', $article->uuid) }}">
                                    {{ $article->title }}
                                    </a>
                                </div>
            
                                <div class="text-sm text-green-700 font-semibold hover:text-green-600 mb-2">
                                    @if($article->user_id == 1)
                                        @foreach ($article->co_authors()->whereNotNull('first_name')->get() as $co_author)
                                        <span class="hover:text-green-600 hover:underline cursor-pointer mr-2">{{ $co_author->last_name }}, {{ strtoupper(substr($co_author->first_name, 0, 1)) }}.</span>
                                        @endforeach
                                    @else
                                        @foreach ($article?->article_journal_users()->whereHas('roles', function($query){ $query->where('name', 'Author');})->get() as $key => $article_user)
                                            {{ $article_user->user->first_name }} {{ $article_user->user->middle_name }} {{ $article_user->user->last_name }},
                                        @endforeach
                                    @endif
                                </div>
                                <div class="text-xs">
                                    {!! Str::limit(strip_tags($article->abstract), 150) !!}
                                </div>
                                
                                <div class="w-full text-xs text-gray-500 mt-4">
                                    {{ $article->publication_date }}
                                </div>
                            </div>
                            <div class="col-span-3 border-l p-4">
                                <div class="flex gap-1 items-center hover:underline mb-2">
                                    <svg class="w-6 h-6 text-blue-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 17v-5h1.5a1.5 1.5 0 1 1 0 3H5m12 2v-5h2m-2 3h2M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m6 4v5h1.375A1.627 1.627 0 0 0 14 15.375v-1.75A1.627 1.627 0 0 0 12.375 12H11Z"/>
                                    </svg>
                                    <span class=" text-blue-700 font-semibold">
                                        <a href="{{ route('journal.article_download', $article->uuid) }}" >
                                        PDF
                                        @if(Storage::exists('publications/'.$article?->manuscript_file))({{ round((Storage::size('publications/'.$article?->manuscript_file) / 1048576), 2) }} MB)@endif
                                        </a>
                                    </span>
                                </div>
            
                                
                                <span class="text-xs text-gray-500 font-bold ml-1">DOWNLOADS</span>
                                <div class="flex gap-1 items-center">
                                    <svg class="h-6 w-6 text-blue-700"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M14 3v4a1 1 0 0 0 1 1h4" />  <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />  <line x1="12" y1="11" x2="12" y2="17" />  <polyline points="9 14 12 17 15 14" /></svg>
                                    <span class="text-xl text-blue-700 font-semibold">{{ $article?->downloads }}</span>
                                </div>
                            </div>
                        </div>
                            
                        @endforeach
                        @else
                        
                            <div class="w-full bg-blue-400 rounded shadow p-2">No Articles Found</div>
            
                        @endif
                        
                    </div>

                </div>

                <div class="w-full mb-4 @if($tab != 'table_of_contents') hidden @endif">

                    <div class="w-full mb-2">

                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
                            <li class="me-2">
                                <button class="font-bold inline-flex items-center justify-center p-4 rounded-t-lg hover:text-gray-600 group border-b-2 @if($subtab == 'all_issues') border-blue-600 @else border-transparent hover:border-gray-300 @endif " wire:click="changeSubTab('all_issues')">
                                    All Issues
                                </button>
                            </li>
                            <li class="me-2">
                                <button class="font-bold inline-flex items-center justify-center p-4 rounded-t-lg hover:text-gray-600 group border-b-2 @if($subtab == 'online_first') border-blue-600 @else border-transparent hover:border-gray-300 @endif " wire:click="changeSubTab('online_first')">
                                    Online First
                                </button>
                            </li>
                        </ul>



                        <div class="w-full mb-4 @if($subtab != 'all_issues') hidden @endif">

                            <div class="w-full mb-2">
                                @if ($record->volumes != '')
                                    @foreach ($record->volumes()->orderBy('number', 'DESC')->get() as $key => $volume)
                                    <div x-data="@if($key == 0){ open: true } @else { open: false } @endif" class="mt-4">
                                        <div class="border-b border-gray-200">
                                            <button
                                                @click="open = !open"
                                                class="w-full text-left p-4 flex items-center justify-between text-gray-800 font-medium hover:bg-gray-100 focus:outline-none"
                                            >

                                                <svg :class="{'rotate-90': open}" class="w-5 h-5 transform transition-transform"  width="24" height="24" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="9 6 15 12 9 18" /></svg>
                                                <span class="w-full text-lg font-semibold ml-2">{{ $volume->description }}</span>
                                                
                                            </button>
                                            <div x-show="open" x-transition class="p-2 text-gray-700">
                                                <ul class="list-disc list-inside">
                                                    @foreach ($volume->issues()->where('publication', 'Published')->orderBy('number', 'DESC')->get() as $key => $issue)
                                                    
                                                        <li class="ml-8 font-semibold">
                                                            <a href="{{ route('journal.articles', $issue->uuid) }}" >
                                                                <span class="hover:underline text-blue-700 hover:text-blue-500 cursor-pointer text-lg">{{ $issue->description }}</span> {{ \Carbon\Carbon::parse($issue->publication_date)->format('Y') }}
                                                            </a>
                                                        </li>

                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>

                        </div>


                        <div class="w-full mb-4 @if($subtab != 'online_first') hidden @endif">

                            <div class="w-full mb-2">

                                @php
                                    $online_first = $record->articles()->whereHas('article_status', function ($query) { 
                                        $query->where('code', '014'); 
                                    })->whereNull('issue_id')->get();
                                @endphp

                                @foreach ($online_first as $key => $article)
            
                                <div class="bg-white hover:shadow-lg cursor-pointer p-4 border rounded-lg mb-4 mt-4 shadow grid grid-cols-12 ">
                                    <div class="col-span-9">
                                        <div class="text-md font-bold hover:underline hover:text-blue-600">
                                            <a href="{{ route('journal.article', $article->uuid) }}">
                                            {{ $article->title }}
                                            </a>
                                        </div>
                    
                                        <div class="text-xs text-blue-700 hover:text-blue-600 mb-4">
                                            @foreach ($article?->article_journal_users()->whereHas('roles', function($query){ $query->where('name', 'Author');})->get() as $key => $article_user)
                                                {{ $article_user->user->first_name }} {{ $article_user->user->middle_name }} {{ $article_user->user->last_name }},
                                            @endforeach
                                        </div>
                                        <div class="text-xs">
                                            {!! Str::limit(strip_tags($article->abstract), 250) !!}
                                        </div>
                                        
                                        <div class="w-full text-xs text-gray-500 mt-4">
                                            {{ $article->publication_date }}
                                        </div>
                                    </div>
                                    <div class="col-span-3 border-l p-4">
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
                            </div>

                        </div>
    
                    </div>
                </div>

                <div class="w-full mb-4 @if($tab != 'author_guidelines') hidden @endif">
                    @if(!empty($record->instructions))
                    <div class="w-full mb-4">
                        <p class="text-lg font-bold mb-2">Authors' Guidelines</p>

                        @foreach ($record->instructions as $instruction)
                            <div class="rounded-sm border border-slate-200 mb-2" x-data="{ open: false }">
                                <div class="w-full p-2 cursor-pointer" @click.prevent="open = !open" :aria-expanded="open">
                                    <div class=" text-slate-800">{{ $instruction->title }}</div>
                                </div>
                                <div class="text-sm text-justify p-2" x-show="open" x-cloak="">
                                    {{ $instruction->description }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="w-full mb-4 @if($tab != 'editorial_board') hidden @endif">
                    <div class="w-full mb-4">
                        <p class="text-lg font-bold mb-2">Editorial Team</p>
    
                        <div class="w-full mt-2 mb-8">
                            @foreach ($record->journal_us()->whereHas('roles', function ($query) {
                                $query->whereIn('name', ['Supporting Editor', 'Chief Editor', 'Associate Editor']);
                            })->get() as $key => $j_user)
                        
                                <div class="w-full p-2 border bg-white hover:bg-gray-200 border-slate-200 cursor-pointer" wire:click="editorDetails({{ $key }})">
                                    <div class="font-semibold">
                                        {{ $j_user->user->salutation?->title }}
                                        {{ $j_user->user->first_name }}
                                        {{ $j_user->user->middle_name }}
                                        {{ $j_user->user->last_name }}

                                        <span class="text-sm font-light">
                                            {{ $j_user->user->affiliation != '' ? '('.$j_user->user->affiliation.')' : '' }}
                                        </span>
                                    </div>

                                    <div class="w-full flex text-xs">
                                        @if ($j_user->hasRole('Chief Editor'))
                                        {{ $record->email }}
                                        @endif
                                    </div>

                                    

                                    @if ($j_user->hasRole('Chief Editor'))
                                        <p class="text-xs text-green-900">Managing Editor</p>
                                    @elseif ($j_user->hasRole('Supporting Editor'))
                                        <p class="text-xs text-green-400">Supporting Editor</p>
                                    @elseif ($j_user->hasRole('Associate Editor'))
                                        <p class="text-xs text-blue-900">Associate Editor</p>
                                    @elseif ($j_user->hasRole('Advisory Board'))
                                        <p class="text-xs text-blue-400">Advisory Board</p>
                                    @endif
                                </div>
                            
                                <div class="p-2 text-sm border @if($key != $editor_detail) hidden @endif" >
                                    <div class="w-full flex">
                                        <div class="text-sm w-1/5 ">Affiliation</div>
                                        <div class="text-sm w-full">: {{ $j_user->user->affiliation }}</div>
                                    </div>
                                    <div class="w-full flex">
                                        <div class="text-sm w-1/5 ">Country</div>
                                        <div class="text-sm w-full">: {{ $j_user->user?->country?->name }}</div>
                                    </div>
                                    <div class="w-full flex">
                                        <div class="text-sm w-1/5">Degree</div>
                                        <div class="text-sm w-full">: {{ $j_user->user->degree }}</div>
                                    </div>
                                    <div class="w-full flex">
                                        <div class="text-sm w-1/5">Email</div>
                                        <div class="text-sm w-full">: {{ $j_user->user->email }}</div>
                                    </div>
                                    <div class="w-full flex">
                                        <div class="text-sm w-1/5">Biography</div>
                                        <div class="text-sm w-full">: {{ $j_user->user->biography }}</div>
                                    </div>
                                    <div class="w-full flex">
                                        <div class="text-sm w-1/5">Interests</div>
                                        <div class="text-sm w-full">: {{ $j_user->user->interests }}</div>
                                    </div>
                                </div>
                            @endforeach 
                        </div>



                        <p class="text-lg font-bold mb-2">Advisory Board</p>
    
                        <div class="w-full mt-2 mb-8">
                            @foreach ($record->journal_us()->whereHas('roles', function ($query) {
                                $query->whereIn('name', ['Advisory Board']);
                            })->get() as $k => $j_user)

                            <div class="w-full p-2 border bg-white hover:bg-gray-200 border-slate-200 cursor-pointer" wire:click="editorDetails('{{ 'advisory'.$k }}')">
                                <div class="font-semibold">
                                    {{ $j_user->user->salutation?->title }}
                                    {{ $j_user->user->first_name }}
                                    {{ $j_user->user->middle_name }}
                                    {{ $j_user->user->last_name }}

                                    <span class="text-sm font-light">
                                        {{ $j_user->user->affiliation != '' ? '('.$j_user->user->affiliation.')' : '' }}
                                    </span>
                                </div>

                                

                                {{-- @if ($j_user->hasRole('Chief Editor'))
                                    <p class="text-xs text-green-900">Managing Editor</p>
                                @elseif ($j_user->hasRole('Supporting Editor'))
                                    <p class="text-xs text-green-400">Supporting Editor</p>
                                @elseif ($j_user->hasRole('Associate Editor'))
                                    <p class="text-xs text-blue-900">Associate Editor</p>
                                @elseif ($j_user->hasRole('Advisory Board'))
                                    <p class="text-xs text-blue-400">Advisory Board</p>
                                @endif --}}
                            </div>

                            <div class="p-2 text-sm border @if('advisory'.$k != $editor_detail) hidden @endif" >
                                <div class="w-full flex">
                                    <div class="text-sm w-1/5 ">Affiliation</div>
                                    <div class="text-sm w-full">: {{ $j_user->user->affiliation }}</div>
                                </div>
                                <div class="w-full flex">
                                    <div class="text-sm w-1/5 ">Country</div>
                                    <div class="text-sm w-full">: {{ $j_user->user?->country?->name }}</div>
                                </div>
                                <div class="w-full flex">
                                    <div class="text-sm w-1/5">Degree</div>
                                    <div class="text-sm w-full">: {{ $j_user->user->degree }}</div>
                                </div>
                                <div class="w-full flex">
                                    <div class="text-sm w-1/5">Email</div>
                                    <div class="text-sm w-full">: {{ $j_user->user->email }}</div>
                                </div>
                                <div class="w-full flex">
                                    <div class="text-sm w-1/5">Biography</div>
                                    <div class="text-sm w-full">: {{ $j_user->user->biography }}</div>
                                </div>
                                <div class="w-full flex">
                                    <div class="text-sm w-1/5">Interests</div>
                                    <div class="text-sm w-full">: {{ $j_user->user->interests }}</div>
                                </div>
                            </div>
                            @endforeach 
                        </div>
                    </div>
                </div>

                <div class="w-full mb-4 @if($tab != 'calls_for_papers') hidden @endif">
                    <div class="w-full mb-4">
                        <p class="text-lg font-bold mb-2">Call for Papers</p>

                        @foreach ($record->call_for_papers as $call)
                            <div class="bg-white shadow-md mb-2">
                                <div class="p-2 text-xs">
                                    <span class="font-semibold">CLOSES ON</span> : <span class="text-gray-500">{{ \Carbon\Carbon::parse( $call->end_date)->format('d M Y') }}</span>
                                </div>
                                <div class="p-2 border-b border-t">

                                    <p class="font-semibold hover:text-blue-600">
                                        <a href="{{ route('journal.call_detail', $call->uuid) }}">{{ $call->title }}</a>
                                    </p>
                                    
                                    <div class="mt-2 text-xs text-gray-500 text-justify">
                                        {!! Str::limit(strip_tags($call->description), 250) !!}
                                    </div>
                                </div>
                                <div class="p-2">

                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

            <div class="col-span-4">

                <div class="w-full mb-4">
                <p class="text-lg font-bold mb-2 pl-2">Most Viewed Articles</p>

                    @php
                        $statusp = App\Models\ArticleStatus::where('code', '014')->first();
                        $recent  = $record->articles()->where('downloads', '>', 0)->orderBy('downloads', 'desc')->limit(5)->get();
                    @endphp
                    
                    @if(count( $recent ) > 0)
                    @foreach ($recent as $key => $article)
                        <a href="{{ route('journal.article', $article->uuid) }}">
                            <div class="text-sm font-bold text-gray-700 hover:text-blue-700 bg-white hover:bg-gray-100 cursor-pointer rounded shadow p-3 mt-2 mb-2">
                                {{ $article->title }}

                                <div class="text-xs text-green-700 font-light hover:text-green-600">
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

                            </div>
                        </a>
                    @endforeach
                    
                    <x-button class="mb-4 w-full " wire:click="changeTab('table_of_contents')">View All Articles </x-button>
                    @else
                        <div class="text-sm font-bold text-blue-700 text-center bg-gray-50 hover:bg-gray-100 cursor-pointer p-2 mb-2 mt-2 shadow">
                            No Most Viewed Articles
                        </div>
                    @endif
                </div>

                <br>
                <br>
            </div>
        </div>
    </div>
</div>