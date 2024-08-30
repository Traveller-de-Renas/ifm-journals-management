<x-module>
    
    <x-slot name="title">
        {{ __($record->title) }}
    </x-slot>
        
    <div class="grid grid-cols-12 gap-2 bg-gray-200 rounded">
        <div class="col-span-1">
            <img class="h-full w-full rounded-tl-md rounded-bl-md" src="{{ asset('storage/journals/'.$record->image) }}" width="40" height="40" alt="{{ $record->code }}">
        </div>
        <div class="col-span-11 w-full mb-2 mt-2">
            <div class="grid grid-cols-12 gap-2">
                <p class="text-sm">ISSN </p>
                <p class="col-span-11">: {{ $record->issn }}</p>
            </div>

            <div class="grid grid-cols-12 gap-2">
                <p class="text-sm">EISSN </p>
                <p class="col-span-11">: {{ $record->eissn }}</p>
            </div>

            <div class="grid grid-cols-12 gap-2">
                <p class="text-sm">EMAIL </p>
                <p class="col-span-11">: {{ $record->email }}</p>
            </div>

            <div class="grid grid-cols-12 gap-2">
                <p class="text-sm">CREATED </p>
                <p class="col-span-11">: {{ $record->created_at }}</p>
            </div>
        </div>
    </div>

    <div class="w-full text-justify mt-4 mb-4">
        {!! $record->description !!}
    </div>

    <div class="w-full grid grid-cols-3 gap-4 mb-6">
        <div class="bg-gray-200 p-2 rounded-md shadow-md">
            New Submission

            <div class="border-b border-gray-300 mt-1"></div>

            <a href="{{ route('journal.articles', $record->uuid) }}">
            
            <div class="flex text-xs py-2" >
                <div class="w-full">Incomplete</div>
                <div class="w-1/12">0</div>
            </div>

            </a>

            <div class="flex text-xs">
                <div class="w-full">Sent Back</div>
                <div class="w-1/12">0</div>
            </div>
            <div class="flex text-xs">
                <div class="w-full">In Process</div>
                <div class="w-1/12">0</div>
            </div>
            <div class="flex text-xs">
                <div class="w-full">Declined</div>
                <div class="w-1/12">0</div>
            </div>
        </div>
        <div class="bg-gray-200 p-2 rounded-md shadow-md">
            Revisions
            <div class="border-b border-gray-300 mt-1"></div>

            <div class="flex text-xs">
                <div class="w-full">Requiring Revision</div>
                <div class="w-1/12">0</div>
            </div>
            <div class="flex text-xs">
                <div class="w-full">Sent Back</div>
                <div class="w-1/12">0</div>
            </div>
            <div class="flex text-xs">
                <div class="w-full">In Process</div>
                <div class="w-1/12">0</div>
            </div>
            <div class="flex text-xs">
                <div class="w-full">Declined Revision</div>
                <div class="w-1/12">0</div>
            </div>
        </div>
        <div class="bg-gray-200 p-2 rounded-md shadow-md">
            Completed
            <div class="border-b border-gray-300 mt-1"></div>

            <div class="flex text-xs">
                <div class="w-full">Completed</div>
                <div class="w-1/12">0</div>
            </div>
        </div>
    </div>

    

    <div class="w-full grid grid-cols-3 gap-4" >
        <div class="">
            <x-input wire:model.live.debounce.500ms="query" placeholder="search..." type="search" />
        </div>
        <div class=""></div>
        <div class="text-right">
            <a href="{{ route('journals.submission', $record->uuid) }}">
                <x-button class="mb-4">Submit a Paper </x-button>
            </a>
        </div>
    </div>

    <div class="md:grid md:grid-cols-12 gap-4 w-full ">
        <div class="col-span-9">
            
            @foreach ($articles as $key => $article)
            
                <div class="hover:bg-gray-100 cursor-pointer p-2 border rounded-lg mb-4 ">
                    <a href="{{ route('journal.article', $article->uuid) }}">
                        <div class="text-sm font-bold ">
                            {{ $article->title }}
                        </div>
                    </a>

                    <div class="text-xs text-blue-700 hover:text-blue-600 mb-4">
                        
                        @foreach ($article->article_users as $key => $article_user)
                            {{ $article_user->first_name }} {{ $article_user->middle_name }} {{ $article_user->last_name }},
                        @endforeach

                    </div>
                    
                    <div class="w-full flex gap-2">
                        <span class="w-1/12 bg-blue-400 text-xs p-2 rounded">{{ $article->status }}</span>
                        <div class="w-full flex gap-2 justify-end">
                            <x-button-plain class="bg-blue-700">
                                <svg class="h-4 w-4 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />  <polyline points="7 10 12 15 17 10" />  <line x1="12" y1="15" x2="12" y2="3" /></svg>
                            </x-button-plain>
                            <a href="{{ route('journals.submission', [$record->uuid, $article->uuid]) }}">
                            <x-button-plain class="bg-blue-700">
                                <svg class="h-4 w-4 text-white"  viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" /></svg>
                            </x-button-plain>
                            </a>
                            <x-button-plain class="bg-red-700" wire:click="confirmDelete({{ $article->id }})" >
                                <svg class="h-4 w-4 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="3 6 5 6 21 6" />  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" /></svg>
                            </x-button-plain>
                        </div>
                    </div>
                </div>
                
            @endforeach

            <div class="mt-4 w-full">
                {{ $articles->links() }}
            </div>
        </div>

        <div class="col-span-3">
            <div class="bg-gray-100 border rounded p-2 mb-4">

                <p class="text-center">Current Volume</p>

            </div>
        
            <div class="bg-gray-100 border rounded p-2 mb-4">

                <p class="text-center">Current Issue</p>

            </div>
        
            <div class="bg-gray-100 border rounded p-2">

                <p class="text-center">Recent Articles</p>

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
            <x-secondary-button class="ml-3" wire:click="$toggle('Edit')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>

</x-module>