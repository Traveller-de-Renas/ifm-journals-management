<x-module>
    
    <x-slot name="title">
        {{ __('SLIDING IMAGES') }}
    </x-slot>


    <div class="w-full grid grid-cols-3 gap-4" >
        <div class="">
            <x-input wire:model.live.debounce.500ms="query" placeholder="search..." type="search" />
        </div>
        <div class=""></div>
        <div class="">
            <x-button class="float-right" wire:click="confirmAdd" wire:loading.attr="disabled" >Create New</x-button>
        </div>
    </div>

    <table class="min-w-full text-left text-sm font-light">
        <thead class="border-b font-medium grey:border-neutral-500">
            <tr>
                <th scope="col" class="px-6 py-4 w-2">#</th>
                <th scope="col" class="px-6 py-4">
                    <button wire:click="sort('image')" >Image</button>
                    <x-sort-icon class="float-right" sortField="image" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                </th>
                <th scope="col" class="px-6 py-4">
                    <button wire:click="sort('order')" >Order</button>
                    <x-sort-icon class="float-right" sortField="order" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                </th>
                <th scope="col" class="px-6 py-4">
                    <button wire:click="sort('caption')" >Caption</button>
                    <x-sort-icon class="float-right" sortField="caption" :sort-by="$sortBy" :sort-asc="$sortAsc" />
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
            @foreach ($sliding_images as $item)
            

            <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 grey:border-neutral-500 grey:hover:bg-neutral-600">
                <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $sn }}</td>
                <td class="whitespace-nowrap px-6 py-4">
                    {{ $item->image }}
                    <p class="text-xs text-blue-700">{{ $item->url }}</p>
                </td>
                <td class="whitespace-nowrap px-6 py-4">{{ $item->order }}</td>
                <td class="whitespace-nowrap px-6 py-4 text-justify">{{ Str::words($item->caption, '100'); }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $item->status }}</td>
                <td class="whitespace-nowrap ">
                    
                    <button id="dropdown{{ $item->id }}" data-dropdown-toggle="dropdownDots{{ $item->id }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50" type="button">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                        </svg>
                    </button>
                    
                    <!-- Dropdown menu -->
                    <div id="dropdownDots{{ $item->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdown{{ $item->id }}">
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="confirmEdit({{ $item->id }})" wire:loading.attr="disabled">Edit</a>
                            </li>
                            <li>
                                <a href="{{ asset('storage/slider/'.$item->image) }}" target="_blank" class="block px-4 py-2 hover:bg-gray-100" wire:loading.attr="disabled">View</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="confirmDelete({{ $item->id }})" wire:loading.attr="disabled">Delete</a>
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

    <div class="mt-4 w-full">
        {{ $sliding_images->links() }}
    </div>

    <x-dialog-modal wire:model="Add">
        <x-slot name="title">
            {{ __('Create New') }}
        </x-slot>
        <x-slot name="content">

            <div class="mt-4">
                <x-label for="images" value="Images" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input-file type="file" id="images" class="w-full" wire:model="images" multiple="" />
                <x-input-error for="images" />
            </div>

            <div class="mt-4">
                <x-label for="caption" value="Caption" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-textarea type="text" id="caption" class="w-full" wire:model="caption" />
                <x-input-error for="caption" />
            </div>

            <div class="mt-4">
                <x-label for="url" value="Redirect Url" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input type="text" id="url" class="w-full" wire:model="url" />
                <x-input-error for="url" />
            </div>

            <div class="grid grid-cols-2 justify-between space-x-2">
                <div class="mt-4">
                    <x-label for="order" value="Order" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="order" class="w-full" wire:model="order" />
                    <x-input-error for="order" />
                </div>
                <div class="mt-4">
                    <x-label for="status" value="status" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="status" class="w-full" :options="['1' => 'Active', '0' => 'Inactive']" wire:model="status" />
                    <x-input-error for="status" />
                </div>
            </div>
            
        </x-slot>
        <x-slot name="footer">
            
            <x-button type="submit" wire:click="store()" wire:loading.attr="disabled">
                {{ __('Submit') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('Add')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="Edit">
        <x-slot name="title">
            {{ __('Edit Data') }}
        </x-slot>
        <x-slot name="content">
            
            <div class="mt-4">
                <x-label for="images" value="Images" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input-file type="file" id="images" class="w-full" wire:model="images" />
                <x-input-error for="images" />
            </div>

            <div class="mt-4">
                <x-label for="caption" value="Caption" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-textarea type="text" id="caption" class="w-full" wire:model="caption" />
                <x-input-error for="caption" />
            </div>

            <div class="mt-4">
                <x-label for="url" value="Redirect Url" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input type="text" id="url" class="w-full" wire:model="url" />
                <x-input-error for="url" />
            </div>

            <div class="grid grid-cols-2 justify-between space-x-2">
                <div class="mt-4">
                    <x-label for="order" value="Order" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="order" class="w-full" wire:model="order" />
                    <x-input-error for="order" />
                </div>
                <div class="mt-4">
                    <x-label for="status" value="status" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="status" class="w-full" :options="['1' => 'Active', '0' => 'Inactive']" wire:model="status" />
                    <x-input-error for="status" />
                </div>
            </div>

        </x-slot>
        <x-slot name="footer">
            
            <x-button type="submit" wire:click="update({{ $record }})" wire:loading.attr="disabled">
                {{ __('Submit') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('Edit')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>


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
            
            <x-button-danger type="submit" wire:click="delete({{ $record }})" wire:loading.attr="disabled" >
                {{ __('Delete') }}
            </x-button-danger>
            <x-secondary-button class="ml-3" wire:click="$toggle('Delete')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>

</x-module>