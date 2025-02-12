<div class="w-full">
    <div class="bg-gray-800 text-white py-12 bg-blend-overlay" style="background-image: url({{ asset('images/auth-image.jpg') }}); background-position: top;">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-2 ">
                <div class="col-span-12 w-full mb-2 mt-2">
                    <p class="text-2xl font-bold mb-4">{{ __('CALL FOR PAPERS') }} </p>

                    <p class="text-white text-3xl font-bold mt-4 mb-4">
                        {{ __($record->title) }}
                    </p>

                    <div class="border-t mb-2"></div>

                    <div class="flex">
                        <p class="w-1/2">Start Date : {{ $record->start_date }}</p>
                        <p class="w-1/2">End Date : {{ $record->start_date }}</p>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="border-b bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-2">
            <a href="{{ route('login', $record->journal->uuid) }}">
                <x-button class="mb-4 mt-2">Submit your Manuscript Here</x-button>
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 mb-8">
        <span class="text-sm text-justify">{!! $record->description !!}</span>
    </div>
</div>