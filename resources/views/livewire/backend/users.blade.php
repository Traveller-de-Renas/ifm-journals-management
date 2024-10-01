<x-module>
    
    <x-slot name="title">
        {{ __('USER LIST') }}
    </x-slot>


    <div class="w-full grid grid-cols-3 gap-4" >
        <div class="">
            <x-input wire:model.live.debounce.500ms="query" placeholder="search..." type="search" />
        </div>
        <div class=""></div>
        <div class="text-right">
        </div>
    </div>

    <table class="min-w-full text-left text-sm font-light">
        <thead class="border-b font-medium grey:border-neutral-500">
            <tr>
                <th scope="col" class="px-6 py-4 w-2">#</th>
                <th scope="col" class="px-6 py-4">
                    <button wire:click="sort('full_name')" >Full Name</button>
                    <x-sort-icon class="float-right" sortField="full_name" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                </th>
                <th scope="col" class="px-6 py-4">
                    <button wire:click="sort('email')" >Email</button>
                    <x-sort-icon class="float-right" sortField="email" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                </th>
                <th scope="col" class="px-6 py-4">
                    <button wire:click="sort('category')" >Category</button>
                    <x-sort-icon class="float-right" sortField="category" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                </th>
                <th scope="col" class="py-4 w-2" >
                    
                </th>
            </tr>
        </thead>
        <tbody>
            @php $sn = 1; @endphp
            @foreach ($users as $item)

            <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 grey:border-neutral-500 grey:hover:bg-neutral-600">
                <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $sn }}</td>
                <td class="whitespace-nowrap px-6 py-4">
                    {{ ucwords(strtolower($item->first_name)) }} 
                    {{ ucwords(strtolower($item->middle_name)) }} 
                    {{ ucwords(strtolower($item->last_name)) }}

                    @if ($item->status == 'Blocked')
                    <p class="text-xs text-red-400">Blocked</p>
                    @endif
                </td>
                <td class="whitespace-nowrap px-6 py-4">{{ $item->email }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $item->category }}</td>
                <td class="whitespace-nowrap ">
                    
                    <button id="dropdown{{ $item->id }}" data-dropdown-toggle="dropdownDots{{ $item->id }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 " type="button">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15"><path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                        </svg>
                    </button>

                    <div id="dropdownDots{{ $item->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 ">
                        <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdown{{ $item->id }}">
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="confirmEdit({{ $item->id }})" wire:loading.attr="disabled">Credentials</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="confirmView({{ $item->id }})" wire:loading.attr="disabled">View</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="confirmDelete({{ $item->id }})" wire:loading.attr="disabled">Delete</a></li>

                            @if( $item->status != 'Blocked')
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="userStatus('Blocked', {{ $item->id }})" wire:loading.attr="disabled">Block User</a></li>
                            @endif

                            @if( $item->status == 'Blocked' )
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="userStatus('Active', {{ $item->id }})" wire:loading.attr="disabled">Unblock User</a></li>
                            @endif
                        </ul>
                    </div>

                </td>
            </tr>
            @php $sn++; @endphp
            @endforeach
        
        </tbody>
    </table>

    <div class="mt-4 w-full">
        {{ $users->links() }}
    </div>

    <x-dialog-modal wire:model="Edit">
        <x-slot name="title">
            {{ __('Edit Credentials') }}
        </x-slot>
        <x-slot name="content">

            <div class="mt-4">
                <x-label for="email" value="Email" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input type="text" id="email" class="w-full" wire:model="email" />
                <x-input-error for="email" />
            </div>

            <div class="grid grid-cols-2 space-x-2">
                <div class="mt-4">
                    <x-label for="password" value="Password" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="password" id="password" class="w-full" wire:model="password" />
                    <x-input-error for="password" />
                </div>
                <div class="mt-4">
                    <x-label for="password_confirmation" value="Password Confirmation" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="password" id="password_confirmation" class="w-full" wire:model="password_confirmation" />
                    <x-input-error for="password_confirmation" />
                </div>
            </div>

        </x-slot>
        <x-slot name="footer">
            
            <x-button type="submit" wire:click="update({{ $record?->id }})" wire:loading.attr="disabled">
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
            
            <x-button-danger type="submit" wire:click="delete({{ $record?->id }})" wire:loading.attr="disabled" >
                {{ __('Delete') }}
            </x-button-danger>
            <x-secondary-button class="ml-3" wire:click="$toggle('Delete')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>


    <x-dialog-modal wire:model="View">
        <x-slot name="title">
            {{ __('User Roles and Permission') }}
        </x-slot>
        <x-slot name="content">
            @if ($user != '')
            <div class="w-full p-2 mb-2">
                <x-label for="file" value="User Full Name" class="mb-2 block font-medium text-sm text-gray-700" />
                {{ $user->name }}

                @if (session('access_msg'))
                    <div class="p-4 rounded-md mb-4 shadow bg-green-300">
                        {{ session('access_msg') }}
                    </div>
                @endif
            </div>

            <div class="w-full p-2 mt-2">
                <form wire:submit.prevent="assign_role">

                    <x-label for="role" value="Role" class="mb-2 block font-medium text-sm text-gray-700" />
                    <div class="w-full mt-2 grid grid-cols-12" >
                        <div class="col-span-9">
                            <x-select id="role" class="w-full" :options="$roles" wire:model="role" />
                            <x-input-error for="role" />
                        </div>
                        <div class="col-span-3 p-1">
                            <x-button type="submit" class="ml-3 w-full" wire:click="assign_role({{ $user->id }})" wire:loading.attr="disabled">
                                {{ __('Associate') }}
                            </x-button>
                        </div>
                    </div>

                </form>
            </div>
            
            <div class="w-full mt-2">
                @foreach ($user->roles as $role)
                    <x-danger-button class="ml-3" wire:click="remove_role({{ $role->id }})" wire:loading.attr="disabled">
                        {{ __($role->name) }}
                    </x-danger-button>
                @endforeach
            </div>



            <div class="w-full p-2 mt-2">
                <form wire:submit.prevent="grant_permission">

                    <x-label for="permission" value="Permission" class="mb-2 block font-medium text-sm text-gray-700" />
                    <div class="w-full mt-2 grid grid-cols-12" >
                        <div class="col-span-9">
                            <x-select id="permission" class="w-full" :options="$permissions" wire:model="permission" />
                            <x-input-error for="permission" />
                        </div>
                        <div class="col-span-3 p-1">
                            <x-button type="submit" class="ml-3 w-full" wire:click="grant_permission({{ $user->id }})" wire:loading.attr="disabled">
                                {{ __('Assign') }}
                            </x-button>
                        </div>
                    </div>

                </form>
            </div>
            
            <div class="w-full mt-2">
                @foreach ($user->permissions as $permission)
                    <x-danger-button class="ml-3 text-center" wire:click="revoke_permission({{ $permission->id }})" wire:loading.attr="disabled">
                        {{ __($permission->name) }}
                    </x-danger-button>
                @endforeach
                
            </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('View')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>

</x-module>