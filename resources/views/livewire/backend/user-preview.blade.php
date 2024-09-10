<x-module>

    <div class="p-6 w-full">
        <!-- Profile Image -->
        <div class="flex justify-center">

            @if ($record->profile_photo_path == '')
                <img class="rounded-full w-32 h-32 border-4 border-gray-300 p-2" src="{{ asset('storage/favicon/'.$record->gender.'.png') }}" width="32" height="32" alt="" />
            @else
                <img class="rounded-full w-32 h-32 border-4 border-gray-300 p-2" src="{{ asset('storage/users/'.$record->profile_photo_path) }}" width="32" height="32" alt="{{ $record->last_name }}" />
            @endif

        </div>

        <!-- User Name and Bio -->
        <div class="text-center mt-4">
            <h2 class="text-2xl font-semibold text-gray-800">{{ $record->salutation?->title }} {{ $record->first_name }} {{ $record->middle_name }} {{ $record->last_name }}</h2>
            <p class="text-gray-600">{{ $record->affiliation }}</p>
            <p class="text-gray-600">{{ $record->degree }}</p>
            <p class="text-gray-600">{{ $record->email }}</p>

            <div class="border-b mt-4"></div>
        </div>

        @if($record->interests != '')
        <p class="text-lg font-bold mt-2">Areas of Interest</p>
        <p class="text-gray-600">{{ $record->interests }}</p>
        @endif

        @if($record->biography != '')
        <p class="text-lg font-bold mt-2">Biography</p>
        <p class="text-gray-600">{{ $record->biography }}</p>
        @endif

    </div>
</x-module>