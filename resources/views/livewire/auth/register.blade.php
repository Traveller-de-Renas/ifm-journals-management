<div class="w-full">
    <div class="bg-gray-800 text-white bg-blend-overlay" style="background-image: url({{ asset('images/auth-image.jpg') }}); background-position: top;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-2 ">
                
                <div class="col-span-10 w-full mb-2 mt-2">
                    <p class="text-4xl font-bold">
                        {{ __($journal->title) }} ({{ strtoupper($journal->code) }})
                    </p>

                    <br>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">ISSN </p>
                        <p class="col-span-11">: {{ $journal->issn }}</p>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">EISSN </p>
                        <p class="col-span-11">: {{ $journal->eissn }}</p>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">EMAIL </p>
                        <p class="col-span-11">: {{ $journal->email }}</p>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">CREATED </p>
                        <p class="col-span-11">: {{ $journal->created_at }}</p>
                    </div>

                    <br>
                    <hr>

                    <div class="w-full text-justify mt-4 mb-4">
                        {!! $journal->description !!}
                    </div>

                    
                </div>
                <div class="col-span-2">
                    @if($journal->image == '')
                    <div class="p-2">
                        <svg class="w-full text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/>
                        </svg>
                    </div>
                    @else
                        <img class="w-full rounded-md rounded-bl-md mt-4" src="{{ asset('storage/journals/'.$journal->image) }}" alt="{{ strtoupper($journal->code) }}">
                    @endif

                    <a href="{{ route('journals.submission', $journal->uuid) }}">
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
            @if (session('error'))
                <div class="p-4 rounded-md text-sm text-white mb-4 shadow bg-red-700 w-full">
                    {{ session('error') }}
                </div>
            @endif

            <h1 class="text-2xl text-gray-800 font-bold mb-6">{{ __('Create your Account') }}</h1>

            <div class="space-y-4">

                <div {{ $category == 'internal' ? '' : 'hidden' }} class="mt-4">
                    <x-label for="pf_number" class="text-xs">{{ __('PF Number') }} <span class="text-red-500">*</span></x-label>
                    <x-input id="pf_number" type="text" wire:model="pf_number" :value="old('pf_number')" required autofocus autocomplete="off" />
                    <x-input-error for="pf_number" />
                </div>

                <div {{ $category == 'external' ? '' : 'hidden' }}>
                    <div class="mt-4">
                        <x-label for="email" class="text-xs">{{ __('Email Address') }} <span class="text-red-500">*</span></x-label>
                        <x-input id="email" type="email" class="w-full" wire:model.live.debounce.500ms="email" placeholder="search..." type="search" required />
                        <x-input-error for="email" />
                    </div>

                    <div {{ $user_check == 'exists' ? '' : 'hidden' }}>
                        <div class="text-blue-600 text-justify mt-4"> 
                            <p class="font-bold w-full">Message</p>
                            Another User with this email already exist would you llike to enroll for this journal or create new account using new email address
                        </div>
                    </div>
                    <div {{ $user_check == 'nouser' ? '' : 'hidden' }} >
                        <div class="mt-4">
                            <x-label for="first_name" class="text-xs">{{ __('First Name') }} <span class="text-red-500">*</span></x-label>
                            <x-input id="first_name" type="text" class="w-full" wire:model="first_name" :value="old('first_name')" required autofocus autocomplete="off" />
                            <x-input-error for="first_name" />
                        </div>
        
                        <div class="mt-4">
                            <x-label for="middle_name" class="text-xs">{{ __('Middle Name') }} </x-label>
                            <x-input id="middle_name" type="text" class="w-full" wire:model="middle_name" :value="old('middle_name')" required autofocus autocomplete="off" />
                            <x-input-error for="middle_name" />
                        </div>
        
                        <div class="mt-4">
                            <x-label for="last_name" class="text-xs">{{ __('Last Name') }} <span class="text-red-500">*</span></x-label>
                            <x-input id="last_name" type="text" class="w-full" wire:model="last_name" :value="old('last_name')" required autofocus autocomplete="off" />
                            <x-input-error for="last_name" />
                        </div>
        
                        <div class="mt-4">
                            <x-label for="gender" class="text-xs">{{ __('Gender') }} <span class="text-red-500">*</span></x-label>
                            <x-select id="gender" class="w-full" :options="['Male'=>'Male', 'Female'=>'Female']" wire:model="gender" required />
                            <x-input-error for="gender" />
                        </div>
        
                        <div class="mt-4">
                            <x-label for="password" class="text-xs" value="{{ __('Password') }}" />
                            <x-input id="password" type="password" class="w-full" wire:model="password" required autocomplete="new-password" />
                            <x-input-error for="password" />
                        </div>
        
                        <div class="mt-4">
                            <x-label for="password_confirmation" class="text-xs" value="{{ __('Confirm Password') }}" />
                            <x-input id="password_confirmation" type="password" class="w-full" wire:model="password_confirmation" required autocomplete="new-password" />
                            <x-input-error for="password_confirmation" />
                        </div>
                    </div>

                    <div class="mt-2 mb-6 flex justify-between gap-4">
                        <div class="flex ps-3 border border-gray-200 rounded-lg flex-1">
                            <input id="bordered-checkbox-1" type="checkbox" wire:model="can_review" value="Associate Editor" name="bordered-checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 mt-4">
                            <label for="bordered-checkbox-1" class="w-full py-3 ms-2 text-xs font-medium text-gray-900">By checking this box I confirm that I want my account to be invited for peer review.</label>
                        </div>
                    </div>

                    <div {{ $user_check == 'exists' ? '' : 'hidden' }}>
                        <x-button class="mt-4 w-full" wire:click="enroll()">Enroll to this Journal</x-button>
                    </div>
                    <div {{ $user_check == 'nouser' ? '' : 'hidden' }} >
                        <x-button class="mt-4 w-full" wire:click="store()">Sign Up</x-button>
                    </div>
                </div>
            </div>
            

            <div class="pt-5 mt-6 border-t border-gray-100">
                <div class="text-sm">
                    {{ __('Have an account?') }} <a class="font-medium text-blue-400 hover:text-blue-600" href="{{ route('login',  $journal->uuid) }}">{{ __('Sign In') }}</a>
                </div>
            </div>
        </x-authentication-card>
    </div>
</div>
