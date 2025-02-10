<div class="bg-white shadow-md p-4 rounded">
    {{ __('SALUTATIONS') }}

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
                    <button wire:click="sort('title')" >Title</button>
                    <x-sort-icon class="float-right" sortField="title" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                </th>
                <th scope="col" class="px-6 py-4">
                    <button wire:click="sort('description')" >Description</button>
                    <x-sort-icon class="float-right" sortField="description" :sort-by="$sortBy" :sort-asc="$sortAsc" />
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
            @foreach ($salutations as $item)

            <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 grey:border-neutral-500 grey:hover:bg-neutral-600">
                <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $sn }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $item->title }}</td>
                <td class="whitespace-nowrap px-6 py-4 text-justify">{{ Str::words($item->description, '100'); }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $item->status() }}</td>
                <td class="whitespace-nowrap ">
                    
                    <button id="dropdown{{ $item->id }}" data-dropdown-toggle="dropdownDots{{ $item->id }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900" type="button">
                        <svg class="h-6 w-6 text-gray-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="1" />  <circle cx="19" cy="12" r="1" />  <circle cx="5" cy="12" r="1" /></svg>
                    </button>
                    
                    <div id="dropdownDots{{ $item->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                        <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdown{{ $item->id }}">
                            <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100" wire:click="confirmEdit({{ $item->id }})" wire:loading.attr="disabled">Edit</a>
                            </li>
                            <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100" wire:click="confirmDelete({{ $item->id }})" wire:loading.attr="disabled">Delete</a>
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
        {{ $salutations->links() }}
    </div>


    <x-dialog-modal wire:model="Add">
        <x-slot name="title">
            {{ __('Create New') }}
        </x-slot>
        <x-slot name="content">
            <div class="mt-4">
                <x-label for="language" value="Language" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-select id="language" class="w-full" :options="['en' => 'English', 'sw' => 'Swahili']" wire:model="language" />
                <x-input-error for="language" />
            </div>

            <div class="mt-4">
                <x-label for="title" value="Title" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input type="text" id="title" class="w-full" wire:model="title" />
                <x-input-error for="title" />
            </div>

            <div class="mt-4">
                <x-label for="description" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-textarea type="text" id="description" class="w-full" wire:model="description" />
                <x-input-error for="description" />
            </div>

            <div class="mt-4">
                <x-label for="status" value="status" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-select id="status" class="w-full" :options="['1' => 'Active', '0' => 'Inactive']" wire:model="status" />
                <x-input-error for="status" />
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
                <x-label for="language" value="Language" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-select id="language" class="w-full" :options="['en' => 'English', 'sw' => 'Swahili']" wire:model="language" />
                <x-input-error for="language" />
            </div>

            <div class="mt-4">
                <x-label for="title" value="Title" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input type="text" id="title" class="w-full" wire:model="title" />
                <x-input-error for="title" />
            </div>

            <div class="mt-4">
                <x-label for="description" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-textarea type="text" id="description" class="w-full" wire:model="description" />
                <x-input-error for="description" />
            </div>

            <div class="mt-4">
                <x-label for="status" value="status" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-select id="status" class="w-full" :options="['1' => 'Active', '0' => 'Inactive']" wire:model="status" />
                <x-input-error for="status" />
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
            
            <x-button type="submit" class="bg-red-500 hover:bg-red-700" wire:click="delete({{ $record }})" wire:loading.attr="disabled" >
                {{ __('Delete') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('Edit')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>

</div>