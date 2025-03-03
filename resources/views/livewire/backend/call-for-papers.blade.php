<div class="bg-white shadow-md p-4 rounded">

    <div class="w-full grid grid-cols-3 gap-4" >
        <div class="">
            <p class="font-bold text-xl">{{ __('CALL FOR PAPERS') }}</p>
        </div>
        <div class="">
            
        </div>
        <div class="flex gap-2 justify-end">
            <x-button class="float-right" wire:click="openDrawer()" wire:loading.attr="disabled" >Create New</x-button>
            <x-input wire:model.live.debounce.500ms="query" placeholder="search..." type="search" />
        </div>
    </div>

    @if (session('response'))
        @php
            $bgClass = match (session('response.status')) {
                'success' => 'bg-green-300',
                'danger'  => 'bg-red-300',
                'warning' => 'bg-yellow-300',
                'info'    => 'bg-blue-300',
                default   => 'bg-gray-200',
            };
        @endphp
        <div class="p-4 text-sm mb-4 mt-4 shadow {{ $bgClass }} w-full text-center">
            {{ session('response.message') }}
        </div>
    @endif

    <table class="min-w-full text-left text-sm font-light">
        <thead class="border-b font-medium grey:border-neutral-500">
            <tr>
                <th scope="col" class="px-6 py-4 w-2">#</th>
                <th scope="col" class="px-6 py-4">
                    <button wire:click="sort('title')" >Title</button>
                </th>
                <th scope="col" class="px-6 py-4">
                    <button wire:click="sort('start_date')" >Start Date</button>
                </th>
                <th scope="col" class="px-6 py-4">
                    <button wire:click="sort('end_date')" >End Date</button>
                </th>
                <th scope="col" class="py-4 w-2" ></th>
            </tr>
        </thead>
        <tbody>
            @php
                $sn = 1;
            @endphp
            @foreach ($call as $data)

            <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 grey:border-neutral-500 grey:hover:bg-neutral-600">
                <td class="whitespace-nowrap px-6 py-3 font-medium">{{ $sn }}</td>
                <td class="whitespace-nowrap px-6 py-3">{{ $data->title }}</td>
                <td class="whitespace-nowrap px-6 py-3">{{ $data->start_date }}</td>
                <td class="whitespace-nowrap px-6 py-3">{{ $data->end_date }}</td>
                
                <td class="whitespace-nowrap">
                    <button id="dropdown{{ $data->id }}" data-dropdown-toggle="dropdownDots{{ $data->id }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900" type="button">
                        <svg class="h-6 w-6 text-gray-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="1" />  <circle cx="19" cy="12" r="1" />  <circle cx="5" cy="12" r="1" /></svg>
                    </button>
                        
                    <div id="dropdownDots{{ $data->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 ">
                        <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdown{{ $data->id }}">
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="removeUser({{ $data->id }})" wire:loading.attr="disabled">Remove</a>
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
        {{ $call->links() }}
    </div>

    <div>
        <div class="fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform bg-white w-5/12 {{ $isOpen ? 'translate-x-0' : 'translate-x-full' }}" 
            style="transition: transform 0.3s ease-in-out;"
        >
            <h5 class="inline-flex items-center mb-4 text-base font-semibold text-gray-500">
                <svg class="w-4 h-4 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                Create a Call for Papers
            </h5>
    
            <button wire:click="closeDrawer" 
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close menu</span>
            </button>
    
            <div class="w-full pb-4">
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
                        <x-select id="category" class="w-full" :options="['Journal' => 'Journal', 'Issue' => 'Special Issue']" wire:model="category" />
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
                    <x-label for="image" value="Cover Image" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input-file type="file" id="image" class="w-full" wire:model="image" />
                    <x-input-error for="image" />
                </div>
    
                <div class="text-right mt-8">
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
            
            <x-button type="submit" class="bg-red-500 hover:bg-red-700" wire:click="delete()" wire:loading.attr="disabled" >
                {{ __('Delete') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('deleteModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>
</div>

<script>
    window.addEventListener('contentChanged', (e) => {
        tinymce.remove('#description');
        tinymce.init({
            selector: '#description',
            plugins: 'code advlist lists table link',
            
            height: 300,
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