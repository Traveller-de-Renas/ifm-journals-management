<x-module>
    
    <x-slot name="title">
        {{ __($record->title) }}
    </x-slot>

    <div class="mb-2">
        <div class="text-sm">
            {{ $record->chief_editor?->salutation->title }} {{ $record->chief_editor?->first_name }} {{ $record->chief_editor?->middle_name }} {{ $record->chief_editor?->last_name }} 
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

    <div class="w-full grid grid-cols-3 gap-4" >
        <div class="">
            
        </div>
        <div class=""></div>
        <div class="text-right">
            <a href="{{ route('journals.submission', $record->uuid) }}">
                <x-button class="mb-4">Submit a Paper </x-button>
            </a>
        </div>
    </div>

    @if (session('danger'))
        <div class="rounded bg-red-300 p-2 w-full mb-4">
            {{ session('danger') }}
        </div>
    @endif 

    <div class=" w-full ">
        <div class="w-full">

            @if ($record->volumes != '')
            
                {{-- @foreach ($record->volumes as $key => $volume)
                
                    <div class="bg-gray-100 hover:bg-white cursor-pointer p-4 border rounded-lg mb-4 ">
                        
                        <div class="text-sm font-bold hover:underline hover:text-blue-500" wire:click="expand({{ $key }})">
                            {{ $volume->description }}
                        </div>
                        <div class="text-sm {{ $viewhide != $key ? 'hidden' : '' }}" >
                            @foreach ($volume->issues as $key => $issue)
                                <div>
                                    {{ $issue->description }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                @endforeach --}}

                <div class="w-full mb-4">
                    
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
                                        

                                        @foreach ($issue->articles()->where('status', 'Published')->get() as $key => $article)
                                        <div class="w-full">
                                            <a href="{{ route('journal.article', $article->uuid) }}">
                                            <p class="text-blue-700 hover:text-blue-500 text-lg font-bold cursor-pointer">{{ $article->title }}</p>
                                            </a>
                                            
                                            <div class="text-sm text-green-700">
                                                {{ $article->author?->salutation->title }} {{ $article->author?->first_name }} {{ $article->author?->middle_name }} {{ $article->author?->last_name }} 
                                                {{ $article->author?->affiliation != '' ? '('. $article->author?->affiliation.')' : '' }}
                                            </div>

                                            <div class="mt-2 text-justify">
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
                    
                </div>

            @else
            
            @endif

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