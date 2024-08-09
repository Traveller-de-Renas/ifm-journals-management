<x-module>
    
    <x-slot name="title">
        {{ __('JOURNALS') }}
    </x-slot>

    @if ($form)




        
<div class="p-4 w-full">


<ol class="relative text-gray-500 border-s border-gray-200 dark:border-gray-700 dark:text-gray-400">                  
    <li class="mb-10 ms-6">            
        <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                <path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z"/>
            </svg>
        </span>
        <h3 class="font-medium leading-tight">General Information</h3>
        <div class="w-full">
            <div class="mt-4">
                <x-label for="title" value="Title" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input type="text" id="title" class="w-full" wire:model="title" />
                <x-input-error for="title" />
            </div>

            <div class="grid grid-cols-3 space-x-2">
                <div class="mt-4">
                    <x-label for="code" value="Code" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="code" class="w-full" wire:model="code" />
                    <x-input-error for="code" />
                </div>
                <div class="mt-4">
                    <x-label for="issn" value="ISSN" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="issn" class="w-full" wire:model="issn" />
                    <x-input-error for="issn" />
                </div>
                <div class="mt-4">
                    <x-label for="eissn" value="EISSN" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="eissn" class="w-full" wire:model="eissn" />
                    <x-input-error for="eissn" />
                </div>
            </div>
            
            <div class="grid grid-cols-3 space-x-2">
                <div class="mt-4 col-span-2">
                    <x-label for="publisher" value="Publisher" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="publisher" class="w-full" wire:model="publisher" />
                    <x-input-error for="publisher" />
                </div>
                <div class="mt-4">
                    <x-label for="year" value="Year" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="year" class="w-full" wire:model="year" />
                    <x-input-error for="year" />
                </div>
            </div>

            <div class="mt-4" @if(!$form) wire:ignore @endif>
                <x-label for="description" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-textarea type="text" id="description" class="w-full" wire:model="description" />
                <x-input-error for="description" />
            </div>

            <div class="grid grid-cols-3 space-x-2">
                <div class="mt-4">
                    <x-label for="image" value="Image" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input-file type="file" id="image" class="w-full" wire:model="image" />
                    <x-input-error for="image" />
                </div>

                <div class="mt-4">
                    <x-label for="category" value="Category" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="category" class="w-full" :options="$categories" wire:model="category" />
                    <x-input-error for="category" />
                </div>
                    
                <div class="mt-4">
                    <x-label for="status" value="status" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="status" class="w-full" :options="['1' => 'Active', '0' => 'Inactive']" wire:model="status" />
                    <x-input-error for="status" />
                </div>
            </div>

        </div>
    </li>

    <li class="mb-10 ms-6">
        <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
            </svg>
        </span>
        <h3 class="font-medium leading-tight">Journal Instructions</h3>

        @foreach ($instructions as $key => $instruction)
        
        <div class="grid grid-cols-3 gap-4">
            <div class="mt-4 ">
                <x-label for="title" value="Title" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input type="text" id="title" class="w-full" wire:model="title" />
                <x-input-error for="title" />
            </div>

            <div class="mt-4 col-span-2" @if(!$form) wire:ignore @endif>
                <x-label for="description" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-textarea type="text" id="description" class="w-full h-10" wire:model="description" />
                <x-input-error for="description" />
            </div>
        </div>

        @endforeach

        <div class="text-right mt-4">
            <x-button type="button" wire:click="addRows('instructions')" wire:loading.attr="disabled">
                {{ __('Add More Instructions') }}
            </x-button>
        </div>
    </li>
    <li class="ms-6">
        <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z"/>
            </svg>
        </span>
        <h3 class="font-medium leading-tight">Confirmation & Submission</h3>
        <div class="grid grid-cols-2 mt-4">
            <div class="text-sm ">Before submission please check and confirm details of the journal</div>
            <div class="text-right">
                <x-button type="submit" wire:click="store()" wire:loading.attr="disabled">
                    {{ __('Submit') }}
                </x-button>
                <x-secondary-button class="ml-3" wire:click="$toggle('form')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>
            </div>
        </div>
        
    </li>
</ol>

</div>

    @else
        <div class="w-full grid grid-cols-3 gap-4" >
            <div class="">
                <x-input wire:model.live.debounce.500ms="query" placeholder="search..." type="search" />
            </div>
            <div class=""></div>
            <div class="">
                <x-button class="float-right" wire:click="$toggle('form')" wire:loading.attr="disabled" >Create New</x-button>
            </div>
        </div>

        <div class="w-full mt-4">
            @foreach ($journals as $data)

            <div class="flex items-center justify-start w-full bg-gray-50 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700" >
                <div class="p-3 w-11/12 cursor-pointer" wire:click="view_panel({{ $data->id }})">
                    <h5 class="mb-1 text-left font-medium text-gray-900 dark:text-white">{{ $data->title }}</h5>
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

            @if ($panel == $data->id)
                <div class="w-full p-3 bg-gray-200 mb-2 rounded">
                    {{ $data->description }}
                </div>
            @endif

            <div class="mb-3"></div>
            
            @endforeach
        </div>

        <div class="mt-4 w-full">
            {{ $journals->links() }}
        </div>
    @endif


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
            <x-secondary-button class="ml-3" wire:click="$toggle('Edit')" wire:loading.attr="disabled">
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