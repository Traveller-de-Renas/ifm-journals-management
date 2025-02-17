<div>
    @if (session('success'))
        <div class="p-4 text-sm mb-4 shadow bg-green-300 w-full text-center">
            {{ session('success') }}
        </div>
    @endif

    <x-authentication-card>
        <h1 class="text-2xl text-gray-800 font-bold mb-4">{{ __('Rest your Login Password') }}</h1>

        @if (session()->has('error_message'))
            <div class="bg-red-500 text-white text-center text-xs p-3 rounded mb-4">
                {{ session('error_message') }}
            </div>
        @endif

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to reset and create a new one.') }}
        </div>

        <div class="block">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" class="block mt-1 w-full" type="email" wire:model="email" required autofocus autocomplete="username" />
        </div>

        <div class="flex items-center mt-4 mb-4">
            <x-button class="mt-4 w-full" wire:click="sendLink()">Send Password Reset Link</x-button>
        </div>
    </x-authentication-card>
</div>
