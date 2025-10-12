<div class="bg-white shadow-md p-4 rounded">

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

    <div class="w-full">
        
        <div>
            <div class="w-full" >

                <div class="grid grid-cols-3 gap-2">
                    <div class="mt-4">
                        <x-label for="submission_date" value="Title" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input class="w-full" wire:model="submission_date" id="submission_date" type="date" />
                        <x-input-error for="submission_date" />
                    </div>
                    <div class="mt-4">
                        <x-label for="article_type_id" value="Article Type" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-select wire:model="article_type_id" id="article_type_id" class="w-full" :options="$article_types" />
                        <x-input-error for="article_type_id" />
                    </div>
                    <div class="mt-4">
                        <x-label for="country_id" value="Country" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-select wire:model="country_id" id="country_id" class="w-full" :options="$countries" />
                        <x-input-error for="country_id" />
                    </div>
                </div>
        
                <div class="mt-4">
                    <x-label for="title" value="Title" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input class="w-full" wire:model="title" id="title" type="text" placeholder="Enter Title" />
                    <x-input-error for="title" />
                </div>
        
                <div class="mt-4" wire:ignore >
                    <x-label for="abstract" value="Abstract" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-textarea type="text" id="abstract" class="w-full" wire:model="abstract" placeholder="Enter Abstract" rows="7" />
                    <x-input-error for="abstract" />
                </div>
                
                <div class="grid grid-cols-2 gap-2">
                    <div class="mt-4" >
                        <x-label for="keywords" value="Keywords - Separate by using comma sign (,)" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input type="text" id="keywords" class="w-full" wire:model="keywords" placeholder="Enter Keywords" />
                        <x-input-error for="keywords" />
                    </div>
                    <div class="mt-4" >
                        <x-label for="areas" value="Areas - Separate by using comma sign (,)" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input type="text" id="areas" class="w-full" wire:model="areas" placeholder="Enter areas" />
                        <x-input-error for="areas" />
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-2">
                    <div class="col-span-3 mt-4" >
                        <x-label for="figures" value="Number of Figures" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input type="number" id="figures" class="w-full" wire:model="figures" placeholder="Enter Numer of Figures" />
                        <x-input-error for="figures" />
                    </div>
                    <div class="col-span-3 mt-4" >
                        <x-label for="tables" value="Numer of Tables" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input type="number" id="tables" class="w-full" wire:model="tables" placeholder="Enter Numer of tables" />
                        <x-input-error for="tables" />
                    </div>
                    <div class="col-span-3 mt-4" >
                        <x-label for="words" value="Number of Words" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input type="number" id="words" class="w-full" wire:model="words" placeholder="Enter Number of Words" />
                        <x-input-error for="words" />
                    </div>
                    <div class="col-span-3 mt-4" >
                        <x-label for="pages" value="Number of Pages" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input type="number" id="pages" class="w-full" wire:model="pages" placeholder="Enter Number of Pages" />
                        <x-input-error for="pages" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div class="mt-4">
                        <x-label for="submitted_by" value="Submitted By(Author)" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-select wire:model="submitted_by" id="submitted_by" class="w-full" :options="$journal_users" />
                        <x-input-error for="submitted_by" />
                    </div>
                    <div class="mt-4">
                        <x-label for="manuscript_file" value="Manuscript File" class="mb-1 block font-medium text-sm text-gray-700" />
                        <x-input-file wire:model="manuscript_file" id="manuscript_file" />
                        <x-input-error for="manuscript_file" />
                    </div>
                </div>

                <div class="mt-4 mb-4">
                    <x-label for="sauthor" value="Co Authors List" class="mb-2 block font-medium text-sm text-gray-700" />
                    <div class="flex gap-2" >
                        <x-input type="text" class="w-full" wire:model="sauthor" wire:keyup="searchAuthor($event.target.value)" placeholder="Search User to add as Co Author" />
                        <x-button wire:click="createJuser();">Create</x-button>
                    </div>
                    <div class="results">
                        @if(!empty($authors) && $sauthor != '')

                        <div class="w-full bg-gray-200 rounded-md mt-1 shadow-lg">
                            @foreach ($authors as $key => $author)
                                <label class="w-full bg-gray-200 rounded-md p-2 hover:bg-gray-300 cursor-pointer flex gap-4" for="author{{ $author?->id }}" wire:click="selectAuthor({{ $author->id }})" wire:loading.attr="disabled">

                                    <div>
                                        {{ $author?->salutation?->title }} {{ $author?->first_name }} {{ $author?->middle_name }} {{ $author?->last_name }}
                                    </div>
                                    
                                </label>
                            @endforeach
                        </div>
                        
                        @endif
                    </div>


                    @if($selected_authors)
                    <div class="mt-6">
                        @foreach ($selected_authors as $key => $article_user)
                        <div class="flex items-center">
                            <div class="w-full border bg-gray-200 hover:bg-gray-300 border-slate-200 p-1 px-2 mb-1 rounded-md">
                                {{ $article_user->first_name }}
                                {{ $article_user->middle_name }}
                                {{ $article_user->last_name }}.
                    
                                @if($article_user->affiliation) ({{ $article_user->affiliation }}) @endif
                            </div>
                            
                            <div class="mb-1">
                                <x-button class="ml-2 bg-red-500 hover:bg-red-700 text-xs" wire:click="removeAuthor({{ $key }})">Remove</x-button>
                            </div>
                        </div>
                        @endforeach 
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
        

        <div class="mt-4 mb-6 text-center">
            
            <x-button class="bg-green-700 hover:bg-green-600" type="submit" wire:click="store()" wire:loading.attr="disabled">
                {{ __('Save & Submit') }}
            </x-button>
            <x-button class="bg-red-700 hover:bg-red-600" type="submit" wire:click="cancel()" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-button>
                    
        </div>
    </div>


    <x-dialog-modal wire:model="create_juser">
        <x-slot name="title">
            {{ __('Create New Author') }}
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-2 gap-2">
                <div class="mt-4">
                    <x-label for="juser_title" value="Title" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="juser_title" class="w-full" :options="$salutations" wire:model="juser_salutation_id" />
                    <x-input-error for="juser_title" />
                </div>

                <div class="mt-4">
                    <x-label for="juser_gender" value="Gender" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="juser_gender" class="w-full" :options="['Male' => 'Male', 'Female' => 'Female']" wire:model="juser_gender" />
                    <x-input-error for="juser_gender" />
                </div>
            </div>
                
            <div class="mt-4">
                <x-label for="juser_lname" value="Last Name" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input type="text" id="juser_lname" class="w-full" wire:model="juser_lname" />
                <x-input-error for="juser_lname" />
            </div>
            
            
            <div class="grid grid-cols-2 gap-2">
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
            </div>

            <div class="grid grid-cols-2 space-x-2">
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

            <div class="grid grid-cols-2 space-x-2">
                <div class="mt-4">
                    <x-label for="juser_affiliation" value="Affiliation" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="juser_affiliation" class="w-full" wire:model="juser_affiliation" />
                    <x-input-error for="juser_affiliation" />
                </div>
                <div class="mt-4">
                    <x-label for="juser_country_id" value="Country" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="juser_country_id" class="w-full" :options="$countries" wire:model="juser_country_id" />
                    <x-input-error for="juser_country_id" />
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            
            <x-button type="submit" wire:click="storeJuser()" wire:loading.attr="disabled">
                {{ __('Submit') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('create_juser')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>
 
</div>

<script>
    window.addEventListener('contentChangedx', (e) => {
        tinymce.remove('#abstract');
        tinymce.init({
            selector: '#abstract',
            plugins: 'code advlist lists table link',
            
            height: 400,
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
                    @this.set('abstract', editor.getContent());
                });
            },
        });
    });

</script>