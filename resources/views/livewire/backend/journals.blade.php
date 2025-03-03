<div class="bg-white shadow-md p-4 rounded">

    <div class="w-full grid grid-cols-3 gap-4" >
        <div class="">
            <p class="font-bold text-xl">{{ __('LIST OF JOURNALS') }}</p>
        </div>
        <div class="col-span-2 flex gap-2 justify-end">
            <x-button class="flex gap-2 items-center" wire:click="$toggle('filters')" >
                <svg class="h-3 w-3 text-white"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <span>Filter Journals</span>
            </x-button>

            {{-- <x-button class="" wire:click="loadJournals()" wire:loading.attr="disabled">Load Data</x-button> --}}

            @if (Auth()->user()->hasPermissionTo('Add Journals'))
                <x-button class="" wire:click="createJournal()" wire:loading.attr="disabled" >Create New</x-button>
            @endif

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
        <div class="p-4 text-sm mb-4 mt-2 shadow {{ $bgClass }} w-full text-center">
            {{ session('response.message') }}
        </div>
    @endif


    <div class="{{ ($filters)? 'block' : 'hidden'}}" >
        <div class="text-sm text-slate-800 ">Subjects</div>
        <ul class="">

            @foreach ($subjects as $key => $subject)
                <li>
                    <label class="flex items-center">
                        <input type="checkbox" class="" wire:click="checkOption('subjects', {{ $subject->id }})" value="{{ $subject->id }}">
                        <span class="text-sm">{{ $subject->name }}</span>
                    </label>
                </li>
            @endforeach
            
        </ul>

        <div class="text-sm text-slate-800 mt-6">Categories</div>
        <ul class="">

            @foreach ($categories as $key => $categ)
                <li>
                    <label class="flex items-center">
                        <input type="checkbox" class="" wire:click="checkOption('categories', {{ $categ->id }})" value="{{ $categ->id }}">
                        <span class="text-sm">{{ $categ->name }}</span>
                    </label>
                </li>
            @endforeach
            
        </ul>
    </div>



    <table class="min-w-full text-left text-sm font-light">
        <thead class="border-b font-medium grey:border-neutral-500">
            <tr>
                <th scope="col" class="px-6 py-4 w-2">#</th>
                <th scope="col" class="px-6 py-4">
                    <button wire:click="sort('title')" >Title</button>
                    <x-sort-icon class="float-right" sortField="title" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                </th>
                <th scope="col" class="px-6 py-4">
                    <button wire:click="sort('code')" >Code</button>
                    <x-sort-icon class="float-right" sortField="code" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                </th>
                <th scope="col" class="px-6 py-4">
                    Chief Editor
                </th>
                <th scope="col" class="px-6 py-4">
                    <button wire:click="sort('status')" >Status</button>
                    <x-sort-icon class="float-right" sortField="status" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                </th>
                <th scope="col" class="py-4 w-2" >
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @php
                $sn = 1;
            @endphp
            @foreach ($journals as $data)
            <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 grey:border-neutral-500 grey:hover:bg-neutral-600">
                <td class="whitespace-nowrap px-6 py-3 font-medium">{{ $sn }}</td>
                <td class="whitespace-nowrap px-6 py-3">{{ $data->title }}</td>
                <td class="whitespace-nowrap px-6 py-3">{{ strtoupper($data->code) }}</td>
                <td class="whitespace-nowrap px-6 py-3">
                    @php
                        $editor = $data->journal_us()->whereHas('roles', function ($query) {
                            $query->where('name', 'Chief Editor');
                        })->first();
                    @endphp
                    
                    @if(!empty($editor))
                        <div class="mb-2">
                            {{ $editor->user->first_name }}
                            {{ $editor->user->middle_name }}
                            {{ $editor->user->last_name }}
                        </div>
                    @else
                        <div class="mb-2">
                            Not Assigned
                        </div>
                    @endif
                </td>
                <td class="whitespace-nowrap px-6 py-3">{{ $data->status() }}</td>
                <td class="whitespace-nowrap ">
                    
                    <button id="dropdown{{ $data->id }}" data-dropdown-toggle="dropdownDots{{ $data->id }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900" type="button">
                        <svg class="h-6 w-6 text-gray-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="1" />  <circle cx="19" cy="12" r="1" />  <circle cx="5" cy="12" r="1" /></svg>
                    </button>
                        
                    <div id="dropdownDots{{ $data->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 border  ">
                        <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdown{{ $data->id }}">
                            <li>
                                <a href="{{ route('journals.create', $data->uuid) }}" class="block px-4 py-2 hover:bg-gray-100 " wire:loading.attr="disabled">Edit</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="confirmView({{ $data->id }})" wire:loading.attr="disabled">View</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="confirmDelete({{ $data->id }})" wire:loading.attr="disabled">Delete</a>
                            </li>
                            <li>
                                <button type="button" class="block px-4 py-2 hover:bg-gray-100 w-full text-left" wire:click="confirmAssign({{ $data->id }})" wire:loading.attr="disabled" >Assign Chief Editor</button>
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

    {{ $journals->links() }}

    <div>
        <div 
            class="fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform bg-white w-5/12 {{ $isOpen ? 'translate-x-0' : 'translate-x-full' }}" 
            style="transition: transform 0.3s ease-in-out;"
        >
            <h5 class="inline-flex items-center mb-4 text-base font-semibold text-gray-500">
                <svg class="w-4 h-4 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                Assign Chief Editor
            </h5>
    
            <button wire:click="closeDrawer" 
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close menu</span>
            </button>

            @if($record)
            <div class="font-bold mb-2">
                {{ $record->title }}
            </div>
            @endif

            <hr>
    
            <p class="mb-6 mt-2 text-sm text-gray-500">
                Search Editor from the List of Users registered or create new user if you can not find the user u want to assign, 
                <br>
                <span class="text-red-600">NOTE</span> : If you assign new user the current one will be removed.
            </p>

            @if($record)
                @php
                    $editor = $record->journal_us()->whereHas('roles', function ($query) {
                        $query->where('name', 'Chief Editor');
                    })->first();
                @endphp
                
                @if(!empty($editor))
                    <p class="mt-2 text-sm text-gray-500"> Currently Assigned Chief Editor is </p>
                    <div class="flex mb-2 font-bold border-t pt-2">
                        <div class="w-full">
                            {{ $editor->user->first_name }}
                            {{ $editor->user->middle_name }}
                            {{ $editor->user->last_name }}
                        </div>
                        <div>
                            <x-button class="bg-red-500 hover:bg-red-700" wire:click="removeUser({{ $editor->id }})">
                                <svg class="h-4 w-4 text-white"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </x-button>
                        </div>
                    </div>
                @else
                    <div class="mb-2">
                        No Chief Editor Assigned to this Journal
                    </div>
                @endif
            @endif

            <div class="mb-2">
                <hr>
            </div>


            <div class="flex justify-end mb-2">
                @if ($create)
                    <x-button class="" wire:click="createnew(false)" wire:loading.attr="disabled" >Search From Users</x-button>
                @else
                    <x-button class="" wire:click="createnew(true)" wire:loading.attr="disabled" >Create New</x-button>
                @endif
                
            </div>

            @if ($create)
                <div class="mb-6">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="">
                            <x-label for="first_name" class="text-xs">{{ __('First Name') }} <span class="text-red-500">*</span></x-label>
                            <x-input id="first_name" type="text" class="w-full" wire:model="first_name" :value="old('first_name')" required autofocus autocomplete="off" />
                            <x-input-error for="first_name" />
                        </div>
        
                        <div class="">
                            <x-label for="middle_name" class="text-xs">{{ __('Middle Name') }} </x-label>
                            <x-input id="middle_name" type="text" class="w-full" wire:model="middle_name" :value="old('middle_name')" required autofocus autocomplete="off" />
                            <x-input-error for="middle_name" />
                        </div>
                    </div>
    
                    <div class="mt-2">
                        <x-label for="last_name" class="text-xs">{{ __('Last Name') }} <span class="text-red-500">*</span></x-label>
                        <x-input id="last_name" type="text" class="w-full" wire:model="last_name" :value="old('last_name')" required autofocus autocomplete="off" />
                        <x-input-error for="last_name" />
                    </div>
        
                    <div class="grid grid-cols-2 gap-2">
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
        
                    <div class="mt-2">
                        <x-label for="gender" value="Gender" class="text-xs text-gray-700" />
                        <x-select id="gender" class="w-full" :options="['Male' => 'Male', 'Female' => 'Female']" wire:model="gender" />
                        <x-input-error for="gender" />
                    </div>
                    
                </div>

                <div class="mt-4 text-right">
                    <x-button class="bg-green-500 hover:bg-green-700" wire:click="createUser()" wire:loading.attr="disabled" >Submit</x-button>
                </div>
                
            @else
                <x-input class="w-full" wire:model="user" wire:keyup="searchUser($event.target.value)" placeholder="Search User" />

                <div>
                    @foreach ($users as $user)
                        <div class="py-2 flex border-b">
                            <div class="w-full">{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</div>
                            <x-button wire:click="assignEditor({{ $user->id }})">Assign</x-button>
                        </div>
                    @endforeach
                </div>

            @endif
        </div>
    
        @if ($isOpen)
            <div wire:click="closeDrawer" class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>
        @endif
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
            
            <x-button type="submit" class="bg-red-500 hover:bg-red-700" wire:click="delete({{ $record }})" wire:loading.attr="disabled" >
                {{ __('Delete') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('Delete')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>

</div>