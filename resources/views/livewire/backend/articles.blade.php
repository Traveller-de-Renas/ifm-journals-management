<div class="w-full max-w-7xl mx-auto sm:px-6 lg:px-8">

    <div class="bg-gray-800 text-white bg-blend-overlay py-4" style="background-image: url({{ asset('images/auth-image.jpg') }}); background-position: top;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-2 ">
                
                <div class="col-span-10 w-full mb-2 mt-2">
                    <p class="text-4xl font-bold">
                        {{ __($record->title) }} ({{ strtoupper($record->code) }})
                    </p>

                    <div class="mb-2">
                        <div class="text-sm">
                            {{ $record->chief_editor?->salutation?->title }} {{ $record->chief_editor?->first_name }} {{ $record->chief_editor?->middle_name }} {{ $record->chief_editor?->last_name }} 
                            {{ $record->chief_editor?->affiliation != '' ? '('. $record->chief_editor?->affiliation.')' : '' }}
                        </div>
                    </div>

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

    @if (session('danger'))
        <div class="rounded bg-red-300 p-2 w-full mb-4">
            {{ session('danger') }}
        </div>
    @endif

    <div class="md:grid md:grid-cols-12 gap-4 w-full ">
        <div class="col-span-3">
            <br>
            @foreach ($statuses as $statex)
                <a href="{{ route('journals.articles', [$record->uuid, $statex->code]) }}" class="mb-1 ">
                    <p class="w-full font-bold text-blue-700 hover:text-blue-500 p-1">
                        {{ $statex->name }}
                        ({{ $statex->articles()->where('article_status_id', $statex->id)->where('journal_id', $record->id)->count() }})
                    </p>
                </a>
            @endforeach

            <br>

            <a href="{{ route('journals.articles', $record->uuid) }}" >
                <x-button class="mb-4 w-full">View All </x-button>
            </a>
        </div>
        <div class="col-span-9">
            <br>
            @if ($articles->count() > 0)
            
                @foreach ($articles as $key => $article)
                
                    <div class="border rounded-lg mb-4 bg-gray-200">
                        <a href="{{ route('journals.article', $article->uuid) }}">
                            <div class="bg-white p-2 text-sm font-bold hover:bg-gray-100 rounded-t-lg">
                                
                                <div class="text-sm font-bold hover:text-blue-600 ">
                                    {{ $article->title }}
                                </div>

                                <div class="text-xs text-blue-700 hover:text-blue-600 mb-2">

                                    {{ $article?->author?->salutation?->title }} {{ $article?->author?->first_name }} {{ $article?->author?->middle_name }} {{ $article?->author?->last_name }},
                                    
                                    @foreach ($article->article_users()->wherePivot('role', 'author')->get() as $key => $article_user)
                                        {{ $article_user->salutation?->title }} {{ $article_user->first_name }} {{ $article_user->middle_name }} {{ $article_user->last_name }},
                                    @endforeach

                                </div>
                            </div>
                        </a>
                        
                        <div class="w-full p-2 flex gap-2 ">
                            <div class="w-4/12">
                                <span class="w-full text-gray-900 text-xs px-2 py-1 rounded {{ $article->article_status->color }}
                                ">{{ $article->article_status->name }}</span>
                            </div>

                            @php
                                $a_editor = $article->editors()->first();
                            @endphp
                            @if ($record?->chief_editor?->id == auth()->user()->id && !empty($a_editor))
                                <div class="w-8/12 bg-blue-100 text-xs p-1 px-2 rounded-lg items-center">
                                    Assigned to : {{ $a_editor?->salutation?->title }} {{ $a_editor?->first_name }} {{ $a_editor?->middle_name }} {{ $a_editor?->last_name }}
                                </div>
                            @endif
                            
                            <div class="w-full flex gap-2 justify-end">
                                @if((in_array(auth()->user()->id, $article->article_users()->wherePivot('role', 'author')->get()->pluck('id')->toArray()) || $article->author?->id == auth()->user()->id) && $article->article_status->code == '001')
                                    <a href="{{ route('journals.submission', [$record->uuid, $article->uuid]) }}">
                                        <x-button-plain class="bg-blue-700">
                                            <svg class="h-3 w-3 text-white"  viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" /></svg>
                                        </x-button-plain>
                                    </a>
                                @endif


                                @if ($article->author?->id == auth()->user()->id && $article->article_status->code == '001')
                                    <x-button-plain class="bg-red-700" wire:click="confirmDelete({{ $article->id }})" >
                                        <svg class="h-3 w-3 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="3 6 5 6 21 6" />  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" /></svg>
                                    </x-button-plain>
                                @endif


                                @if ($article->author?->id == auth()->user()->id && $article->article_status->code == '002')
                                    <button class="bg-red-700 hover:bg-red-800 text-white text-xs py-1 px-2 rounded" wire:click="confirm({{ $article->id }}, 'Cancel Submission', 'cancelSubmission')" >
                                        <span class="text-xs">Cancel Submission</span>
                                    </button>
                                @endif

                            </div>
                        </div>
                    </div>
                    
                @endforeach

            @else
            
                <div class="w-full bg-blue-400 rounded shadow p-2 text-center">No Articles Found</div>

            @endif

            <div class="mt-4 w-full">
                {{ $articles->links() }}
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

    <x-dialog-modal wire:model="confirmModal">
        <x-slot name="title">
            {{ __($modal_title) }}
        </x-slot>
        <x-slot name="content">
            <div class="mt-4">
                <p class="text-center">Are you sure you want to Perform this action.?</p>
            </div>
        </x-slot>
        <x-slot name="footer">
            
            <x-button-danger type="submit" wire:click="confirmAction()" wire:loading.attr="disabled" >
                {{ __('Yes '.$modal_title) }}
            </x-button-danger>
            <x-secondary-button class="ml-3" wire:click="$toggle('deleteModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>

</div>