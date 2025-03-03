<div class="bg-white shadow-md p-4 rounded">

    <div class="w-full grid grid-cols-3 gap-4" >
        <div class="">
            <p class="font-bold text-xl">{{ __('ACTIVITY LOG') }}</p>
        </div>
        <div class="">

        </div>
        <div class="flex gap-2 justify-end">
            <x-button class="float-right" wire:click="confirmAdd" wire:loading.attr="disabled" >Create New</x-button>
            <x-input wire:model.live.debounce.500ms="query" placeholder="search..." type="search" />
        </div>
    </div>

    <table class="min-w-full text-left text-sm font-light">
        <thead class="border-b font-medium grey:border-neutral-500">
            <tr>
                <th scope="col" class="px-6 py-4 w-2">#</th>
                <th scope="col" class="px-6 py-4">
                    <button wire:click="sort('description')" >Description</button>
                    <x-sort-icon class="float-right" sortField="description" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                </th>
                <th scope="col" class="py-4 w-2" ></th>
            </tr>
        </thead>
        <tbody>
            @php
                $sn = 1;
            @endphp
            @foreach ($users as $item)

            <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 grey:border-neutral-500 grey:hover:bg-neutral-600">
                <td class="whitespace-nowrap px-6 py-4 font-medium align-top">{{ $sn }}</td>
                <td class="whitespace-nowrap px-6 py-4 text-wrap">
                    <div class="grid grid-cols-12 text-xs text-blue-700">
                        <div class="col-span-2">Date, Time </div>
                        <div class="col-span-10"> {{ $item->created_at }} </div>
                    </div>

                    <div class="grid grid-cols-12 text-xs text-red-600">
                        <div class="col-span-2">Causer </div> 
                        <div class="col-span-10"> 
                            @if($item->causer != '')
                            {{ $item->causer->name }} 
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-12 text-xs text-green-600">
                        <div class="col-span-2">Description </div> 
                        <div class="col-span-10"> {{ $item->description }} </div>
                    </div>
                    
                    @foreach($item->properties as $key => $value)
                        <div class="text-xs text-orange-500 mt-2 border-b">{{ ucwords($key) }}</div>
                        @foreach($value as $keyx => $valuex)
                        <div class="grid grid-cols-12 text-xs">
                            <div class="col-span-2">{{ $keyx }} </div> 
                            <div class="col-span-10 text-wrap"> {{ $valuex }} </div>
                        </div>
                        @endforeach
                    @endforeach
                </td>
                <td class="whitespace-nowrap px-6 py-4 align-top">
                    
                    {{-- <button id="dropdown{{ $item->id }}" data-dropdown-toggle="dropdownDots{{ $item->id }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900" type="button">
                        <svg class="h-6 w-6 text-gray-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="1" />  <circle cx="19" cy="12" r="1" />  <circle cx="5" cy="12" r="1" /></svg>
                    </button>
                        
                    <div id="dropdownDots{{ $item->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 ">
                        <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdown{{ $item->id }}">
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="confirmView({{ $item->id }})" wire:loading.attr="disabled">View</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="confirmDelete({{ $item->id }})" wire:loading.attr="disabled">Delete</a>
                            </li>
                        </ul>
                    </div> --}}

                </td>
            </tr>
            @php
                $sn++;
            @endphp
            @endforeach
        
        </tbody>
    </table>

    <div class="mt-4 w-full">
        {{ $users->links() }}
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
            <x-secondary-button class="ml-3" wire:click="$toggle('Edit')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>


    <x-dialog-modal wire:model="View">
        <x-slot name="title">
            {{ __('User Activity Logs') }}
        </x-slot>
        <x-slot name="content">
            @if ($user != '')
            
            <div class="w-full mt-2">
                @foreach ($user->roles as $role)
                    <x-button class="ml-3" wire:click="remove_role({{ $role->id }})" wire:loading.attr="disabled">
                        {{ __($role->name) }}
                    </x-button>
                @endforeach
            </div>
            
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingView')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>

</div>