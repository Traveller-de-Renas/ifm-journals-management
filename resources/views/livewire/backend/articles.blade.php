<x-module>
    
    <x-slot name="title">
        {{ __($record->title) }}
    </x-slot>
        
    <div class="w-full mb-2 bg-gray-200 p-4">

        <div class="grid grid-cols-12 gap-2">
            <p class="text-sm">ISSN: </p>
            <p class="col-span-11">{{ $record->issn }}</p>
        </div>

        <div class="grid grid-cols-12 gap-2">
            <p class="text-sm">EISSN: </p>
            <p class="col-span-11">{{ $record->eissn }}</p>
        </div>

        <div class="grid grid-cols-12 gap-2">
            <p class="text-sm">EMAIL: </p>
            <p class="col-span-11">{{ $record->email }}</p>
        </div>

        <div class="grid grid-cols-12 gap-2">
            <p class="text-sm">CREATED AT: </p>
            <p class="col-span-11">{{ $record->created_at }}</p>
        </div>
        
    </div>

    <div class="w-full text-justify mt-4 mb-4">
        {{ $record->description }}
    </div>

    <a href="{{ route('journals.submission', $record->uuid) }}">
        <x-button class="mb-4">Submit a Paper </x-button>
    </a>

    <div class="md:grid md:grid-cols-12 gap-4 w-full ">

        <div class="col-span-9">

            
            @foreach ($record->articles as $key => $article)

            <a href="{{ route('journals.article', $record->uuid) }}">
            <div class="text-sm font-bold text-blue-700 hover:text-blue-600 hover:bg-gray-100 cursor-pointer p-4 border rounded-lg mb-2 mt-2">
                {{ $article->title }}
            </div>
            </a>
                
            @endforeach
            

            
        </div>

        <div class="col-span-3">
            <div class="bg-gray-100 border rounded p-2">

                <p class="text-center">Recent Articles</p>

            </div>
        </div>

    </div>

</x-module>