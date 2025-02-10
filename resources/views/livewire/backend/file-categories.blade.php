<div class="bg-white shadow-md p-4 rounded">

    <div class="w-full grid grid-cols-3 gap-4" >
        <div class="">
            <p class="font-bold">{{ __('FILE CATEGORIES') }}</p>
        </div>
        <div class="">

        </div>
        <div class="flex gap-2 justify-end">
            <x-button class="float-right" wire:click="openDrawer()" wire:loading.attr="disabled" >Create New</x-button>
            <x-input wire:model.live.debounce.500ms="query" placeholder="search..." type="search" />
        </div>
    </div>

    <div class="w-full mt-4">

        <table class="min-w-full text-left text-sm font-light">
            <thead class="border-b font-medium grey:border-neutral-500">
                <tr>
                    <th scope="col" class="px-6 py-4 w-2">#</th>
                    <th scope="col" class="px-6 py-4">
                        <button wire:click="sort('name')" >Name</button>
                        <x-sort-icon class="float-right" sortField="name" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </th>
                    <th scope="col" class="px-6 py-4">
                        <button wire:click="sort('code')" >Code</button>
                        <x-sort-icon class="float-right" sortField="code" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </th>
                    <th scope="col" class="px-6 py-4">
                        <button wire:click="sort('submitted')" >Submitted On</button>
                        <x-sort-icon class="float-right" sortField="submitted" :sort-by="$sortBy" :sort-asc="$sortAsc" />
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
        @foreach ($categories as $data)

        <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 grey:border-neutral-500 grey:hover:bg-neutral-600">
            <td class="whitespace-nowrap px-6 py-3 font-medium">{{ $sn }}</td>
            <td class="whitespace-nowrap px-6 py-3">{{ $data->name }}</td>
            <td class="whitespace-nowrap px-6 py-3">{{ $data->code }}</td>
            <td class="whitespace-nowrap px-6 py-3">{{ $data->submitted }}</td>
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
        {{ $categories->links() }}
    </div>

    <div>
        <div 
            class="fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform bg-white w-5/12 dark:bg-gray-800 {{ $isOpen ? 'translate-x-0' : 'translate-x-full' }}" 
            style="transition: transform 0.3s ease-in-out;"
        >
            <h5 class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                File Categories
            </h5>
    
            <button wire:click="closeDrawer" 
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close menu</span>
            </button>

            <hr>
            
            <div class="w-full border-b pb-4">
                <div class="mt-4 col-span-2">
                    <x-label for="name" value="Name" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="name" class="w-full" wire:model="name" />
                    <x-input-error for="name" />
                </div>

                <div class="mt-4 col-span-2">
                    <x-label for="code" value="code" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="code" class="w-full" wire:model="code" />
                    <x-input-error for="code" />
                </div>

                <div class="mt-4 col-span-2">
                    <x-label for="description" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-textarea type="text" id="description" class="w-full h-10" wire:model="description" />
                    <x-input-error for="description" />
                </div>

                <div class="grid grid-cols-2 space-x-2">
                    <div class="mt-4">
                        <x-label for="submitted" value="Submitted On" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-select id="submitted" class="w-full" :options="['submission' => 'New Submission', 'resubmission' => 'Resubmission']" wire:model="submitted" />
                        <x-input-error for="submitted" />
                    </div>
                    <div class="mt-4">
                        <x-label for="status" value="status" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-select id="status" class="w-full" :options="['1' => 'Active', '0' => 'Inactive']" wire:model="status" />
                        <x-input-error for="status" />
                    </div>
                </div>
    
                <div class="text-right mt-4">
                    @if($record)
                    <x-button type="submit" wire:click="update()" wire:loading.attr="disabled">
                        {{ __('Update') }}
                    </x-button>
                    @else
                    <x-button type="submit" wire:click="store()" wire:loading.attr="disabled">
                        {{ __('Submit') }}
                    </x-button>
                    @endif
                </div>
            </div>
            
        </div>
        
    </div>
        @if ($isOpen)
            <div wire:click="closeDrawer" class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>
        @endif

</div>
