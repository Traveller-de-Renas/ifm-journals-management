<div class="bg-white shadow-md p-4 rounded">

    <div class="w-full grid grid-cols-3 gap-4" >
        <div class="">
            <p class="font-bold text-xl">{{ __('REVIEW SECTIONS') }}</p>
        </div>
        <div class="">

        </div>
        <div class="flex gap-2 justify-end">
            <x-button class="float-right" wire:click="$toggle('form')" wire:loading.attr="disabled" >Create New</x-button>
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

    @if($form)
    <div class="w-full mt-4">
        
            <x-input class="w-full" wire:model="title" type="text" placeholder="Section Title" />

            @foreach ($sections as $skey => $section)
                <div class="mb-6 ml-12 border-l-2 pl-4">
                    <div class="grid grid-cols-12 gap-2 mt-4 ">
                        <div class="col-span-9">
                            <x-input class="w-full mb-2" wire:model="sub_title.{{ $skey }}" type="text" placeholder="Sub Section Title" />
                        </div>
                        <div class="col-span-3">
                            <select wire:model="category.{{ $skey }}" class="w-full rounded-lg border-gray-200" wire:change="checkCategory($event.target.value, {{ $skey }})">
                                <option value="">Select Section Category</option>
                                <option value="options" @if($record?->category == 'options') selected @endif >Options</option>
                                <option value="comments" @if($record?->category == 'comments') selected @endif >Comments</option>
                            </select>
                        </div>
                    </div>
                    
                    
                    @if($category[$skey] == 'options')
                        <div class="mt-2 p-2 bg-gray-200 mb-2">Add Options</div>

                        <div class="">
                            @foreach ($options[$skey] as $key => $section_option)
                            
                            <div class="grid grid-cols-12 gap-2 mb-2">
                                <div class="col-span-10">
                                    <x-input type="text" id="options" class="w-full h-10" wire:model="options.{{ $skey }}.{{ $key }}" placeholder="Enter Option " />
                                    <x-input-error for="options" />
                                </div>
                                <div class="col-span-2 flex justify-end">
                                    <x-button class="bg-red-500 hover:bg-red-700" wire:click="removeRow({{ $key }}, 'options')">
                                        <svg class="h-4 w-4 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="3 6 5 6 21 6" />  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" /></svg>
                                    </x-button>
                                </div>
                            </div>

                            @endforeach

                            <div class="text-right mt-4">
                                <x-button type="button" wire:click="addRows('options', {{ $skey }})" wire:loading.attr="disabled">
                                    {{ __('Add More') }}
                                </x-button>
                            </div>
                        </div>
                    @endif

                    <div class="mt-2 p-2 bg-gray-200 grid grid-cols-12  gap-2 mb-2">
                        <div class="col-span-10">
                            Add Queries
                        </div>
                        <div class="col-span-2 flex justify-end">
                        </div>
                    </div>

                    <div class="">
                        @foreach ($queries[$skey] as $key => $query_data)
                        
                        <div class="grid grid-cols-12 gap-2 mb-2">
                            <div class="col-span-10">
                                <x-input type="text" id="queries" class="w-full h-10" wire:model="queries.{{ $skey }}.{{ $key }}" placeholder="Enter query title" />
                                <x-input-error for="queries" />
                            </div>
                            <div class="col-span-2 flex justify-end">
                                <x-button class="bg-red-500 hover:bg-red-700" wire:click="removeRow({{ $key }}, 'queries')">
                                    <svg class="h-4 w-4 text-white" viewBox="0 0 24 24"  fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="3 6 5 6 21 6" />  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" /></svg>
                                </x-button>
                            </div>
                        </div>

                        @endforeach

                        <div class="text-right mt-4">
                            <x-button type="button" wire:click="addRows('queries', {{ $skey }})" wire:loading.attr="disabled">
                                {{ __('Add More') }}
                            </x-button>
                        </div>
                    </div>

                    <x-button type="button" class="bg-red-500 hover:bg-red-700" wire:click="deleteRow({{ $skey }}, 'sub_sections')" wire:loading.attr="disabled">
                        {{ __('Remove Section') }}
                    </x-button>
                </div>
            @endforeach
            

        <div class="text-center mt-4 mb-4">
            <x-button type="button" class="bg-green-500 hover:bg-green-700" wire:click="addRows('sections')" wire:loading.attr="disabled">
                {{ __('Add More Sections') }}
            </x-button>
        </div>

        <hr>

        <div class="mt-4 text-center">
            @if(!empty($record))
                <x-button type="submit" wire:click="update()" wire:loading.attr="disabled">Update</x-button>
            @else
                <x-button type="submit" wire:click="store()" wire:loading.attr="disabled">Submit</x-button>
            @endif

            <x-button class="bg-red-500 hover:bg-red-700" wire:click="$toggle('form')" wire:loading.attr="disabled">Cancel</x-button>
        </div>
    </div>

    @endif

    <table class="min-w-full text-left text-sm font-light">
        <thead class="border-b font-medium grey:border-neutral-500">
            <tr>
                <th scope="col" class="px-6 py-4 w-2">#</th>
                <th scope="col" class="px-6 py-4">
                    <button wire:click="sort('title')" >Title</button>
                    <x-sort-icon class="float-right" sortField="title" :sort-by="$sortBy" :sort-asc="$sortAsc" />
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
            @foreach ($review_sections as $item)

            <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 grey:border-neutral-500 grey:hover:bg-neutral-600">
                <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $sn }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $item->title }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $item->status() }}</td>
                <td class="whitespace-nowrap ">
                    
                    <button id="dropdown{{ $item->id }}" data-dropdown-toggle="dropdownDots{{ $item->id }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50" type="button">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                        </svg>
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
        {{ $review_sections->links() }}
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
            
            <x-button type="submit" class="bg-red-500 hover:bg-red-700" wire:click="delete({{ $record?->id }})" wire:loading.attr="disabled" >
                {{ __('Delete') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('deleteModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>
</div>
