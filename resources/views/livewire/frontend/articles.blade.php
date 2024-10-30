<x-module>
    
    <x-slot name="title">
        {{ __($record->title) }} ({{ strtoupper($record->code) }})
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

    <div class="md:grid md:grid-cols-12 gap-4 w-full ">
        <div class="col-span-9">
            @if ($articles->count() > 0)
            @foreach ($articles as $key => $article)
            
            <a href="{{ route('journal.article', $article->uuid) }}">
                <div class="hover:bg-gray-100 cursor-pointer p-2 border rounded-lg mb-4 ">
                    
                    <div class="text-sm font-bold ">
                        {{ $article->title }}
                    </div>

                    <div class="text-xs text-blue-700 hover:text-blue-600 mb-4">
                        
                        @foreach ($article->article_users as $key => $article_user)
                            {{ $article_user->first_name }} {{ $article_user->middle_name }} {{ $article_user->last_name }},
                        @endforeach

                    </div>
                    
                    <div class="w-full text-xs text-gray-500">
                        {{ $record->issue?->created_at }}
                    </div>
                </div>
            </a>
                
            @endforeach

            <div class="mt-4 w-full">
                {{ $articles->links() }}
            </div>
            @else
            
                <div class="w-full bg-blue-400 rounded shadow p-2">No Articles Found</div>

            @endif
        </div>

        <div class="col-span-3">
            <div class="bg-gray-100 rounded border mb-4">

                <p class="p-2">Current Volume :
                    {{ $record->volume?->description }}
                </p>

                @if (auth()->user())
                @if ($record?->chief_editor?->id == auth()->user()->id)
                <div class="flex gap-2 justify-between border-t p-2">
                    <x-button class="w-full">Close Volume </x-button>
                    <x-button class="w-full" wire:click="createVolume();">Create New </x-button>
                </div>
                @endif
                @endif
            

                <p class="p-2">Current Issue :
                    {{ $record->issue?->description }}
                </p>

                @if (auth()->user())
                @if ($record?->chief_editor?->id == auth()->user()->id)
                <div class="flex gap-2 justify-between border-t p-2">
                    @if(!empty($record->issue))
                    <x-button class="w-full" wire:click="publishIssue({{ $record->issue?->id }})">Publish </x-button>
                    @endif
                    <x-button class="w-full" wire:click="createIssue();">Create New </x-button>
                </div>
                @endif
                @endif
                
                <a href="{{ route('journal.archive', $record->uuid) }}">
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
            <x-secondary-button class="ml-3" wire:click="$toggle('Edit')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>

</x-module>