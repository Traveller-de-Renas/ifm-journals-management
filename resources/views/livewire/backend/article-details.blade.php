<x-module>
    
    <x-slot name="title">
        {{ __($record->title) }}
    </x-slot>

    <div class="w-full text-justify mb-4">
        {{ $record->abstract }}
    </div>

    Keywords
    <div class="text-sm font-bold text-blue-700 hover:text-blue-600 cursor-pointer p-4 mb-2 mt-2">
        {{ $record->keywords }}
    </div>

</x-module>