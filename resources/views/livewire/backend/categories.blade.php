<div class="bg-white shadow-md p-4 rounded">

    @if ($form)
        <div class="w-full border-b pb-4">
            
            <div class="grid grid-cols-3 space-x-2">
                <div class="mt-4">
                    <x-label for="name" value="Name" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="name" class="w-full" wire:model="name" />
                    <x-input-error for="name" />
                </div>

                <div class="mt-4">
                    <x-label for="subject" value="Subject" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="subject" class="w-full" :options="$subjects" wire:model="subject" />
                    <x-input-error for="subject" />
                </div>
                    
                <div class="mt-4">
                    <x-label for="status" value="status" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="status" class="w-full" :options="['1' => 'Active', '0' => 'Inactive']" wire:model="status" />
                    <x-input-error for="status" />
                </div>
            </div>

            <div class="text-right mt-4">
                <x-button type="submit" wire:click="store()" wire:loading.attr="disabled">
                    {{ __('Submit') }}
                </x-button>
                <x-secondary-button class="ml-3" wire:click="$toggle('form')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>
            </div>
        </div>
    @endif

    <div class="w-full grid grid-cols-3 gap-4" >
        <div class="">
            <p class="font-bold text-xl">{{ __('JOURNAL CATEGORIES') }}</p>
        </div>
        <div class="">

        </div>
        <div class="flex gap-2 justify-end">
            @if (!$form)
            <x-button class="float-right" wire:click="$toggle('form')" wire:loading.attr="disabled" >Create New</x-button>
            @endif
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
                        <button wire:click="sort('name')" >Name</button>
                        <x-sort-icon class="float-right" sortField="name" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </th>
                    <th scope="col" class="px-6 py-4">
                        <button wire:click="sort('subject')" >Subject</button>
                        <x-sort-icon class="float-right" sortField="subject" :sort-by="$sortBy" :sort-asc="$sortAsc" />
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
        @foreach ($categories as $data)

        <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 grey:border-neutral-500 grey:hover:bg-neutral-600">
            <td class="whitespace-nowrap px-6 py-3 font-medium">{{ $sn }}</td>
            <td class="whitespace-nowrap px-6 py-3">{{ $data->name }}</td>
            <td class="whitespace-nowrap px-6 py-3">{{ $data->journal_subject->name }}</td>
            <td class="whitespace-nowrap px-6 py-3">{{ $data->status() }}</td>
            <td class="whitespace-nowrap ">
                
                <button id="dropdown{{ $data->id }}" data-dropdown-toggle="dropdownDots{{ $data->id }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900" type="button">
                    <svg class="h-6 w-6 text-gray-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="1" />  <circle cx="19" cy="12" r="1" />  <circle cx="5" cy="12" r="1" /></svg>
                </button>
                    
                <div id="dropdownDots{{ $data->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 ">
                    <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdown{{ $data->id }}">
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="confirmEdit({{ $data->id }})" wire:loading.attr="disabled">Edit</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 " wire:click="confirmView({{ $data->id }})" wire:loading.attr="disabled">View</a>
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
        {{ $categories->links() }}
    </div>

</div>
