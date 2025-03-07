<div class="bg-white shadow-md p-4 rounded">

    <div class="mb-2">
        <p class="font-bold text-xl">{{ __('USER PROFILE') }}</p>
    </div>

    <div class="border-t py-4">
        <div class="flex items-center space-x-4">
            <img class="w-16 h-16 rounded-full" src="{{ asset('storage/favicon/'.'Male.png') }}" alt="Avatar">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    {{ $record->first_name }}
                    {{ $record->middle_name }}
                    {{ $record->last_name }}

                    ({{ $record->affiliation }})

                </h2>
                <p class="text-sm text-gray-500 mb-2">{{ $record->email }}</p>

                @if($record->status == 'Active')
                    <span class="px-2 py-1 bg-green-100 text-green-600 text-xs font-medium rounded-full">Active</span>
                @else
                    <span class="px-2 py-1 bg-red-100 text-red-600 text-xs font-medium rounded-full">Inactive</span>
                @endif
            </div>
        </div>
        <div class="mt-4 flex space-x-4">
            Roles
        </div>

        <div class="mt-4 flex space-x-4">
            Permissions
            
        </div>

        <div class="mt-4 flex space-x-4">
            Journals
        </div>
    </div>
</div>
