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
                        <th scope="col" class="px-6 py-4">
                            
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

                            <td class="whitespace-nowrap px-6 py-3">
                                <button id="dropdown{{ $jn->id }}"
                            data-dropdown-toggle="dropdownDots{{ $jn->id }}"
                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900"
                            type="button">
                            <svg class="h-6 w-6 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="1" />
                                <circle cx="19" cy="12" r="1" />
                                <circle cx="5" cy="12" r="1" />
                            </svg>
                        </button>

                        <div id="dropdownDots{{ $jn->id }}"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow ">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdown{{ $jn->id }}">

                                <li>
                                    <button class = "block px-4 py-2 hover:bg-gray-100" wire:loading.attr = "disabled" wire:click = "showRoles({{ $jn->id }})">Assigned Roles</button>
                                </li>

                            </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div>
        <div class="fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform bg-white w-5/12  {{ $isOpen ? 'translate-x-0' : 'translate-x-full' }}"
            style="transition: transform 0.3s ease-in-out;">
            <h5 class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 ">
                <svg class="w-4 h-4 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                Journal Profile Roles
            </h5>

            <button wire:click="closeDrawer"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center  ">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close menu</span>
            </button>

            <hr>
            @if (session('response'))
                @php
                    $bgClass = match (session('response.status')) {
                        'success' => 'bg-green-300',
                        'danger'  => 'bg-red-300',
                        'warning' => 'bg-yellow-300',
                        'info'    => 'bg-blue-300',
                        default   => 'bg-gray-200',
                    };
                @endphp
                <div class="p-4 text-sm mb-4 mt-2 shadow {{ $bgClass }} w-full text-center">
                    {{ session('response.message') }}
                </div>
            @endif
            

            <div class="mb-6">
                <p class="font-bold">Assigned Roles</p>
                <span>Click on the Role to Remove roles assigned</span>
                
                @if($journal_user)
                    <div class="mt-4 gap-4 grid grid-cols-3">
                        @foreach ($journal_user->roles as $key => $role)
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-700 rounded-md shadow-sm cursor-pointer p-2 px-4 text-white"
                                wire:click="removeRoles({{ $role }})" wire:loading.attr="disabled">
                                {{ $role->name }}
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>



            <div class="">
                <p class="font-bold">Unassigned Roles</p>
                <span>Click on the Role to Assign this roles</span>
                
                <div class="mt-4 gap-4 grid grid-cols-3">
                    @foreach ($roles as $key => $role)
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-700 rounded-md shadow-sm cursor-pointer p-2 px-4 text-white"
                            wire:click="assignRoles({{ $role }})" wire:loading.attr="disabled">
                            {{ $role->name }}
                        </button>
                    @endforeach
                </div>
            </div>

        </div>

    </div>
    <!-- Backdrop -->
    <div wire:click="closeDrawer" class="fixed inset-0 bg-black bg-opacity-50 z-40 {{ $isOpen ? 'block' : 'hidden' }}"></div>
</div>
