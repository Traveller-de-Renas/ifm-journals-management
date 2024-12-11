<x-module>
    
    <x-slot name="title">
        {{ __('PUBLICATION PROCESS') }}
    </x-slot>

 
    <div class="w-full md:grid md:grid-cols-3 gap-4 mb-4" >
        <div class="">
            <x-input wire:model.live.debounce.500ms="query" placeholder="search..." type="search" />
        </div>
        <div class=""></div>

        <div class="flex items-start justify-between  gap-4">
        </div>

    </div>

    @foreach ($data as $row)
    <div class="border border-slate-200 dark:border-slate-700 p-4 shadow-md mb-4 rounded-md">

        <div class="grid grid-cols-12 gap-2 w-full">
            <div class="col-span-2">
                @if($row->image == '')
                    <svg class="w-8 h-8 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                        <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/>
                    </svg>
                @else
                    <img class="" src="{{ asset('storage/journals/'.$row->image) }}" alt="{{ strtoupper($row->code) }}">
                @endif
            </div>
            <div class="col-span-10">
                
                <div class="">
                    <div class="flex items-top">
                        <div class="">
                            <p class="text-lg font-bold text-blue-700 hover:text-blue-600 cursor-pointer"> 
                                <a href="{{ route('journals.details', $row->uuid) }}">
                                {{ $row->title }} ({{ strtoupper($row->code) }})
                                </a>
                            </p>
                            <div class="text-xs">
                                <a href="{{ route('admin.user_preview', $row->chief_editor?->uuid) }}" >
                                {{ $row->chief_editor?->salutation?->title }} {{ $row->chief_editor?->first_name }} {{ $row->chief_editor?->middle_name }} {{ $row->chief_editor?->last_name }} {{ $row->chief_editor?->affiliation != '' ? '('. $row->chief_editor?->affiliation.')' : '' }}
                                </a>
                                {{-- @if(!empty($row?->journal_users))
                                    @foreach ($row->journal_users as $key => $user)
                                        {{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }} ({{ $user->affiliation }}),
                                    @endforeach
                                @endif --}}
                            </div>
                        </div>
                    </div>

                    <div class="text-sm text-slate-800 dark:text-slate-100 cbfhc cg5st mb-6">
                        <p class="text-justify">{!! $row->description !!}</p>
                    </div>

                    <div class="flex gap-4">

                    <a href="{{ route('journals.details', $row->uuid) }}">
                        <x-button>Preview</x-button>
                    </a>

                    <a href="{{ route('journals.archive', $row->uuid) }}">
                        <x-button class="w-full" >Go to Publication </x-button>
                    </a>

                    </div>

                </div>
                
            </div>
        </div>
    </div>
    @endforeach

    {{ $data->links() }}

    <x-dialog-modal wire:model="Delete">
        <x-slot name="title">
            {{ __('Delete Data') }}
        </x-slot>
        <x-slot name="content">
            <div class="mt-4">
                <p class="text-center">Are you sure you want to delete this record.?</p>
            </div>
        </x-slot>
        <x-slot name="footer">
            
            <x-button-danger type="submit" wire:click="delete({{ $record }})" wire:loading.attr="disabled" >
                {{ __('Delete') }}
            </x-button-danger>
            <x-secondary-button class="ml-3" wire:click="$toggle('Delete')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="signupModal">
        <x-slot name="title">
            {{ __('Delete Data') }}
        </x-slot>
        <x-slot name="content">
            <div class="mt-4">
                <p class="text-center">Are you sure you want to sign up for the journal.?</p>
                <p class="text-center font-bold text-blue-700">{{ $journal?->title }}</p>
            </div>
        </x-slot>
        <x-slot name="footer">
            
            <x-button type="submit" wire:click="confirmSignUp()" wire:loading.attr="disabled" >
                {{ __('Confirm') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('signupModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>

</x-module>