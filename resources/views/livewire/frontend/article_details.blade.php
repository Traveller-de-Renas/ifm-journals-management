<x-module>
    <x-slot name="title" >
        <p class="text-blue-700">
            {{ __($record->title) }}
        </p>
    </x-slot>

    <div class="mb-8">
        @foreach ($record->article_users as $key => $user)
            {{ $user->first_name }} ({{ $user->affiliation }})
        @endforeach
        <div class="flex items-center">
            <div class="flex items-center text-blue-700 hover:text-blue-600 cursor-pointer">
                <img src="{{ asset('storage/favicon/pdf.png') }}" class="h-5"> <p class="ml-2 text-lg font-bold">Download Article</p>
            </div>
            <p class="ml-2 text-lg font-bold"> | Published On {{ date("Y-m-d") }} </p>
        </div>
    </div>

    @if(auth()->user())
    <div class="flex gap-2 w-full mb-4">
        <x-button>
            Send Back to Author
        </x-button>

        <x-button wire:click="assignReviewer({{ $record->id }})">
            Assign Reviewer
        </x-button>

        <x-button-plain class="bg-red-700 hover:bg-red-600">
            Decline Article
        </x-button-plain>
    </div>
    @endif

    <div class="w-full">
        <p class="text-lg font-bold mb-2">Abstract</p>
        <div class="w-full text-justify mb-4">
            {!! $record->abstract !!}
        </div>
    </div>

    <div class="w-full grid grid-cols-12 gap-2">
        <div class="col-span-8">
            <div class="w-full mb-4">
                <p class="text-lg font-bold">Keywords</p>
                <div class="text-sm font-bold text-blue-700 hover:text-blue-600 cursor-pointer mb-2 mt-2">
                    {{ $record->keywords }}
                </div>
            </div>
        
            <div class="w-full mb-4">
                <p class="text-lg font-bold">Areas</p>
                <div class="text-sm font-bold text-blue-700 hover:text-blue-600 cursor-pointer mb-2 mt-2">
                    {{ $record->areas }}
                </div>
            </div>
        
            <div class="w-full mb-4">
                <p class="text-lg font-bold">Co Authors</p>
                <div class="text-sm text-blue-700 hover:text-blue-600 cursor-pointer mb-2 mt-2">
                    @foreach ($record->article_users()->wherePivot('role', '<>', 'reviewer')->get() as $key => $user)
                    <div class="flex items-center">
                        {{ $user->salutation?->title }} {{ $user->first_name }} ({{ $user->affiliation }})
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-span-4">
            @if ($record->article_users()->wherePivot('role', 'reviewer')->get()->count() > 0)
            @if(auth()->user())
            <p class="text-lg font-bold mb-2">Reviewers</p>
            @foreach ($record->article_users()->wherePivot('role', 'reviewer')->get() as $key => $user)
                <div class="w-full">
                    <div class="w-full font-bold text-sm">
                        {{ $user->salutation?->title }} {{ $user->first_name }} ({{ $user->affiliation }})
                    </div>

                    <div class="text-sm w-full">Affiliation : {{ $user->affiliation }}</div>
                    <div class="text-sm w-full">Status : {{ 'Under Evaluation' }}</div>
                    <div class="text-sm w-full">Assigned on : {{ $user->pivot->created_at }}</div>

                    <div class="w-full text-blue-700 hover:text-blue-600 cursor-pointer">
                        <a href="{{ route('journals.article_evaluation', [$record->uuid, $user->uuid]) }}" >Evaluation Form</a>
                    </div>
                </div>
            @endforeach
            @endif
            @endif
        </div>
    </div>
    
    <div class="w-full mb-4">
        <p class="text-lg font-bold">Attached Files</p>
        <div class="text-sm text-blue-700 hover:text-blue-600 cursor-pointer mb-2 mt-2"></div>
            @foreach ($record->files as $key => $file)
            <div class="flex items-center border-b pb-2 w-full">
                <div class="w-full">
                    {{ $file->file_category?->name }}
                    <p class="text-sm text-gray-400">Uploaded on {{ $file->created_at }}</p>
                </div>
                <div class="w-2/12 text-right">
                    <a href="{{ asset('storage/'.$file->path) }}" target="_blank" class="text-blue-700 hover:text-blue-600">
                        <x-button>Download
                            {{-- <svg class="h-5 w-5 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="12" y1="5" x2="12" y2="19" />  <line x1="16" y1="15" x2="12" y2="19" />  <line x1="8" y1="15" x2="12" y2="19" /></svg> --}}
                        </x-button>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <x-dialog-modal wire:model="reviewerModal">
        <x-slot name="title">
            {{ __('Assign Reviewer') }}
        </x-slot>
        <x-slot name="content">
            <div class="mt-4">
                Select Reviewer
                <select class="rounded w-full border-gray-300" wire:model="reviewer_id">
                    @foreach($reviewers as $key => $reviewer)
                    <option>{{ $reviewer->salutation?->title }} {{ $reviewer->first_name }} {{ $reviewer->middle_name }} {{ $reviewer->last_name }}</option>
                    @endforeach
                </select>
            </div>
        </x-slot>
        <x-slot name="footer">
            
            <x-button type="submit" wire:click="assignRev()" wire:loading.attr="disabled" >
                {{ __('Assign') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('reviewerModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>

</x-module>