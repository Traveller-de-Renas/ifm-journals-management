<x-module>
    
    <x-slot name="title">
        {{ __('PROFILE  INFORMATION') }}
    </x-slot>

    


    <div class="grid grid-cols-3 gap-2 w-full">
        <div class="mt-4">
            <x-label for="juser_fname" value="First Name" class="mb-2 block font-medium text-sm text-gray-700" />
            <x-input type="text" id="juser_fname" class="w-full" wire:model="juser_fname" />
            <x-input-error for="juser_fname" />
        </div>
        <div class="mt-4">
            <x-label for="juser_mname" value="Middle Name" class="mb-2 block font-medium text-sm text-gray-700" />
            <x-input type="text" id="juser_mname" class="w-full" wire:model="juser_mname" />
            <x-input-error for="juser_mname" />
        </div>
        <div class="mt-4">
            <x-label for="juser_lname" value="Last Name" class="mb-2 block font-medium text-sm text-gray-700" />
            <x-input type="text" id="juser_lname" class="w-full" wire:model="juser_lname" />
            <x-input-error for="juser_lname" />
        </div>
    </div>

    <div class="grid grid-cols-3 gap-2 w-full">
        <div class="mt-4">
            <x-label for="juser_title" value="Title" class="mb-2 block font-medium text-sm text-gray-700" />
            <x-select id="juser_title" class="w-full" :options="$salutations" :selected="$juser_salutation_id" wire:model="juser_salutation_id" />
            <x-input-error for="juser_title" />
        </div>

        <div class="mt-4">
            <x-label for="juser_gender" value="Gender" class="mb-2 block font-medium text-sm text-gray-700" />
            <x-select id="juser_gender" class="w-full" :options="['Male' => 'Male', 'Female' => 'Female']" :selected="$juser_gender" wire:model="juser_gender" />
            <x-input-error for="juser_gender" />
        </div>

        <div class="mt-4">
            <x-label for="juser_photo" value="Profile Photo" class="mb-2 block font-medium text-sm text-gray-700" />
            <x-input-file type="file" id="juser_photo" class="w-full" wire:model="juser_photo" />
            <x-input-error for="juser_photo" />
        </div>
    </div>

    <div class="grid grid-cols-3 gap-2 w-full">
        <div class="mt-4">
            <x-label for="juser_degree" value="Degree" class="mb-2 block font-medium text-sm text-gray-700" />
            <x-input type="text" id="juser_degree" class="w-full" wire:model="juser_degree" />
            <x-input-error for="juser_degree" />
        </div>
        <div class="mt-4">
            <x-label for="juser_affiliation" value="Affiliation" class="mb-2 block font-medium text-sm text-gray-700" />
            <x-input type="text" id="juser_affiliation" class="w-full" wire:model="juser_affiliation" />
            <x-input-error for="juser_affiliation" />
        </div>
        <div class="mt-4">
            <x-label for="country_id" value="Country" class="mb-2 block font-medium text-sm text-gray-700" />
            <x-select id="country_id" class="w-full" :options="$countries" :selected="$juser_country_id" wire:model="juser_country_id" />
            <x-input-error for="country_id" />
        </div>
    </div>

    <div class="grid grid-cols-3 gap-2 w-full">
        <div class="mt-4">
            <x-label for="juser_email" value="Email" class="mb-2 block font-medium text-sm text-gray-700" />
            <x-input type="text" id="juser_email" class="w-full" wire:model="juser_email" />
            <x-input-error for="juser_email" />
        </div>
        <div class="mt-4">
            <x-label for="juser_phone" value="Phone" class="mb-2 block font-medium text-sm text-gray-700" />
            <x-input type="text" id="juser_phone" class="w-full" wire:model="juser_phone" />
            <x-input-error for="juser_phone" />
        </div>
    </div>

    <div class="mt-4 w-full">
        <x-label for="juser_interest" value="Ares of Interest" class="mb-2 block font-medium text-sm text-gray-700" />
        <x-input type="text" id="juser_interest" class="w-full" wire:model="juser_interest" />
        <x-input-error for="juser_interest" />
    </div>

    <div class="mt-4 w-full" wire:ignore>
        <x-label for="juser_biography" value="Biography" class="mb-2 block font-medium text-sm text-gray-700" />
        <x-textarea type="text" id="juser_biography" class="w-full" wire:model="juser_biography" placeholder="Enter Your Biography" rows="7" />
        <x-input-error for="juser_biography" />
    </div>

    <div class="w-full text-right mt-4">

        <x-button type="submit" wire:click="updateUser()" wire:loading.attr="disabled">
            {{ __('Update') }}
        </x-button>

    </div>

</x-module>

<script>
    window.addEventListener('contentChanged', (e) => {
        tinymce.remove('#juser_biography');
        tinymce.init({
            selector: '#juser_biography',
            plugins: 'code advlist lists table link',
            
            height: 200,
            skin: false,
            content_css: false,
            advlist_bullet_styles: 'disc,circle,square',
            advlist_number_styles: 'default,lower-alpha,lower-roman,upper-alpha,upper-roman',
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons | code',
            
            setup: function (editor) {
                editor.on('init change', function () {
                    editor.save();
                });
                editor.on('change', function (e) {
                    @this.set('juser_biography', editor.getContent());
                });
            },
        });
    });

</script>