<x-module>
    
    <x-slot name="title">
        {{ __($record->title) }}
        <p class="text-sm font-light">Submit New Article</p>
    </x-slot>


<div class="w-full">
    <div class="flex items-center mb-6 w-full">
        <div class="flex flex-1 items-center justify-between w-full">
            <div class="flex items-center w-full">
                <div class="rounded-full h-12 w-12 flex items-center justify-center {{ $step >= 1 ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                    1
                </div>
                <div class=" top-0 left-12 w-full h-1 bg-{{ $step > 1 ? 'blue-500' : 'gray-300' }}"></div>
            </div>
            <div class="flex items-center w-full">
                <div class="rounded-full h-12 w-12 flex items-center justify-center {{ $step >= 2 ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                    2
                </div>
                <div class=" top-0 left-12 w-full h-1 bg-{{ $step > 2 ? 'blue-500' : 'gray-300' }}"></div>
            </div>
            <div class="flex items-center w-full">
                <div class="rounded-full h-12 w-12 flex items-center justify-center {{ $step >= 3 ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                    3
                </div>
                <div class=" top-0 left-12 w-full h-1 bg-{{ $step > 3 ? 'blue-500' : 'gray-300' }}"></div>
            </div>
            <div class="flex">
                <div class="rounded-full h-12 w-12 flex items-center justify-center {{ $step >= 4 ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                    4
                </div>
            </div>
        </div>
    </div>
    
    <div>
        @if ($step == 1)
            <div>Step 1 Content</div>

            <div class="w-full">

                <div class="grid grid-cols-2 gap-2">
                    <div class="mt-4">
                    </div>
                    <div class="mt-4">
                        <x-label for="country_id" value="Country" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-select wire:model="country_id" id="country_id" class="w-full" :options="$countries" />
                        <x-input-error for="country_id" />
                    </div>
                </div>
        
                <div class="w-full">
                    <x-label for="manuscript_title" value="Manuscript Title" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input class="" wire:model="title" id="manuscript_title" type="text" placeholder="Manuscript Title" />
                    <x-input-error for="manuscript_title" />
                </div>
        
                <div class="mt-4" >
                    <x-label for="abstract" value="Abstract" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-textarea type="text" id="abstract" class="w-full" wire:model="abstract" placeholder="Enter Abstract" />
                    <x-input-error for="abstract" />
                </div>
                
                <div class="grid grid-cols-2 gap-2">
                    <div class="mt-4" >
                        <x-label for="keywords" value="Keywords" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input type="text" id="keywords" class="w-full" wire:model="keywords" placeholder="Enter Keywords" />
                        <x-input-error for="keywords" />
                    </div>
                    <div class="mt-4" >
                        <x-label for="areas" value="Areas" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input type="text" id="areas" class="w-full" wire:model="areas" placeholder="Enter areas" />
                        <x-input-error for="areas" />
                    </div>
                </div>

            </div>

        @elseif ($step == 2)
            <div>Step 2 Content</div>
            <div class="w-full">
                <div class="grid grid-cols-3 gap-2">
                    
                    <div class="mt-4">
                        <x-label for="file_category_id" value="File Category" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-select wire:model="file_category_id" id="file_category_id" class="w-full" :options="$countries" />
                        <x-input-error for="file_category_id" />
                    </div>
                    <div class="mt-4">
                        <x-label for="file_description" value="File Description" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input class="" wire:model="title" id="file_description" type="text" placeholder="File Description" />
                        <x-input-error for="file_description" />
                    </div>
                    <div class="mt-4">
                        <x-label for="file" value="File" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input-file class="" wire:model="title" id="file" type="file" placeholder="File" />
                        <x-input-error for="file" />
                    </div>

                </div>

                <div class="grid grid-cols-3 gap-2 w-full p-2 mt-6 bg-gray-200 rounded-lg">
                    <div>File Type</div>
                    <div>Description</div>
                    <div class="flex gap-2 justify-end">
                        <x-button>Download</x-button>
                        <x-button-plain class="bg-red-700">Delete</x-button-plain>
                    </div>
                </div>

            </div>

        @elseif ($step == 3)
            <div>Step 3 Content</div>

            @foreach ($record->submission_confirmations as $key => $confirmation)
                <div class="w-full flex p-4 border rounded-lg mb-4">
                    <div class="w-11/12 text-justify">{{ $confirmation->description }}</div>
                    <div class="flex w-1/12 items-start justify-center">

                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>
    
                    </div>
                </div>
            @endforeach

            <div class="grid grid-cols-4 gap-2">
                <div class="mt-4" >
                    <x-label for="figures" value="Number of Figures" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="number" id="figures" class="w-full" wire:model="figures" placeholder="Enter Numer of Figures" />
                    <x-input-error for="figures" />
                </div>
                <div class="mt-4" >
                    <x-label for="tables" value="Numer of Tables" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="number" id="tables" class="w-full" wire:model="tables" placeholder="Enter Numer of tables" />
                    <x-input-error for="tables" />
                </div>
                <div class="mt-4" >
                    <x-label for="words" value="Number of Words" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="number" id="words" class="w-full" wire:model="words" placeholder="Enter Number of Words" />
                    <x-input-error for="words" />
                </div>
                <div class="mt-4" >
                    <x-label for="pages" value="Number of Pages" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="number" id="pages" class="w-full" wire:model="pages" placeholder="Enter Number of Pages" />
                    <x-input-error for="pages" />
                </div>
            </div>

        @elseif ($step == 4)
            <div>Step 4 Content</div>

            

            <div class="mt-4 text-right">
                <x-button type="submit" wire:click="store()" wire:loading.attr="disabled">
                    {{ __('Save & Submit') }}
                </x-button>
                <x-button-plain class="ml-3 bg-red-700" wire:click="$toggle('form')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-button-plain>
            </div>
            
        @endif
    </div>
    
    <div class="flex justify-between mt-6">
        <button wire:click="decrementStep" class="bg-gray-500 text-white px-4 py-2 rounded {{ $step == 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $step == 1 ? 'disabled' : '' }}>Previous</button>
        <button wire:click="incrementStep" class="bg-blue-500 text-white px-4 py-2 rounded {{ $step == 4 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $step == 4 ? 'disabled' : '' }}>Next</button>
    </div>
</div>



</x-module>