<x-module>
    
    <x-slot name="title">
        {{ __('CALL FOR PAPERS') }}
    </x-slot>

    <div class="@if (!$form) hidden @endif">
        <div class="w-full border-b pb-4">
            <div class="mt-4">
                <x-label for="journal" value="Journal" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-select id="journal" class="w-full" :options="$journals" wire:model="journal" />
                <x-input-error for="journal" />
            </div>

            <div class="mt-4">
                <x-label for="title" value="Title" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input type="text" id="title" class="w-full" wire:model="title" />
                <x-input-error for="title" />
            </div>

            <div class="mt-4" wire:ignore>
                <x-label for="description" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-textarea type="text" id="description" class="w-full" wire:model="description" placeholder="Enter Description" rows="7" />
                <x-input-error for="description" />
            </div>
            
            <div class="grid grid-cols-3 space-x-2">
                
                <div class="mt-4">
                    <x-label for="category" value="Category" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="category" class="w-full" :options="['Journal' => 'Journal', 'Issue' => 'Issue']" wire:model="category" />
                    <x-input-error for="category" />
                </div>
                    
                <div class="mt-4">
                    <x-label for="start_date" value="Start Date" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="date" id="start_date" class="w-full" wire:model="start_date" />
                    <x-input-error for="start_date" />
                </div>

                <div class="mt-4">
                    <x-label for="end_date" value="End Date" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="date" id="end_date" class="w-full" wire:model="end_date" />
                    <x-input-error for="end_date" />
                </div>
            </div>

            <div class="mt-4">
                <x-label for="image" value="Image" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input-file type="file" id="image" class="w-full" wire:model="image" />
                <x-input-error for="image" />
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
                <x-secondary-button class="ml-3" wire:click="$toggle('form')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>
            </div>
        </div>
    </div>

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
        @foreach ($call as $data)

            <div class="flex items-center justify-start w-full border border-gray-200 rounded-lg shadow mb-2">
                <div class="p-3 w-full">
                    <h5 class="text-left font-bold font-xl text-gray-900 dark:text-white">{{ $data->title }}</h5>
                    <p>Category : {{ $data->category }}</p>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        {{ Str::words(strip_tags($data->description), '60'); }}
                    </span>

                   
                    <div class="text-right">
                        <x-button wire:click="edit({{ $data->id }})">Edit</x-button>
                    
                        <a href="{{ route('journal.call_detail', $data->uuid) }}">
                            <x-button>Preview</x-button>
                        </a>
                    
                        <x-button-plain class="bg-red-700 hover:bg-red-600 " wire:click="confirmDelete({{ $data->id }})">Delete</x-button-plain>
                    </div>
                   
                </div>
            </div>
        
        @endforeach
    </div>

    <div class="mt-4 w-full">
        {{ $call->links() }}
    </div>

    <x-dialog-modal wire:model="deleteModal">
        <x-slot name="title">
            {{ __('Delete Data') }}
        </x-slot>
        <x-slot name="content">
            <div class="mt-4">
                <p class="text-center">Are you sure you want to delete this record.?</p>
            </div>
        </x-slot>
        <x-slot name="footer">
            
            <x-button-danger type="submit" wire:click="delete()" wire:loading.attr="disabled" >
                {{ __('Delete') }}
            </x-button-danger>
            <x-secondary-button class="ml-3" wire:click="$toggle('deleteModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>
</x-module>


<script>
    window.addEventListener('contentChanged', (e) => {
        tinymce.remove('#description');
        tinymce.init({
            selector: '#description',
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
                    @this.set('description', editor.getContent());
                });
            },
        });
    
        
    });

</script>