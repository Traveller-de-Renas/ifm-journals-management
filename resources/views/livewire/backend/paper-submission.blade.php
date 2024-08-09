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
            <div class="flex">
                <div class="rounded-full h-12 w-12 flex items-center justify-center {{ $step >= 3 ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                    3
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
        
                
        
                <div class="mt-4 text-right">
                    <x-button type="submit" wire:click="store()" wire:loading.attr="disabled">
                        {{ __('Submit') }}
                    </x-button>
                    <x-secondary-button class="ml-3" wire:click="$toggle('form')" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                </div>

            </div>

        @elseif ($step == 2)
            <div>Step 2 Content</div>
            <div class="w-full">
                <div class="grid grid-cols-2 gap-2">
                    
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
                </div>
            </div>

        @elseif ($step == 3)
            <div>Step 3 Content</div>

            
        @endif
    </div>
    
    <div class="flex justify-between mt-6">
        <button wire:click="decrementStep" class="bg-gray-500 text-white px-4 py-2 rounded {{ $step == 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $step == 1 ? 'disabled' : '' }}>Previous</button>
        <button wire:click="incrementStep" class="bg-blue-500 text-white px-4 py-2 rounded {{ $step == 3 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $step == 3 ? 'disabled' : '' }}>Next</button>
    </div>
</div>



</x-module>