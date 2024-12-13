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
                        <svg class="w-full text-white dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/>
                        </svg>
                    </div>
                    @else
                        <img class="w-full rounded-md rounded-bl-md mt-4" src="{{ asset('storage/journals/'.$record->image) }}" alt="{{ strtoupper($record->code) }}">
                    @endif

                    <a href="{{ route('journals.submission', $record->uuid) }}">
                        <x-button class="mb-4 mt-2 w-full">Submit a Paper </x-button>
                    </a>
                </div>

            </div>
        </div>
    </div>



<div class="border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
            <li class="me-2">
                <a href="#" class="font-bold inline-flex items-center justify-center p-4 rounded-t-lg hover:text-gray-600 group border-b-2 @if($tab == 'overview') border-blue-600 @else border-transparent hover:border-gray-300 @endif " wire:click="changeTab('overview')">
                    Overview
                </a>
            </li>
            <li class="me-2">
                <a href="#" class="font-bold inline-flex items-center justify-center p-4 rounded-t-lg hover:text-gray-600 group border-b-2 @if($tab == 'table_of_contents') border-blue-600 @else border-transparent hover:border-gray-300 @endif " wire:click="changeTab('table_of_contents')">
                    Table of Contents
                </a>
            </li>
            <li class="me-2">
                <a href="#" class="font-bold inline-flex items-center justify-center p-4 rounded-t-lg hover:text-gray-600 group border-b-2 @if($tab == 'author_guidelines') border-blue-600 @else border-transparent hover:border-gray-300 @endif " wire:click="changeTab('author_guidelines')">
                    Author Guidelines
                </a>
            </li>
            <li class="me-2">
                <a href="#" class="font-bold inline-flex items-center justify-center p-4 rounded-t-lg hover:text-gray-600 group border-b-2 @if($tab == 'editorial_board') border-blue-600 @else border-transparent hover:border-gray-300 @endif " wire:click="changeTab('editorial_board')">
                    Editorial Board
                </a>
            </li>
            <li class="me-2">
                <a href="#" class="font-bold inline-flex items-center justify-center p-4 rounded-t-lg hover:text-gray-600 group border-b-2 @if($tab == 'reviewer_information') border-blue-600 @else border-transparent hover:border-gray-300 @endif " wire:click="changeTab('reviewer_information')">
                    Reviewer Information
                </a>
            </li>
            <li class="me-2">
                <a href="#" class="font-bold inline-flex items-center justify-center p-4 rounded-t-lg hover:text-gray-600 group border-b-2 @if($tab == 'calls_for_papers') border-blue-600 @else border-transparent hover:border-gray-300 @endif " wire:click="changeTab('calls_for_papers')">
                    Calls for Papers
                </a>
            </li>
        </ul>
    </div>
</div>


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">

        <div class="md:grid md:grid-cols-12 gap-4 w-full ">

            <div class="col-span-9">

                <div class="w-full mb-4 @if($tab != 'overview') hidden @endif">

                    <div class="w-full mb-4">
                        <p class="text-lg font-bold mb-2">Aim and Scope</p>
                        <div class="text-justify">
                            {!! $record->scope !!}
                        </div>
                    </div>

                    @if(!empty($record->indecies) && count($record->indecies) > 0)
                    <div class="w-full mb-4">
                        <p class="text-lg font-bold mb-2">Indexing</p>
                        
                        @foreach ($record->indecies as $index)
                            <div class="rounded-sm border border-slate-200 mb-2" x-data="{ open: false }">
                                <div class="w-full p-2 cursor-pointer" @click.prevent="open = !open" :aria-expanded="open">
                                    <div class="text-slate-800">
                                        <a href="{{ $index->link }}" target="_blank" >{{ $index->title }}</a>
                                    </div>
                                </div>
                                <div class="text-sm p-2" x-show="open" x-cloak="">
                                    {{ $index->description }}
                                </div>
                            </div>
                        @endforeach
                        
                    </div>
                    @endif

                </div>

                <div class="w-full mb-4 @if($tab != 'table_of_contents') hidden @endif">

                    <div class="w-full mb-2">
                        <p class="text-lg font-bold mb-2">Publications</p>
    
                        @if ($record->volumes != '')
                        @foreach ($record->volumes as $key => $volume)
                                <div class="rounded-sm border border-slate-200 mb-2" x-data="{ open: false }">
                                    <div class="w-full p-2 cursor-pointer hover:bg-slate-200" @click.prevent="open = !open" :aria-expanded="open">
                                        <div class="text-slate-800 font-bold">
                                            <a href="" target="_blank" >{{ $volume->description }}</a>
                                        </div>
                                    </div>
                                    <div class="text-sm" x-show="open" x-cloak="">
                                        @foreach ($volume->issues()->where(function($query) use($record){
                                            if(auth()->user()?->id != $record->chief_editor?->id){
                                                $query->where('status', 'Published');
                                            }
                                        })->get() as $key => $issue)
                                        <div class="rounded-sm border-b border-t border-slate-200 mb-2" x-data="{ open: false }">
                                            <div class="w-full p-2 cursor-pointer" @click.prevent="open = !open" :aria-expanded="open">
                                                <div class="text-slate-800">
                                                    <a href="" target="_blank" >{{ $issue->description }}</a>
                                                </div>
                                            </div>
                                            <div class="text-sm p-2" x-show="open" x-cloak="">
                                                <div class="flex justify-between">
                                                    <p class="text-slate-800 font-bold">{{ $issue->description }} Articles</p>
                                                    <div class="text-right">
    
                                                        @if(auth()->user()?->id == $record->chief_editor?->id)
                                                        @if($issue->status == 'Unpublished')
                                                        <x-button class="" wire:click="publishIssue({{ $issue->id }}, 'Published')">Publish Issue</x-button>
                                                        @endif
    
                                                        @if($issue->status == 'Published')
                                                        <x-button-plain class="bg-red-700 hover:bg-red-500" wire:click="publishIssue({{ $issue->id }}, 'Unpublished')">Unpublish Issue</x-button-plain>
                                                        @endif
                                                        @endif
    
                                                    </div>
                                                </div>
    
                                                @php
                                                    $status = App\Models\ArticleStatus::where('code', '006')->first();
                                                @endphp
                                                
    
                                                @foreach ($issue->articles()->where('article_status_id', $status->id)->get() as $key => $article)
                                                <div class="w-full mb-6 pb-6 border-b">
                                                    <a href="{{ route('journal.article', $article->uuid) }}">
                                                    <p class="text-blue-700 hover:text-blue-500 text-lg font-bold cursor-pointer">{{ $article->title }}</p>
                                                    </a>
                                                    
                                                    <div class="text-sm text-green-700">
                                                        {{ $article->author?->salutation?->title }} {{ $article->author?->first_name }} {{ $article->author?->middle_name }} {{ $article->author?->last_name }} 
                                                        {{ $article->author?->affiliation != '' ? '('. $article->author?->affiliation.')' : '' }}
                                                    </div>
    
                                                    <div class="mt-2 text-justify italic">
                                                        {!! $article->abstract !!}
                                                    </div>
                                                </div>
                                                @endforeach
    
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @endif
    
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
                        <p class="text-lg font-bold mb-2">Editorial Board</p>
    
                        <div class="w-full mt-2">
                        @foreach ($record->journal_users()->where('role', 'editor')->get() as $key => $journal_user)
                        
                                <div class="flex w-full" >
                                    <div class="w-full border bg-gray-100 hover:bg-gray-200 border-slate-200 px-4 rounded-sm cursor-pointer" wire:click="editorDetails({{ $key }});">
                                        {{ $journal_user->salutation?->title }}
                                        {{ $journal_user->first_name }}
                                        {{ $journal_user->middle_name }}
                                        {{ $journal_user->last_name }}
    
                                        {{ $journal_user->affiliation != '' ? '('.$journal_user->affiliation.')' : '' }}
    
                                        @if ($journal_user->id == $record->user_id)
                                            <p class="text-xs text-green-400">Chief Editor</p>
                                        @else
                                            <p class="text-xs text-blue-400">Editor</p>
                                        @endif
                                    </div>
                                </div>
                            
                                <div class="p-2 text-sm border @if($key != $editor_detail) hidden @endif" >
                                    <div class="w-full flex">
                                        <div class="text-sm w-1/5 ">Affiliation</div>
                                        <div class="text-sm w-full">: {{ $journal_user->affiliation }}</div>
                                    </div>
                                    <div class="w-full flex">
                                        <div class="text-sm w-1/5">Degree</div>
                                        <div class="text-sm w-full">: {{ $journal_user->degree }}</div>
                                    </div>
                                    <div class="w-full flex">
                                        <div class="text-sm w-1/5">Email</div>
                                        <div class="text-sm w-full">: {{ $journal_user->email }}</div>
                                    </div>
                                    <div class="w-full flex">
                                        <div class="text-sm w-1/5">Category</div>
                                        <div class="text-sm w-full">: {{ $journal_user->category }}</div>
                                    </div>
                                </div>
                            @endforeach 
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-span-3">

                <div class="w-full mb-4">
                <p class="text-lg font-bold mb-2">Recent Articles</p>
                    
                    @foreach ($record->articles()->orderBy('created_at', 'desc')->limit(5)->get() as $key => $article)
                        <a href="{{ route('journal.article', $article->uuid) }}">
                            <div class="text-sm font-bold text-blue-700 hover:text-blue-600 bg-gray-50 hover:bg-gray-100 cursor-pointer p-2 mb-2 mt-2">
                                {{ $article->title }}
                            </div>
                        </a>
                    @endforeach
                    
                    <x-button class="mb-4 w-full " wire:click="changeTab('table_of_contents')">View All </x-button>
                </div>

                <br>
                <br>
            </div>
        </div>
    </div>
</div>