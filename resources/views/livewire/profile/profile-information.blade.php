<div>
    @if (session('response'))
        @php
            $bgClass = match (session('response.status')) {
                'success' => 'bg-green-300',
                'danger'  => 'bg-red-300',
                'warning' => 'bg-yellow-300',
                'info'    => 'bg-blue-300',
                default   => 'bg-gray-200',
            };
        @endphp
        <div class="p-4 text-sm mb-4 mt-2 shadow {{ $bgClass }} w-full text-center">
            {{ session('response.message') }}
        </div>
    @endif

    <div class="md:grid md:grid-cols-3 md:gap-6">

        <div class="">

            <x-section-title>
                <x-slot name="title">{{ 'Update Profile Information' }}</x-slot>
                <x-slot name="description">{{ __('Update your account\'s profile information and email address.') }}</x-slot>
            </x-section-title>
            
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="bg-white px-4 py-5 sm:p-6 rounded-t-md shadow">

                <div class="grid grid-cols-2 gap-2">
                    <div class="mt-4 w-full">
                        <x-label for="title" class="text-xs">{{ __('Title') }}</x-label>
                        <x-select id="title" class="w-full" :options="$salutations" wire:model="salutation" />
                        <x-input-error for="title" />
                    </div>
            
                    <div class="mt-4">
                        <x-label for="first_name" class="text-xs">{{ __('First Name') }} <span class="text-red-500">*</span></x-label>
                        <x-input id="first_name" type="text" class="w-full" wire:model="first_name" required autofocus autocomplete="off" />
                        <x-input-error for="first_name" />
                    </div>
                </div>
            
                <div class="grid grid-cols-2 gap-2">
                    <div class="mt-4">
                        <x-label for="middle_name" class="text-xs">{{ __('Middle Name') }} </x-label>
                        <x-input id="middle_name" type="text" class="w-full" wire:model="middle_name"  required autofocus autocomplete="off" />
                        <x-input-error for="middle_name" />
                    </div>
                
                    <div class="mt-4">
                        <x-label for="last_name" class="text-xs">{{ __('Last Name') }} <span class="text-red-500">*</span></x-label>
                        <x-input id="last_name" type="text" class="w-full" wire:model="last_name"  required autofocus autocomplete="off" />
                        <x-input-error for="last_name" />
                    </div>
                </div>
                    
                <div class="grid grid-cols-2 gap-2">
                    <div class="mt-4">
                        <x-label for="gender" class="text-xs">{{ __('Gender') }} <span class="text-red-500">*</span></x-label>
                        <x-select id="gender" class="w-full" :options="['Male'=>'Male', 'Female'=>'Female']" wire:model="gender" required />
                        <x-input-error for="gender" />
                    </div>
                    <div class="mt-4">
                        <x-label for="country" class="text-xs">{{ __('Country') }} <span class="text-red-500">*</span></x-label>
                        <x-select id="country" class="w-full" :options="$countries" wire:model="country" required />
                        <x-input-error for="country" />
                    </div>
                </div>


                <div class="grid grid-cols-2 gap-2">
                    <div class="mt-4">
                        <x-label for="email" class="text-xs">{{ __('Email Address') }} </x-label>
                        <x-input id="email" type="text" class="w-full" wire:model="email"  required autofocus autocomplete="off" />
                        <x-input-error for="email" />
                    </div>
                
                    <div class="mt-4">
                        <x-label for="phone" class="text-xs">{{ __('Phone Number') }} <span class="text-red-500">*</span></x-label>
                        <x-input id="phone" type="text" class="w-full" wire:model="phone"  required autofocus autocomplete="off" />
                        <x-input-error for="phone" />
                    </div>
                </div>
                
            
                <div class="mt-4">
                    <x-label for="affiliation" class="text-xs">{{ __('Affiliation') }} <span class="text-red-500">*</span></x-label>
                    <x-input id="affiliation" type="text" class="w-full" wire:model="affiliation" wire:input="checkAffiliation()"  required autofocus autocomplete="off" />
                    <x-input-error for="affiliation" />
            
                    @if($affiliation != '')
                    <div class="shadow mt-1 relative">
                        <div class="absolute">
                            @foreach ($affiliations as $affiliation)
                                
                                <div class="text-xs text-gray-700 bg-gray-200 hover:bg-gray-300 cursor-pointer p-2" wire:click="selectAffiliation('{{ $affiliation->affiliation }}')">
                                    {{ $affiliation->affiliation }}
                                </div>
            
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="mt-4">
                    <x-label for="degree" class="text-xs">{{ __('Degree') }} </x-label>
                    <x-input id="degree" type="text" class="w-full" wire:model="degree" required autofocus autocomplete="off" />
                    <x-input-error for="degree" />
                </div>

                <div class="mt-4">
                    <x-label for="biography" class="text-xs">{{ __('Biography') }}</x-label>
                    <x-textarea type="text" id="biography" class="w-full mt-2" wire:model="biography" placeholder="Enter Biography" rows="5" />
                    <x-input-error for="biography" />
                </div>

                <div class="mt-4">
                    <x-label for="interests" class="text-xs">{{ __('Your Areas of Interests') }} <span class="text-gray-500">Separate by Comma (,)</span></x-label>
                    <x-input id="interests" type="text" class="w-full" wire:model="interests" required autofocus autocomplete="off" />
                    <x-input-error for="interests" />
                </div>
            
                <div class="mt-4 mb-6 flex justify-between gap-4">
                    <div class="flex ps-3 border border-gray-200 rounded-lg flex-1">
                        <input id="bordered-checkbox-1" type="checkbox" wire:model="can_review" value="Associate Editor" name="bordered-checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 mt-3">
                        <label for="bordered-checkbox-1" class="w-full py-3 ms-2 text-xs font-medium text-gray-900">By checking this box I confirm that I want my account to be invited for peer review.</label>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-end sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                <x-button class="" wire:click="update()">Update Profile</x-button>
            </div>
        </div>
    </div>
</div>