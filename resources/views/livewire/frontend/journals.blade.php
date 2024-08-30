<x-module>
    <x-slot name="title">
        {{ __('JOURNALS') }}
    </x-slot>
 
    <div class="w-full md:grid md:grid-cols-3 gap-4 mb-4" >
        <div class="">
            <x-input wire:model.live.debounce.500ms="query" placeholder="search..." type="search" />
        </div>
        <div class=""></div>
        <a href="{{ route('journals.form', 'create') }}">
            <x-button class="float-right" wire:loading.attr="disabled" >Create New</x-button>
        </a>
    </div>

    <div class="grid grid-cols-12 gap-4 w-full">
        <div class="col-span-3">
            <div class="bg-white border rounded p-2 shadow-sm">
            <div class="text-sm text-slate-800 dark:text-slate-100 cqosy cvavu">Subjects</div>
            <ul class="cbfhc">

                @foreach ($subjects as $key => $subject)
                    <li>
                        <label class="flex items-center">
                            <input type="checkbox" class="cybz1" wire:click="checkOption('subjects', {{ $subject->id }})" value="{{ $subject->id }}">
                            <span class="text-sm ch1ih c6w4h cw92y c9o7o ml-2">{{ $subject->name }}</span>
                        </label>
                    </li>
                @endforeach
                
            </ul>

            <div class="text-sm text-slate-800 dark:text-slate-100 cqosy cvavu mt-6">Categories</div>
            <ul class="cbfhc">

                @foreach ($categories as $key => $categ)
                    <li>
                        <label class="flex items-center">
                            <input type="checkbox" class="cybz1" wire:click="checkOption('categories', {{ $categ->id }})" value="{{ $categ->id }}">
                            <span class="text-sm ch1ih c6w4h cw92y c9o7o ml-2">{{ $categ->name }}</span>
                        </label>
                    </li>
                @endforeach
                
            </ul>
        </div>
        </div>
        <div class="col-span-9">
            @foreach ($data as $row)
                <div class="border border-slate-200 dark:border-slate-700 p-4 shadow-md mb-8 rounded-md w-full">
                    
                    <div class="flex items-top">
                        @if($row->image == '')
                            <svg class="w-8 h-8 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/>
                            </svg>
                        @else
                            <img class="c7n6y" src="{{ asset('storage/journals/'.$row->image) }}" width="40" height="40" alt="{{ $row->code }}">
                        @endif
                        <div class="">
                            <p class="ml-2 text-lg font-bold text-blue-700 hover:text-blue-600 cursor-pointer"> {{ $row->title }} </p>
                            <div class="ml-2 text-xs">
                                @if(!empty($row?->journal_users))
                                    @foreach ($row->journal_users as $key => $user)
                                        {{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }} ({{ $user->affiliation }}),
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="text-sm text-slate-800 dark:text-slate-100 cbfhc cg5st mb-6">
                        <p class="text-justify">{!! $row->description !!}</p>
                    </div>

                    <a href="{{ route('journals.form', $row->uuid) }}" >
                        <x-button>Edit</x-button>
                    </a>

                    <a href="{{ route('journals.details', $row->uuid) }}">
                        <x-button>Preview</x-button>
                    </a>

                    @if(auth()->user())
                        @if (!$row->journal_users->contains(auth()->user()->id))
                            <x-button wire:click="signup({{ $row->id }})" >Register </x-button>
                        @endif
                    @endif

                    <a href="{{ route('journals.submission', $row->uuid) }}">
                        <x-button>Submit a Paper </x-button>
                    </a>

                </div>
            @endforeach

            {{ $data->links() }}
        </div>
    </div>

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
            <x-secondary-button class="ml-3" wire:click="$toggle('Edit')" wire:loading.attr="disabled">
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
            <x-secondary-button class="ml-3" wire:click="$toggle('Edit')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>

</x-module>