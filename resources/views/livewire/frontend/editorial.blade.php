<div class="w-full">
    <div class="bg-gray-800 text-white py-12 bg-blend-overlay" style="background-image: url({{ asset('images/auth-image.jpg') }}); background-position: top;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="w-full flex text-lg">
                <p class="underline mr-1 cursor-pointer hover:text-gray-500">
                    <a href="{{ route('journal.detail', $record?->journal->uuid) }}">
                    {{ $record?->journal->title }}
                    </a>
                </p>
                @if ($record?->volume?->description)
                    <p class="mr-1"> > </p> 
                    <p class="underline mr-1 cursor-pointer hover:text-gray-500"> {{ $record?->volume?->description }} </p>
                @endif

                @if ($record?->description)
                    <p class="mr-1"> > </p>
                    <p class="underline mr-1 cursor-pointer hover:text-gray-500"> {{ $record?->description }} </p>
                @endif

            </div>
            
            <p class="text-white text-3xl font-bold mt-4 mb-4">
                {{ __('Editorial') }}
            </p>

            <a href="{{ route('journal.detail', $record?->journal->uuid) }}">
                <p class="text-xl text-gray-300">{{ $record?->journal->title }}</p>
            </a>

            <p> ISSN : {{ $record?->journal->issn }} </p>

            

        </div>
    </div>


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 mb-8">
        <div class="flex items-center">
            <a href="{{ route('journal.editorial_download', $record->uuid) }}" >
                <div class="flex items-center text-blue-700 hover:text-blue-600 cursor-pointer">
                    <img src="{{ asset('storage/favicon/pdf.png') }}" class="h-5"> <p class="ml-2 text-lg font-bold">Download PDF @if(Storage::exists('editorial/'.$record?->editorial_file))({{ round((Storage::size('editorial/'.$record?->editorial_file) / 1048576), 2) }} MB)@endif</p>
                </div>
            </a>
            <p class="ml-2 text-lg text-gray-600 font-bold">{{ $record?->editorial_downloads ?? 0 }} Downloads </p>
        </div>
    </div>

    <hr>


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">

        <div class="w-full mb-12">
            <div class="w-full text-justify mb-4">
                {!! $record->editorial !!}
            </div>
        </div>


    </div>
</div>