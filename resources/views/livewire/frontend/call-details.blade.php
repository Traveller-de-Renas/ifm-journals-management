<div class="w-full">
    <div class="bg-gray-800 text-white py-12 bg-blend-overlay" style="background-image: url({{ asset('images/auth-image.jpg') }}); background-position: top;">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-2 ">
                <div class="col-span-10 w-full mb-2 mt-2">

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
                <div class="col-span-2">
                    @if($record->image == '')
                        <div class="p-2">
                            <svg class="w-full text-white dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/>
                            </svg>
                        </div>
                    @else
                        <img class="w-full rounded-md rounded-bl-md mt-4" src="{{ asset('storage/journals/'.$record->image) }}" alt="{{ $record->code }}">
                    @endif

                    <a href="{{ route('journals.submission', $record->uuid) }}">
                        <x-button class="mb-4 mt-2 w-full">Submit a Paper </x-button>
                    </a>
                </div>

            </div>
        </div>

    </div>


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 mb-8">
        
        <span class="text-sm text-justify dark:text-gray-400">{!! $record->description !!}</span>

    </div>
</div>