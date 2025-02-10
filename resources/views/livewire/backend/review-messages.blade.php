<div class="bg-white shadow-md p-4 rounded">

    <div class="w-full grid grid-cols-3 gap-4" >
        <div class="">
            <p class="font-bold">{{ __('CUSTOMIZED REVIEW MESSAGES') }}</p>
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
        <div class="p-4 text-sm mb-4 mt-2 shadow {{ $bgClass }} w-full text-center">
            {{ session('response.message') }}
        </div>
    @endif

    <div class="w-full mt-4">

        <table class="min-w-full text-left text-sm font-light">
            <thead class="border-b font-medium grey:border-neutral-500">
                <tr>
                    <th scope="col" class="px-6 py-4 w-2">#</th>
                    
                    <th scope="col" class="px-6 py-4">
                        <button wire:click="sort('category')" >Category</button>
                        <x-sort-icon class="float-right" sortField="category" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </th>
                    <th scope="col" class="px-6 py-4">
                        <button wire:click="sort('code')" >Code</button>
                        <x-sort-icon class="float-right" sortField="code" :sort-by="$sortBy" :sort-asc="$sortAsc" />
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
        @foreach ($messages as $data)

        <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 grey:border-neutral-500 grey:hover:bg-neutral-600">
            <td class="whitespace-nowrap px-6 py-3 font-medium">{{ $sn }}</td>
            
            <td class="whitespace-nowrap px-6 py-3">{{ $data->category }}</td>
            <td class="whitespace-normal px-6 py-3">{{ $data->code }}</td>
            <td class="whitespace-nowrap px-6 py-3">{{ $data->status() }}</td>
            <td class="whitespace-nowrap ">
                
                <button id="dropdown{{ $data->id }}" data-dropdown-toggle="dropdownDots{{ $data->id }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900" type="button">
                    <svg class="h-6 w-6 text-gray-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="1" />  <circle cx="19" cy="12" r="1" />  <circle cx="5" cy="12" r="1" /></svg>
                </button>
                    
                <div id="dropdownDots{{ $data->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 ">
                    <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdown{{ $data->id }}">
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="edit({{ $data->id }})" wire:loading.attr="disabled">Edit</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="openDrawerA({{ $data->id }})" wire:loading.attr="disabled">View</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="confirmDelete({{ $data->id }})" wire:loading.attr="disabled">Delete</a>
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
    </div>

    <div class="mt-4 w-full">
        {{ $messages->links() }}
    </div>

    <div>
        <div 
            class="fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform bg-white w-5/12 dark:bg-gray-800 {{ $isOpen ? 'translate-x-0' : 'translate-x-full' }}" 
            style="transition: transform 0.3s ease-in-out;"
        >
            <h5 class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                Create Review Message
            </h5>
    
            <button wire:click="closeDrawer" 
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close menu</span>
            </button>


            <div class="mb-2 w-full">
                <x-label for="category" value="Category" class="mb-2 block font-medium text-sm text-gray-700" />
                <select id="category" wire:model="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option selected>Choose a category</option>
                    <option value="Journal Account">{{ __('Journal Account') }}</option>
                    <option value="Submission">{{ __('Submission') }}</option>
                    <option value="Article Revisions">{{ __('Article Revisions') }}</option>
                    <option value="Article Rejection">{{ __('Article Rejection') }}</option>
                    <option value="Article Assignment">{{ __('Article Assignment') }}</option>
                    <option value="Review Request">{{ __('Review Request') }}</option>
                    <option value="Review Reminder">{{ __('Review Reminder') }}</option>
                    <option value="Acceptance Letter">{{ __('Acceptance Letter') }}</option>
                    <option value="Completed Review">{{ __('Completed Review') }}</option>
                    <option value="Declined Review">{{ __('Declined Review') }}</option>
                    <option value="Call for Papers">{{ __('Call for Papers') }}</option>

                    <option value="Assign Chief Editor">{{ __('Assign Chief Editor') }}</option>
                    <option value="Add Associate Editor">{{ __('Add Associate Editor') }}</option>
                    <option value="Add Supporting Editor">{{ __('Add Supporting Editor') }}</option>
                    <option value="Access Credentials">{{ __('Access Credentials') }}</option>


                </select>
                <x-input-error for="category" />
            </div>

            

            <div class="mb-2 w-full">

                <div class="mt-4" wire:ignore>
                    <x-label for="description" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-textarea type="text" id="description" class="w-full" wire:model="description" rows="6" />
                    <x-input-error for="description" />
                </div>

            </div>

            @if ($record != '')
            <x-button class="float-right mt-4" wire:click="update()" wire:loading.attr="disabled" >Update</x-button>
            @else
            <x-button class="float-right mt-4" wire:click="store()" wire:loading.attr="disabled" >Submit</x-button>
            @endif
            
        </div>
        
    </div>
    
    <!-- Backdrop -->
    @if ($isOpen)
        <div wire:click="closeDrawer" class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>
    @endif



    <div>
        <div 
            class="fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform bg-white w-5/12 dark:bg-gray-800 {{ $isOpenA ? 'translate-x-0' : 'translate-x-full' }}" 
            style="transition: transform 0.3s ease-in-out;"
        >
            <h5 class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                Preview Message
            </h5>
    
            <button wire:click="closeDrawerA" 
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close menu</span>
            </button>

            <hr>
            
            <div class="text-justify">
                {!! $record?->description !!}
            </div>

        </div>
        
    </div>
    <!-- Backdrop -->
    <div wire:click="closeDrawerA" class="fixed inset-0 bg-black bg-opacity-50 z-40 {{ $isOpenA ? 'block' : 'hidden' }}"></div>
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