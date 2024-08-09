<x-module>
    
    <x-slot name="title">
        {{ __('CATEGORIES') }}
    </x-slot>

    @if ($form)
        <div class="w-full border-b pb-4">
            
            <div class="grid grid-cols-3 space-x-2">
                <div class="mt-4">
                    <x-label for="name" value="Name" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="name" class="w-full" wire:model="name" />
                    <x-input-error for="name" />
                </div>

                <div class="mt-4">
                    <x-label for="subject" value="Subject" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="subject" class="w-full" :options="$subjects" wire:model="subject" />
                    <x-input-error for="subject" />
                </div>
                    
                <div class="mt-4">
                    <x-label for="status" value="status" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="status" class="w-full" :options="['1' => 'Active', '0' => 'Inactive']" wire:model="status" />
                    <x-input-error for="status" />
                </div>
            </div>

            <div class="text-right mt-4">
                <x-button type="submit" wire:click="store()" wire:loading.attr="disabled">
                    {{ __('Submit') }}
                </x-button>
                <x-secondary-button class="ml-3" wire:click="$toggle('form')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>
            </div>
        </div>
    @endif

    <div class="w-full grid grid-cols-3 gap-4 mt-2" >
        <div class="">
            <x-input wire:model.live.debounce.500ms="query" placeholder="search..." type="search" />
        </div>
        <div class=""></div>
        <div class="">
            @if (!$form)
            <x-button class="float-right" wire:click="$toggle('form')" wire:loading.attr="disabled" >Create New</x-button>
            @endif
        </div>
    </div>

    <div class="w-full mt-4">
        @foreach ($categories as $data)

            <div class="flex items-center justify-start w-full bg-gray-50 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-2">
                <div class="p-3 w-11/12">
                    <h5 class="text-left font-medium text-gray-900 dark:text-white">{{ $data->name }}</h5>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $data->subject->name }}</span>
                </div>
                <div class="flex justify-end p-3 ">
                    <button id="dropdownBtn{{ $data->id }}" data-dropdown-toggle="dropdown{{ $data->id }}" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                        <span class="sr-only">Open dropdown</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                            <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                        </svg>
                    </button>
                    <div id="dropdown{{ $data->id }}" class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2" aria-labelledby="dropdownBtn{{ $data->id }}">
                            <li>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Edit</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Categories</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        
        @endforeach
    </div>

    <div class="mt-4 w-full">
        {{ $categories->links() }}
    </div>

</x-module>
