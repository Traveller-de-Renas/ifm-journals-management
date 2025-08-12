<div>
    @if($prequest->status == 0)
        @if (session('success'))
            <div class="p-4 text-sm mb-4 shadow bg-green-300 w-full text-center">
                {{ session('success') }}
            </div>
        @endif

        <x-authentication-card>
            <h1 class="text-2xl text-gray-800 font-bold mb-4">{{ __('Create new Password for Account') }}</h1>

            @if (session()->has('error_message'))
                <div class="bg-red-500 text-white text-center text-xs p-3 rounded mb-4">
                    {{ session('error_message') }}
                </div>
            @endif

            <div class="mt-4 text-sm text-blue-700">
                Note : Password must be at least 8 characters, contain at least one uppercase letter, one lowercase letter, one number, and one special character
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" wire:model="password" required autocomplete="new-password" />
                <x-input-error for="password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" wire:model="password_confirmation" required autocomplete="new-password" />
                <x-input-error for="password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="mt-4 w-full" wire:click="resetPassword()">Reset Password</x-button>
            </div>

        </x-authentication-card>
    @else
        <div class="bg-red-500 text-white text-center text-xs p-3 rounded mb-4">
            This link is expired for security reasons, please request password change link again.
        </div>
    @endif
</div>
