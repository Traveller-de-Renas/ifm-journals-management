<x-module>
    
    <x-slot name="title">
        {{ __($record->title) }}
    </x-slot>

    <div class="mb-2">
        <div class="text-sm">
            {{ $record->chief_editor?->salutation?->title }} {{ $record->chief_editor?->first_name }} {{ $record->chief_editor?->middle_name }} {{ $record->chief_editor?->last_name }} 
            {{ $record->chief_editor?->affiliation != '' ? '('. $record->chief_editor?->affiliation.')' : '' }}
        </div>
    </div>
        
    <div class="grid grid-cols-12 gap-2 bg-gray-200 rounded shadow-lg w-full">
        <div class="col-span-1 items-center">
            @if($record->image == '')
                <svg class="w-full text-white mt-4 ml-1 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                    <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/>
                </svg>
            @else
                <img class="h-full w-full rounded-tl-md rounded-bl-md" src="{{ asset('storage/journals/'.$record->image) }}" width="40" height="40" alt="{{ $record->code }}">
            @endif
            
        </div>
        <div class="col-span-11 w-full mb-2 mt-2">
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
        </div>
    </div>

    <div class="w-full text-justify mt-4 mb-4">
        {!! $record->description !!}
    </div>

    <div class="flex justify-between gap-2">
        @if(auth()->user())
            @if (!$record->journal_users->contains(auth()->user()->id))
                <x-button wire:click="signup()" >Register </x-button>
            @endif
        @endif

        <a href="{{ route('journals.submission', $record->uuid) }}" class="flex-1">
            <x-button class="mb-4 w-full">Submit a Paper </x-button>
        </a>

        <a href="{{ route('journals.articles', [$record->uuid, 'Pending']) }}" class="flex-1">
            <x-button class="mb-4 w-full">Pending </x-button>
        </a>

        <a href="{{ route('journals.articles', [$record->uuid, 'Submitted']) }}" class="flex-1">
            <x-button class="mb-4 w-full">Received </x-button>
        </a>

        <a href="{{ route('journals.articles', $record->uuid) }}" class="flex-1">
            <x-button class="mb-4 w-full">Rejected </x-button>
        </a>

        <a href="{{ route('journals.articles', $record->uuid) }}" class="flex-1">
            <x-button class="mb-4 w-full">Under Review </x-button>
        </a>

        <a href="{{ route('journals.articles', $record->uuid) }}" class="flex-1">
            <x-button class="mb-4 w-full">On Pub. Process </x-button>
        </a>

        <a href="{{ route('journals.articles', [$record->uuid, 'Published']) }}" class="flex-1">
            <x-button class="mb-4 w-full">Published </x-button>
        </a>
    </div>

    @if (session('danger'))
        <div class="rounded bg-red-300 p-2 w-full mb-4">
            {{ session('danger') }}
        </div>
    @endif

    <div class="md:grid md:grid-cols-12 gap-4 w-full ">
        <div class="col-span-9">

            @if ($articles->count() > 0)
            
                @foreach ($articles as $key => $article)
                
                    <div class="hover:bg-gray-100 cursor-pointer p-2 border rounded-lg mb-4 ">
                        <a href="{{ route('journals.article', $article->uuid) }}">
                            <div class="text-sm font-bold hover:text-blue-600 ">
                                {{ $article->title }}
                            </div>
                        </a>

                        <div class="text-xs text-blue-700 hover:text-blue-600 mb-2">

                            {{ $article?->author?->salutation?->title }} {{ $article?->author?->first_name }} {{ $article?->author?->middle_name }} {{ $article?->author?->last_name }},
                            
                            @foreach ($article->article_users as $key => $article_user)
                            {{ $article_user->salutation?->title }} {{ $article_user->first_name }} {{ $article_user->middle_name }} {{ $article_user->last_name }},
                            @endforeach

                        </div>
                        
                        <div class="w-full flex gap-2">
                            <div class="w-1/12">
                                <span class="

                                @if ($article->status == 'Published')
                                    bg-green-700
                                @elseif($article->status == 'Pending') 
                                    bg-yellow-700
                                @elseif($article->status == 'Submitted') 
                                    bg-blue-500
                                @elseif($article->status == 'Banned')
                                    bg-red-900
                                @elseif($article->status == 'On Review')
                                    bg-purple-500
                                @elseif($article->status == 'From Reviewer')
                                    bg-pink-500
                                @elseif($article->status == 'From Editor')
                                    bg-indigo-500
                                @elseif($article->status == 'Declined')
                                    bg-gray-500
                                @elseif($article->status == 'Declined Revision')
                                    bg-red-400
                                @elseif($article->status == 'Unpublished')
                                    bg-red-400
                                @else
                                    bg-gray-200
                                @endif
                                text-gray-900
                                 text-xs p-1 rounded">{{ $article->status }}</span>
                            </div>
                            
                            <div class="w-full flex gap-2 justify-end">
                                <x-button-plain class="bg-blue-700">
                                    <svg class="h-4 w-4 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />  <polyline points="7 10 12 15 17 10" />  <line x1="12" y1="15" x2="12" y2="3" /></svg>
                                </x-button-plain>
                                <a href="{{ route('journals.submission', [$record->uuid, $article->uuid]) }}">
                                <x-button-plain class="bg-blue-700">
                                    <svg class="h-4 w-4 text-white"  viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" /></svg>
                                </x-button-plain>
                                </a>

                                @if ($article->author?->id == auth()->user()->id)
                                
                                <x-button-plain class="bg-red-700" wire:click="confirmDelete({{ $article->id }})" >
                                    <svg class="h-4 w-4 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="3 6 5 6 21 6" />  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" /></svg>
                                </x-button-plain>

                                @endif
                            </div>
                        </div>
                    </div>
                    
                @endforeach

            @else
            
                <div class="w-full bg-blue-400 rounded shadow p-2">No Articles Found</div>

            @endif

            <div class="mt-4 w-full">
                {{ $articles->links() }}
            </div>
        </div>

        <div class="col-span-3">
            <div class="bg-gray-100 rounded border mb-4">

                <p class="p-2">Current Volume :
                    {{ $record->volume?->description }}
                </p>

                @if ($record?->chief_editor?->id == auth()->user()->id)
                <div class="flex gap-2 justify-between border-t p-2">
                    <x-button class="w-full">Close Volume </x-button>
                    <x-button class="w-full" wire:click="createVolume();">Create New </x-button>
                </div>
                @endif
            

                <p class="p-2">Current Issue :
                    {{ $record->issue?->description }}
                </p>

                @if ($record?->chief_editor?->id == auth()->user()->id)
                <div class="flex gap-2 justify-between border-t p-2">
                    @if(!empty($record->issue))
                    <x-button class="w-full" wire:click="publishIssue({{ $record->issue?->id }})">Publish </x-button>
                    @endif
                    <x-button class="w-full" wire:click="createIssue();">Create New </x-button>
                </div>
                @endif
                
                <a href="{{ route('journals.archive', $record->uuid) }}">
                    <x-button class="w-full mt-4" >Go to Archive </x-button>
                </a>
            </div>
        </div>
    </div>

    <x-dialog-modal wire:model="deleteModal">
        <x-slot name="title">
            {{ __('Delete Data') }}
        </x-slot>
        <x-slot name="content">
            <div class="mt-4">
                <p class="text-center">Are you sure you want to delete this record.?</p>
            </div>
        </x-slot>
        <x-slot name="footer">
            
            <x-button-danger type="submit" wire:click="delete({{ $article?->id }})" wire:loading.attr="disabled" >
                {{ __('Delete') }}
            </x-button-danger>
            <x-secondary-button class="ml-3" wire:click="$toggle('deleteModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>

</x-module>