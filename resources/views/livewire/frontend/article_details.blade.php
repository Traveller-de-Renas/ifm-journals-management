<x-module>
    <x-slot name="title" >
        <div class="w-full flex text-xs">
            <p class="underline mr-1 cursor-pointer hover:text-gray-500">
                <a href="{{ route('journals.details', $record?->journal->uuid) }}">
                {{ $record?->journal->title }}
                </a>
            </p>
            <p class="mr-1"> > </p> 
            <p class="underline mr-1 cursor-pointer hover:text-gray-500"> {{ $record->issue?->volume?->description }} </p>
            <p class="mr-1"> > </p>
            <p class="underline mr-1 cursor-pointer hover:text-gray-500"> {{ $record->issue?->description }} </p>
        </div>
        
        <p class="text-blue-700">
            {{ __($record->title) }}
        </p>
    </x-slot>

    <div class="mb-6">
        @foreach ($record->article_users as $key => $user)
            {{ $user->first_name }} ({{ $user->affiliation }})
        @endforeach

        @php 
            $file = $record->files()->where('publish', 1)->first();
        @endphp
        <div class="flex items-center">
            <a href="{{ route('journal.article_download', $file?->id) }}" >
                <div class="flex items-center text-blue-700 hover:text-blue-600 cursor-pointer">
                    <img src="{{ asset('storage/favicon/pdf.png') }}" class="h-5"> <p class="ml-2 text-lg font-bold">Download Article</p>
                </div>
            </a>
            <p class="ml-2 text-lg text-gray-600 font-bold">| {{ $file?->downloads }} Downloads | Published On {{ date("Y-m-d") }} </p>
        </div>
    </div>

    <div class="w-full">
        <p class="text-lg font-bold mb-2">Abstract</p>
        <div class="w-full text-justify mb-4">
            {!! $record->abstract !!}
        </div>
    </div>

    <div class="w-full grid grid-cols-12 gap-2">
        <div class="col-span-8">

            @if($record->keywords != '')
            <div class="w-full mb-4">
                <p class="text-lg font-bold">Keywords</p>
                <div class="text-sm font-bold text-blue-700 hover:text-blue-600 cursor-pointer mb-2 mt-2">
                    {{ $record->keywords }}
                </div>
            </div>
            @endif
            
            @if($record->areas != '')
            <div class="w-full mb-4">
                <p class="text-lg font-bold">Areas</p>
                <div class="text-sm font-bold text-blue-700 hover:text-blue-600 cursor-pointer mb-2 mt-2">
                    {{ $record->areas }}
                </div>
            </div>
            @endif

            @php
                $coauthors = $record->article_users()->wherePivot('role', '<>', 'reviewer')->get()
            @endphp
            
            @if(count($coauthors) > 0)
            <div class="w-full mb-4">
                <p class="text-lg font-bold">Co Authors</p>
                <div class="text-sm text-blue-700 hover:text-blue-600 cursor-pointer mb-2 mt-2">
                    @foreach ($coauthors as $key => $user)
                    <div class="flex items-center">
                        {{ $user->salutation?->title }} {{ $user->first_name }} ({{ $user->affiliation }})
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

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