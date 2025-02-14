<x-guest-layout>
<div class="w-full">
    <div class="bg-gray-800 text-white bg-blend-overlay" style="background-image: url({{ asset('images/auth-image.jpg') }}); background-position: top;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-2 ">
                
                <div class="col-span-10 w-full mb-2 mt-2">
                    <p class="text-4xl font-bold">
                        {{ __($journal?->title) }} ({{ strtoupper($journal?->code) }})
                    </p>

                    <br>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">ISSN </p>
                        <p class="col-span-11">: {{ $journal?->issn }}</p>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">EISSN </p>
                        <p class="col-span-11">: {{ $journal?->eissn }}</p>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">EMAIL </p>
                        <p class="col-span-11">: {{ $journal?->email }}</p>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">CREATED </p>
                        <p class="col-span-11">: {{ $journal?->created_at }}</p>
                    </div>

                    <br>
                    <hr>

                    <div class="w-full text-justify mt-4 mb-4">
                        {!! $journal?->description !!}
                    </div>

                    
                </div>
                <div class="col-span-2">
                    @if($journal?->image == '')
                    <div class="p-2">
                        <svg class="w-full text-white dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/>
                        </svg>
                    </div>
                    @else
                        <img class="w-full rounded-md rounded-bl-md mt-4" src="{{ asset('storage/journals/'.$journal?->image) }}" alt="{{ strtoupper($journal?->code) }}">
                    @endif

                    <a href="{{ route('journals.submission', $journal?->uuid) }}">
                        <x-button class="mb-4 mt-2 w-full">Submit a Paper </x-button>
                    </a>
                </div>

            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="p-4 text-sm mb-4 shadow bg-green-300 w-full text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 py-8">
        <x-authentication-card>
            <h1 class="text-2xl text-gray-800 text-center font-bold mb-6">{{ __('Journal Account Activation') }}</h1>

            <div class="space-y-4">

                <a href="{{ route('login', $journal?->uuid) }}">
                <x-button class="mt-4 w-full">Login to Submission Portal</x-button>
                </a>

            </div>
        </x-authentication-card>
    </div>
</div>
</x-guest-layout>