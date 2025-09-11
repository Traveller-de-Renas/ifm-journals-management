
<div class="bg-white shadow-md p-4 rounded">
    <div class="w-full grid grid-cols-3 gap-4" >
        <div class="">
            <p class="font-bold text-xl">{{ __('JOURNAL REVIEWERS') }}</p>
        </div>
        <div class="">

        </div>
        <div class="flex gap-2 justify-end">
            <x-button class="float-right" wire:click="openDrawer()" wire:loading.attr="disabled" >Add Reviewer</x-button>
            <x-input wire:model.live.debounce.500ms="query" placeholder="search..." type="search" />
        </div>
    </div>


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
        <div class="p-4 text-sm mb-4 mt-4 shadow {{ $bgClass }} w-full text-center">
            {{ session('response.message') }}
        </div>
    @endif


    <div class="w-full mt-4">
        <table class="min-w-full text-left text-sm font-light">
            <thead class="border-b font-medium grey:border-neutral-500">
                <tr>
                    <th scope="col" class="px-6 py-4 w-2">#</th>
                    <th scope="col" class="px-6 py-4">
                        <button wire:click="sort('first_name')" >Full Name</button>
                    </th>
                    <th scope="col" class="px-6 py-4">
                        <button >Email</button>
                    </th>
                    <th scope="col" class="px-6 py-4">
                        <button >Affiliation</button>
                    </th>
                    <th scope="col" class="px-6 py-4">
                        <button >Areas of Specialization</button>
                    </th>
                    <th scope="col" class="py-4 w-2" ></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sn = 1;
                    $reviewers = $journal->journal_us()->whereHas('roles', function ($query) {
                        $query->where('name', 'Reviewer');
                    })->get();
                @endphp
                @foreach ($reviewers as $data)

                <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 grey:border-neutral-500 grey:hover:bg-neutral-600">
                    <td class="whitespace-nowrap px-6 py-3 font-medium">{{ $sn }}</td>
                    <td class="whitespace-nowrap px-6 py-3">{{ $data->user->first_name }} {{ $data->user->middle_name }} {{ $data->user->last_name }}</td>
                    
                    <td class="whitespace-nowrap px-6 py-3">
                        {{ $data->user->email }}
                    </td>

                    <td class="whitespace-nowrap px-6 py-3">
                        {{ $data->user->affiliation }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-3">
                        {{ $data->user->areas_of_specialization }}
                    </td>
                    <td class="whitespace-nowrap">
                        <button id="dropdown{{ $data->id }}" data-dropdown-toggle="dropdownDots{{ $data->id }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900" type="button">
                            <svg class="h-6 w-6 text-gray-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="1" />  <circle cx="19" cy="12" r="1" />  <circle cx="5" cy="12" r="1" /></svg>
                        </button>
                            
                        <div id="dropdownDots{{ $data->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 ">
                            <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdown{{ $data->id }}">
                                <li>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="removeUser({{ $data->id }})" wire:loading.attr="disabled">Remove</a>
                                </li>

                                <li>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100" wire:click="updateInfo({{ $data->user->id }})" wire:loading.attr="disabled">Update Info</a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @php
                    $sn++;
                @endphp
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 w-full">
        {{-- {{ $categories->links() }} --}}
    </div>

    <div>
        <div 
            class="fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform bg-white w-5/12 {{ $isOpen ? 'translate-x-0' : 'translate-x-full' }}" 
            style="transition: transform 0.3s ease-in-out;"
        >
            <h5 class="inline-flex items-center mb-4 text-base font-semibold text-gray-500">
                <svg class="w-4 h-4 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                Journal Reviewer
            </h5>
    
            <button wire:click="closeDrawer" 
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close menu</span>
            </button>

            

            <hr>
    
            @if(!$update)
            <p class="mb-6 mt-2 text-sm text-gray-500">
                Search from the List of Users registered or create new user by clicking ADD NEW if you can not find the user u want, 
                <br>
            </p>

            <div class="flex justify-end mb-2">
                @if ($create)
                    <x-button class="" wire:click="createnew(false)" wire:loading.attr="disabled" >Search User</x-button>
                @else
                    <x-button class="" wire:click="createnew(true)" wire:loading.attr="disabled" >Add New</x-button>
                @endif
                
            </div>
            @endif

            @if ($create)
                <div class="mb-6">
                    <div class="mt-4">
                        <x-label for="title" class="text-xs">{{ __('Title') }}</x-label>
                        <x-select id="title" class="w-full" :options="$salutations" wire:model="salutation" />
                        <x-input-error for="title" />
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-2">
                        <div class="">
                            <x-label for="first_name" class="text-xs">{{ __('First Name') }} <span class="text-red-500">*</span></x-label>
                            <x-input id="first_name" type="text" class="w-full" wire:model="first_name" required autofocus autocomplete="off" />
                            <x-input-error for="first_name" />
                        </div>
        
                        <div class="">
                            <x-label for="middle_name" class="text-xs">{{ __('Middle Name') }} </x-label>
                            <x-input id="middle_name" type="text" class="w-full" wire:model="middle_name" required autofocus autocomplete="off" />
                            <x-input-error for="middle_name" />
                        </div>
                    </div>
    
                    <div class="mt-4 grid grid-cols-2 gap-2">
                        <div class="mt-4">
                            <x-label for="last_name" class="text-xs">{{ __('Last Name') }} <span class="text-red-500">*</span></x-label>
                            <x-input id="last_name" type="text" class="w-full" wire:model="last_name" required autofocus autocomplete="off" />
                            <x-input-error for="last_name" />
                        </div>
                        <div class="mt-4">
                            <x-label for="gender" value="Gender" class="text-xs text-gray-700" />
                            <x-select id="gender" class="w-full" :options="['Male' => 'Male', 'Female' => 'Female']" wire:model="gender" />
                            <x-input-error for="gender" />
                        </div>
                    </div>
        
                    <div class="mt-4 grid grid-cols-2 gap-2">
                        <div class="mt-2">
                            <x-label for="email" class="text-xs">{{ __('Email Address') }} <span class="text-red-500">*</span></x-label>
                            <x-input id="email" type="email" class="w-full" wire:model="email" required />
                            <x-input-error for="email" />
                        </div>
                        <div class="mt-2">
                            <x-label for="phone" value="Phone" class="text-xs text-gray-700" />
                            <x-input type="text" id="phone" class="w-full" wire:model="phone" />
                            <x-input-error for="phone" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-label for="affiliation" class="text-xs">{{ __('Affiliation') }} <span class="text-red-500">*</span></x-label>
                        <x-input id="affiliation" type="text" class="w-full" wire:model="affiliation" wire:input="checkAffiliation()"  required autofocus autocomplete="off" />
                        <x-input-error for="affiliation" />

                        @if($affiliation != '')
                            <div class="shadow mt-1 relative">
                                <div class="absolute">
                                    @foreach ($affiliations as $affiliation)
                                        
                                        <div class="text-xs text-gray-700 bg-gray-200 hover:bg-gray-300 cursor-pointer p-2" wire:click="selectAffiliation('{{ $affiliation->affiliation }}')">
                                            {{ $affiliation->affiliation }}
                                        </div>

                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>


                    <div class="mt-4">
                        <x-label for="areas_of_specialization" value="Areas of Specialization (Separate by Semicolon ';')" class="text-xs text-gray-700" />
                        <x-input id="areas_of_specialization" type="text" class="w-full" wire:model="areas_of_specialization" required autocomplete="off" />
                        <x-input-error for="areas_of_specialization" />
                    </div>
                </div>
            @else
                <div class="mb-6">
                    <x-input class="w-full" wire:model="username" wire:keyup="searchUser($event.target.value)" placeholder="Search User" />
                    <div>
                        @foreach ($users as $user)
                            <div class="py-2 flex border-b hover:bg-gray-100" wire:click="selectUser({{ $user->id }})">
                                <div class="w-full px-2">{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif


            @if(!$update)
            <x-button class="float-right" wire:click="store()" wire:loading.attr="disabled" >Submit</x-button>

            @else
            <x-button class="float-right" wire:click="updateMember()" wire:loading.attr="disabled" >Update</x-button>

            @endif
        </div>
        
    </div>
    
        <!-- Backdrop -->
        @if ($isOpen)
            <div wire:click="closeDrawer" class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>
        @endif
    </div>

</div>