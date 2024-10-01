<x-module>
    
    <x-slot name="title">
        {{ __('SOCIAL MEDIA ICONS') }}
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
                    <button wire:click="sort('name')" >Name</button>
                    <x-sort-icon class="float-right" sortField="name" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                </th>
                <th scope="col" class="px-6 py-4">
                    <button wire:click="sort('type')" >Icon Type</button>
                    <x-sort-icon class="float-right" sortField="type" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                </th>
                <th scope="col" class="px-6 py-4">
                    <button wire:click="sort('description')" >Description</button>
                    <x-sort-icon class="float-right" sortField="description" :sort-by="$sortBy" :sort-asc="$sortAsc" />
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
            @foreach ($social_medias as $item)

            <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 grey:border-neutral-500 grey:hover:bg-neutral-600">
                <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $sn }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $item->name }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $item->type }}</td>
                <td class="whitespace-nowrap px-6 py-4 text-justify">{{ Str::words($item->description, '100'); }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $item->status }}</td>
                <td class="whitespace-nowrap ">
                    
                    <button id="dropdown{{ $item->id }}" data-dropdown-toggle="dropdownDots{{ $item->id }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50" type="button">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                        </svg>
                    </button>
                    
                    <div id="dropdownDots{{ $item->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 ">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdown{{ $item->id }}">
                            <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="confirmEdit({{ $item->id }})" wire:loading.attr="disabled">Edit</a>
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
        {{ $social_medias->links() }}
    </div>

    <x-dialog-modal wire:model="Add">
        <x-slot name="title">
            {{ __('Create New') }}
        </x-slot>
        <x-slot name="content">
            <div class="mt-4">
                <x-label for="name" value="Name" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input type="text" id="name" class="w-full" wire:model="name" />
                <x-input-error for="name" />
            </div>

            <div class="mt-4">
                <x-label for="type" value="Type" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-select id="type" class="w-full" :options="['svg' => 'svg', 'image' => 'image']" wire:model="type" wire:change="iconFX($event.target.value)" />
                <x-input-error for="type" />
            </div>

            @if($show == 'svg')
            <div class="mt-4" wire:ignore>
                <x-label for="icon" value="SVG Icon" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-textarea type="text" id="icon" class="w-full" wire:model="icon" />
                <x-input-error for="icon" />
            </div>

            @else

            <div class="mt-4">
                <x-label for="image" value="Image" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input-file type="file" id="image" class="w-full" wire:model="image" />
                <x-input-error for="image" />
            </div>

            @endif

            <div class="mt-4" wire:ignore>
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
                <x-label for="name" value="Name" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input type="text" id="name" class="w-full" wire:model="name" />
                <x-input-error for="name" />
            </div>

            <div class="mt-4">
                <x-label for="type" value="Type" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-select id="type" class="w-full" :options="['svg' => 'svg', 'image' => 'image']" wire:model="type" wire:change="iconFX($event.target.value)" />
                <x-input-error for="type" />
            </div>

            @if($show == 'svg')
            <div class="mt-4" wire:ignore>
                <x-label for="icon" value="SVG Icon" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-textarea type="text" id="icon" class="w-full" wire:model="icon" />
                <x-input-error for="icon" />
            </div>

            @else

            <div class="mt-4">
                <x-label for="image" value="Image" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input-file type="file" id="image" class="w-full" wire:model="image" />
                <x-input-error for="image" />
            </div>

            @endif

            <div class="mt-4" wire:ignore>
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
            
            <x-button-danger type="submit" wire:click="delete({{ $record }})" wire:loading.attr="disabled" >
                {{ __('Delete') }}
            </x-button-danger>
            <x-secondary-button class="ml-3" wire:click="$toggle('Delete')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>

</x-module>

<script>
    window.addEventListener('contentChanged', (e) => {
        tinymce.init({
            selector: '#description',
            plugins: 'code advlist lists table link',
            
            /* TinyMCE configuration options */
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
                    @this.set('description', editor.getContent());
                });
            },
        });
    });
</script>