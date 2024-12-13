<div class="relative flex">

        <div class="min-h-[100dvh] h-full flex flex-col after:flex-1">

            <div class="max-w-sm mx-auto w-full px-4 py-8">

                @if (session('error'))
                    <div class="p-4 rounded-md text-sm mb-4 shadow bg-red-300 w-full">
                        {{ session('error') }}
                    </div>
                @endif

                <h1 class="text-3xl text-gray-800 dark:text-gray-100 font-bold mb-6">{{ __('Create your Account') }}</h1>
                <!-- Form -->
                    <div class="space-y-4">
                        <div>
                            <x-label for="category">{{ __('Category') }} <span class="text-red-500">*</span></x-label>
                            <x-select id="category" class="w-full" :options="['internal'=>'IFM Staff', 'external'=>'Non IFM Staff']" wire:model="category" wire:change="checkCategory($event.target.value)" required />
                            <x-input-error for="category" />
                        </div>

                        <div {{ $category == 'internal' ? '' : 'hidden' }}>
                            <x-label for="pf_number">{{ __('PF Number') }} <span class="text-red-500">*</span></x-label>
                            <x-input id="pf_number" type="text" wire:model="pf_number" :value="old('pf_number')" required autofocus autocomplete="off" />
                            <x-input-error for="pf_number" />
                        </div>

                        <div {{ $category == 'external' ? '' : 'hidden' }}>

                        <div>
                            <x-label for="first_name">{{ __('First Name') }} <span class="text-red-500">*</span></x-label>
                            <x-input id="first_name" type="text" wire:model="first_name" :value="old('first_name')" required autofocus autocomplete="off" />
                            <x-input-error for="first_name" />
                        </div>

                        <div>
                            <x-label for="middle_name">{{ __('Middle Name') }} </x-label>
                            <x-input id="middle_name" type="text" wire:model="middle_name" :value="old('middle_name')" required autofocus autocomplete="off" />
                            <x-input-error for="middle_name" />
                        </div>

                        <div>
                            <x-label for="last_name">{{ __('Last Name') }} <span class="text-red-500">*</span></x-label>
                            <x-input id="last_name" type="text" wire:model="last_name" :value="old('last_name')" required autofocus autocomplete="off" />
                            <x-input-error for="last_name" />
                        </div>

                        <div>
                            <x-label for="gender">{{ __('Gender') }} <span class="text-red-500">*</span></x-label>
                            <x-select id="gender" class="w-full" :options="['Male'=>'Male', 'Female'=>'Female']" wire:model="gender" required />
                            <x-input-error for="gender" />
                        </div>

                        <div>
                            <x-label for="email">{{ __('Email Address') }} <span class="text-red-500">*</span></x-label>
                            <x-input id="email" type="email" wire:model="email" :value="old('email')" required />
                            <x-input-error for="email" />
                        </div>

                        <div>
                            <x-label for="password" value="{{ __('Password') }}" />
                            <x-input id="password" type="password" wire:model="password" required autocomplete="new-password" />
                            <x-input-error for="password" />
                        </div>

                        <div>
                            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                            <x-input id="password_confirmation" type="password" wire:model="password_confirmation" required autocomplete="new-password" />
                            <x-input-error for="password_confirmation" />
                        </div>

                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-6">
                        <div class="mr-1">
                        </div>
                        <x-button wire:click="store()">
                            {{ __('Sign Up') }}
                        </x-button>                
                    </div>
                <div class="pt-5 mt-6 border-t border-gray-100 dark:border-gray-700/60">
                    <div class="text-sm">
                        {{ __('Have an account?') }} <a class="font-medium text-violet-500 hover:text-violet-600 dark:hover:text-violet-400" href="{{ route('login') }}">{{ __('Sign In') }}</a>
                    </div>
                </div>

            </div>
        </div>

</div>
