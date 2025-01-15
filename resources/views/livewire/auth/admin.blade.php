<div class="w-full">
    <div class="bg-gray-800 text-white bg-blend-overlay h-96" style="background-image: url({{ asset('images/auth-image.jpg') }}); background-position: top;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-2 ">
                
                <div class="col-span-10 w-full mb-2 mt-2">
                   

                    
                </div>
                <div class="col-span-2">
                    
                </div>

            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto grid grid-cols-3 px-4 py-8">
        
        <div class="px-4">
            <h1 class="text-3xl text-gray-800 dark:text-gray-100 font-bold mb-6">{{ __('Welcome back!') }}</h1>
            @if (session('message'))
                <div class="mb-4 font-medium text-sm text-white bg-red-500 w-full rounded text-center p-2">
                    {{ session('message') }}
                </div>
            @endif

            @if (session('success'))
                <div class="p-4 rounded-md text-sm mb-4 shadow bg-green-300 w-full">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" type="email" wire:model="email" required autofocus />                
                </div>
                <div>
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" type="password" wire:model="password" required autocomplete="current-password" />                
                </div>
            </div>
            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <div class="mr-1">
                        <a class="text-sm underline hover:no-underline" href="{{ route('password.request') }}">
                            {{ __('Forgot Password?') }}
                        </a>
                    </div>
                @endif            
                <x-button class="ml-3" wire:click="login()">
                    {{ __('Sign in') }}
                </x-button>            
            </div>

            <x-validation-errors class="mt-4" /> 
        </div>
    </div>
</div>
