<div class="bg-white shadow-md p-4 rounded">

    <div class="mb-2">
        <p class="font-bold text-xl">{{ __('USER PROFILE') }}</p>
    </div>

    <div class="border-t py-4">
        <div class="flex items-top space-x-4">
            <div class="w-48 h-48 border rounded-full shadow-lg p-4">
                <img class="w-full h-full rounded-full" src="{{ asset('storage/favicon/'.'Male.png') }}" alt="Avatar">
            </div>
            
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    {{ $record->first_name }}
                    {{ $record->middle_name }}
                    {{ $record->last_name }}

                    ({{ $record->affiliation }})

                </h2>
                <p class="text-sm text-gray-500 mb-2">{{ $record->email }}</p>
                <p class="text-sm text-gray-500 mb-2">{{ $record->country?->name }}</p>
                General User Status : 
                @if($record->status == 'Active')
                    <span class="px-2 py-1 bg-green-100 text-green-600 text-xs font-medium rounded-full">Active</span>
                @else
                    <span class="px-2 py-1 bg-red-100 text-red-600 text-xs font-medium rounded-full">Inactive</span>
                @endif
            </div>
        </div>

        <div class="mt-8">
            <div class="w-full font-semibold">Journals Associated</div>

            <table class="min-w-full text-left text-sm font-light">
                <thead class="border-b font-medium grey:border-neutral-500">
                    <tr>
                        <th scope="col" class="px-6 py-4 w-2">#</th>
                        <th scope="col" class="px-6 py-4">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-4">
                            Code
                        </th>
                        <th scope="col" class="px-6 py-4">
                            Date Joined
                        </th>
                        <th scope="col" class="px-6 py-4">
                            Can Review?
                        </th>
                        <th scope="col" class="px-6 py-4">
                            Account Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($record->journal_us as $key => $jn)
                        <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 grey:border-neutral-500 grey:hover:bg-neutral-600">
                            <td class="whitespace-nowrap px-6 py-3 font-medium">{{ ++$key }}</td>

                            <td class="whitespace-nowrap px-6 py-3">
                                {{ $jn->journal->title }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-3">
                                {{ strtoupper($jn->journal->code) }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-3">
                                {{ $jn->created_at }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-3">
                                @if($jn->can_review == 1)
                                    <span class="px-2 py-1 bg-green-100 text-green-600 text-xs font-medium rounded-full">Yes</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-600 text-xs font-medium rounded-full">No</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-3">
                                @if($jn->status == 1)
                    <span class="px-2 py-1 bg-green-100 text-green-600 text-xs font-medium rounded-full">Active</span>
                @else
                    <span class="px-2 py-1 bg-red-100 text-red-600 text-xs font-medium rounded-full">Inactive</span>
                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
