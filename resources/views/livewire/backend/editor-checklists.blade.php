<div class="bg-white shadow-md p-4 rounded">

    <div class="w-full grid grid-cols-3 gap-4" >
        <div class="">
            <p class="font-bold text-xl">{{ __('EDITOR CHECKLISTS') }}</p>
        </div>
        <div class="">

        </div>
        <div class="flex gap-2 justify-end">
            <x-button class="float-right" wire:click="openDrawer()" wire:loading.attr="disabled" >Create New</x-button>
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

    <div class="w-full mt-4">

        <table class="min-w-full text-left text-sm font-light">
            <thead class="border-b font-medium grey:border-neutral-500">
                <tr>
                    <th scope="col" class="px-6 py-4 w-2">#</th>
                    
                    <th scope="col" class="px-6 py-4">
                        <button wire:click="sort('criteria')" >Criteria</button>
                        <x-sort-icon class="float-right" sortField="criteria" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </th>
                    <th scope="col" class="px-6 py-4">Editorial Process</th>
                    <th scope="col" class="px-6 py-4">
                        <button wire:click="sort('code')" >Code</button>
                        <x-sort-icon class="float-right" sortField="code" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </th>
                    <th scope="col" class="px-6 py-4">
                        <button wire:click="sort('status')" >Status</button>
                        <x-sort-icon class="float-right" sortField="status" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </th>
                    <th scope="col" class="py-4 w-2" ></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sn = 1;
                @endphp
        @foreach ($checklists as $data)

        <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 grey:border-neutral-500 grey:hover:bg-neutral-600">
            <td class="whitespace-nowrap px-6 py-3 font-medium">{{ $sn }}</td>
            
            <td class="whitespace-nowrap px-6 py-3 text-wrap">{{ $data->description }}</td>
            <td class="whitespace-nowrap px-6 py-3 text-wrap">{{ $data->editorialProcess->title }}</td>
            <td class="whitespace-normal px-6 py-3">{{ $data->code }}</td>
            <td class="whitespace-nowrap px-6 py-3">{{ $data->status() }}</td>
            <td class="whitespace-nowrap ">
                
                <button id="dropdown{{ $data->id }}" data-dropdown-toggle="dropdownDots{{ $data->id }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900" type="button">
                    <svg class="h-6 w-6 text-gray-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="1" />  <circle cx="19" cy="12" r="1" />  <circle cx="5" cy="12" r="1" /></svg>
                </button>
                    
                <div id="dropdownDots{{ $data->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 ">
                    <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdown{{ $data->id }}">
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="edit({{ $data->id }})" wire:loading.attr="disabled">Edit</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="openDrawerA({{ $data->id }})" wire:loading.attr="disabled">View</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="confirmDelete({{ $data->id }})" wire:loading.attr="disabled">Delete</a>
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
        {{ $checklists->links() }}
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
                Create Notification Message
            </h5>
    
            <button wire:click="closeDrawer" 
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close menu</span>
            </button>


            <div class="mb-2 w-full">
                <x-label for="editorial_process" value="editorial_process" class="mb-2 block font-medium text-sm text-gray-700" />
                <select id="editorial_process" wire:model="editorial_process" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option selected>Choose Step</option>
                    @foreach ($editorial_processes as $editorial_process)
                        <option value="{{ $editorial_process->id }}" >{{ $editorial_process->title }}</option>
                    @endforeach
                </select>
                <x-input-error for="editorial_process" />
            </div>

            @if(auth()->user()->hasRole('Administrator'))
                <div class="mt-4" wire:ignore>
                    <x-label for="code" value="Code" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="code" class="w-full" wire:model="code" />
                    <x-input-error for="code" />
                </div>
            @endif

            <div class="mb-2 w-full">
                <div class="mt-4">
                    <x-label for="description" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-textarea type="text" id="description" class="w-full" wire:model="description" rows="3" />
                    <x-input-error for="description" />
                </div>
            </div>

            @if ($record != '')
            <x-button class="float-right mt-4" wire:click="update()" wire:loading.attr="disabled" >Update</x-button>
            @else
            <x-button class="float-right mt-4" wire:click="store()" wire:loading.attr="disabled" >Submit</x-button>
            @endif
            
        </div>
        
    </div>
    
    <!-- Backdrop -->
    @if ($isOpen)
        <div wire:click="closeDrawer" class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>
    @endif



    <div>
        <div 
            class="fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform bg-white w-5/12 {{ $isOpenA ? 'translate-x-0' : 'translate-x-full' }}" 
            style="transition: transform 0.3s ease-in-out;"
        >
            <h5 class="inline-flex items-center mb-4 text-base font-semibold text-gray-500">
                <svg class="w-4 h-4 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                Preview Message
            </h5>
    
            <button wire:click="closeDrawerA" 
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close menu</span>
            </button>

            <hr>
            
            <div class="text-justify">
                {!! $record?->description !!}
            </div>

        </div>
        
    </div>
    <!-- Backdrop -->
    <div wire:click="closeDrawerA" class="fixed inset-0 bg-black bg-opacity-50 z-40 {{ $isOpenA ? 'block' : 'hidden' }}"></div>
</div>
