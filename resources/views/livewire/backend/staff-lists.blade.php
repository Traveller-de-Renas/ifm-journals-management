<x-module>
    
    <x-slot name="title">
        {{ __('STAFF LIST') }}
    </x-slot>


    <div class="w-full grid grid-cols-3 gap-4" >
        <div class="">
            <x-input wire:model.live.debounce.500ms="query" placeholder="search..." type="search" />
        </div>
        <div class="">
            <div wire:loading wire:target="from_ems">

                <div role="status">
                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
        
            </div>
        </div>
        <div class="text-right">
            <x-button class="" wire:click="from_ems" wire:loading.attr="disabled" >Pull From EMS</x-button>
            <!-- <x-button class="" wire:click="updateUuid" wire:loading.attr="disabled" >Update Uuids</x-button> -->
            <x-button class="" wire:click="add()" wire:loading.attr="disabled" >Create New</x-button>
        </div>
    </div>


    <div class="w-full border-b pb-4 @if(!$form) hidden @endif" >

            <div class="mt-4">
                <x-label for="salutation" value="Salutation" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-select id="salutation" class="w-full" :options="$salutations" :selected="$salutation" wire:model="salutation" />
                <x-input-error for="salutation" />
            </div>

            <div class="grid grid-cols-3 space-x-2">
                <div class="mt-4">
                    <x-label for="first_name" value="First Name" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="first_name" class="w-full" wire:model="first_name" />
                    <x-input-error for="first_name" />
                </div>
                <div class="mt-4">
                    <x-label for="middle_name" value="Middle Name" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="middle_name" class="w-full" wire:model="middle_name" />
                    <x-input-error for="middle_name" />
                </div>
                <div class="mt-4">
                    <x-label for="last_name" value="Last Name" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="last_name" class="w-full" wire:model="last_name" />
                    <x-input-error for="last_name" />
                </div>
            </div>

            <div class="grid grid-cols-3 space-x-2">
                <div class="mt-4">
                    <x-label for="email" value="Email" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="email" class="w-full" wire:model="email" />
                    <x-input-error for="email" />
                </div>
                <div class="mt-4">
                    <x-label for="phone" value="Phone" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="phone" class="w-full" wire:model="phone" />
                    <x-input-error for="phone" />
                </div>
                <div class="mt-4">
                    <x-label for="box" value="Box" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="box" class="w-full" wire:model="box" />
                    <x-input-error for="box" />
                </div>
            </div>

            <div class="mt-4" wire:ignore>
                <x-label for="bio" value="Bio" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-textarea type="text" id="bio" class="w-full" wire:model="bio" />
                <x-input-error for="bio" />
            </div>

            <div class="grid grid-cols-2 space-x-2">
                <div class="mt-4">
                    <x-label for="faculty" value="Faculty" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="faculty" class="w-full" :options="$faculties" :selected="$faculty" wire:model="faculty" />
                    <x-input-error for="faculty" />
                </div>
                <div class="mt-4">
                    <x-label for="campus" value="Campus" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="campus" class="w-full" :options="$campuses" :selected="$campus" wire:model="campus" />
                    <x-input-error for="campus" />
                </div>
            </div>


            <div class="grid grid-cols-2 space-x-2">
                <div class="mt-4">
                    <x-label for="gender" value="Gender" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="gender" class="w-full" :options="['Male' => 'Male', 'Female' => 'Female']" wire:model="gender" />
                    <x-input-error for="gender" />
                </div>
                <div class="mt-4">
                    <x-label for="nationality" value="Nationality" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="nationality" class="w-full" wire:model="nationality" />
                    <x-input-error for="nationality" />
                </div>
            </div>

            <div class="grid grid-cols-2 space-x-2">
                <div class="mt-4">
                    <x-label for="picture" value="Picture" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input-file type="file" id="picture" class="w-full" wire:model="picture" />
                    <x-input-error for="picture" />
                </div>
                <div class="mt-4">
                    <x-label for="status" value="status" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="status" class="w-full" :options="['1' => 'Active', '0' => 'Inactive']" wire:model="status" />
                    <x-input-error for="status" />
                </div>
            </div>

            <div class="text-right mt-4">

                @if (!empty($record))
                    <x-button type="submit" wire:click="update({{ $record->id }})" wire:loading.attr="disabled">
                        {{ __('Update') }}
                    </x-button>
                @else
                    <x-button type="submit" wire:click="store()" wire:loading.attr="disabled">
                        {{ __('Submit') }}
                    </x-button>
                @endif
                
                <x-secondary-button class="ml-3" wire:click="$toggle('form')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>
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
                    <button wire:click="sort('campus')" >Campus</button>
                    <x-sort-icon class="float-right" sortField="campus" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                </th>
                <th scope="col" class="px-6 py-4">
                    Office
                </th>
                <th scope="col" class="px-6 py-4">
                    <button wire:click="sort('status')" >Status</button>
                    <x-sort-icon class="float-right" sortField="status" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                </th>
                <th scope="col" class="px-4 py-4 w-2 text-center" >
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @php
                $sn = 1;
            @endphp
            @foreach ($staff_list as $item)

            <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 grey:border-neutral-500 grey:hover:bg-neutral-600">
                <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $sn }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $item->salutation?->title }}. {{ ucwords(strtolower($item->full_name)) }}</td>
                <td class="px-6 py-4">{{ $item->email }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $item->campus?->name }}</td>
                <td class="px-6 py-4">{{ $item->office }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $item->status }}</td>
                <td class="px-4">



                   



                    <div class="inline-flex rounded-md shadow-sm" role="group">
                        <button type="button" class="p-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700" wire:click="edit({{ $item->id }})" wire:loading.attr="disabled">
                            <svg class="h-4 w-4 text-gray-500"  viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" /></svg>
                        </button>
                        <button type="button" class="p-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700" wire:click="confirmDelete({{ $item->id }})" wire:loading.attr="disabled">
                            <svg class="h-4 w-4 text-gray-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="3 6 5 6 21 6" />  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" /></svg>
                        </button>
                    </div>
                    
                    {{-- <button id="dropdown{{ $item->id }}{{ $sn }}" data-dropdown-toggle="dropdownDots{{ $item->id }}{{ $sn }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50" type="button">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                            <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                        </svg>
                    </button>
                    
                    <!-- Dropdown menu -->
                    <div id="dropdownDots{{ $item->id }}{{ $sn }}" class="hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdown{{ $item->id }}{{ $sn }}">
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100" wire:click="edit({{ $item->id }})" wire:loading.attr="disabled">Edit</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100" wire:click="confirmDelete({{ $item->id }})" wire:loading.attr="disabled">Delete</a>
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
        {{ $staff_list->links() }}
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
            
            <x-button-danger type="submit" wire:click="delete({{ $record?->id }})" wire:loading.attr="disabled" >
                {{ __('Delete') }}
            </x-button-danger>

            <x-secondary-button class="ml-3" wire:click="$toggle('Edit')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>

</x-module>

<script>
    window.addEventListener('editor', (e) => {
        tinymce.remove('#bio');
        tinymce.init({
            selector: '#bio',
            plugins: 'code advlist lists table link',
            
            height: 200,
            skin: false,
            content_css: false,
            advlist_bullet_styles: 'disc,circle,square',
            advlist_number_styles: 'default,lower-alpha,lower-roman,upper-alpha,upper-roman',
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons | code',
            
            setup: function (editor) {
                editor.on('init change', function () {
                    editor.save();
                });
                editor.on('change', function (e) {
                    @this.set('bio', editor.getContent());
                });
            },
        });
    });
</script>