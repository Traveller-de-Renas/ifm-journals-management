<x-module>
    
    <x-slot name="title">
        {{ __($journal->title) }}
        
        @if(!empty($record))
        <div class="text-sm">
            {{ $record->author?->salutation?->title }} {{ $record->author?->first_name }} {{ $record->author?->middle_name }} {{ $record->author?->last_name }} ({{ $record->author?->affiliation }})
        </div>
        @endif
        
        <p class="text-sm font-light">Article Submission</p>
    </x-slot>

<div class="w-full">
    <div class="flex items-center mb-6 w-full">
        <div class="flex flex-1 items-center justify-between w-full">
            <div class="flex items-center w-full cursor-pointer" wire:click="setStep(1)">
                <div class="rounded-full h-12 w-12 flex items-center justify-center {{ $step >= 1 ? 'bg-blue-700 text-white' : 'bg-gray-300 text-gray-600' }}">
                    1
                </div>
                <div class=" top-0 left-12 w-full h-1 bg-{{ $step > 1 ? 'blue-700' : 'gray-300' }}"></div>
            </div>
            <div class="flex items-center w-full cursor-pointer" wire:click="setStep(2)">
                <div class="rounded-full h-12 w-12 flex items-center justify-center {{ $step >= 2 ? 'bg-blue-700 text-white' : 'bg-gray-300 text-gray-600' }}">
                    2
                </div>
                <div class=" top-0 left-12 w-full h-1 bg-{{ $step > 2 ? 'blue-700' : 'gray-300' }}"></div>
            </div>
            {{-- <div class="flex items-center w-full cursor-pointer" wire:click="setStep(3)">
                <div class="rounded-full h-12 w-12 flex items-center justify-center {{ $step >= 3 ? 'bg-blue-700 text-white' : 'bg-gray-300 text-gray-600' }}">
                    3
                </div>
                <div class=" top-0 left-12 w-full h-1 bg-{{ $step > 3 ? 'blue-700' : 'gray-300' }}"></div>
            </div> --}}
            <div class="flex cursor-pointer" wire:click="setStep(3)">
                <div class="rounded-full h-12 w-12 flex items-center justify-center {{ $step >= 3 ? 'bg-blue-700 text-white' : 'bg-gray-300 text-gray-600' }}">
                    3
                </div>
            </div>
        </div>
    </div>
    
    <div>
        @if ($step == 1)
            <div class="w-full">

                <div class="grid grid-cols-2 gap-2">
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
                    <x-label for="title" value="Manuscript Title" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input class="" wire:model="title" id="title" type="text" placeholder="Manuscript Title" />
                    <x-input-error for="title" />
                </div>
        
                <div class="mt-4" wire:ignore>
                    <x-label for="abstract" value="Abstract" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-textarea type="text" id="abstract" class="w-full" wire:model="abstract" placeholder="Enter Abstract" rows="7" />
                    <x-input-error for="abstract" />
                </div>
                
                <div class="grid grid-cols-2 gap-2">
                    <div class="mt-4" >
                        <x-label for="keywords" value="Keywords" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input type="text" id="keywords" class="w-full" wire:model="keywords" placeholder="Enter Keywords" />
                        <x-input-error for="keywords" />
                    </div>
                    <div class="mt-4" >
                        <x-label for="areas" value="Areas" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input type="text" id="areas" class="w-full" wire:model="areas" placeholder="Enter areas" />
                        <x-input-error for="areas" />
                    </div>
                </div>

                <div class="mt-4 mb-4">
                    <x-label for="sauthor" value="Authors List" class="mb-2 block font-medium text-sm text-gray-700" />
                    <div class="flex gap-2" >
                        <x-input type="text" class="rounded-none" wire:model="sauthor" wire:keyup="searchAuthor($event.target.value)" placeholder="Search User" />
                        <x-button wire:click="createJuser();">Create</x-button>
                    </div>
                    <div class="results">
                        @if(!empty($author_names) && $sauthor != '')
    
                        <div class="w-full bg-gray-200 shadow-lg">
                            @foreach ($author_names as $key => $author)
                                <label class="w-full bg-gray-200 p-2 hover:bg-gray-300 cursor-pointer flex gap-4" for="author{{ $author?->id }}" wire:click="assignAuthor({{ $author->id }})">
                                    
                                    <div>
                                        <x-input type="checkbox" wire:model="author_ids" id="author{{ $author?->id }}" value="{{ $author?->id }}" />
                                    </div>
                                    <div>
                                        {{ $author?->salutation?->title }} {{ $author?->first_name }} {{ $author?->middle_name }} {{ $author?->last_name }}
                                    </div>
                                    
                                </label>
                            @endforeach
                        </div>
                        
                        @endif
                    </div>
                    
                    @if(!empty($record?->article_users))
                    <div class="mt-6">
                       @foreach ($record->article_users as $article_user)
                       <div class="flex items-center">
                            <div class="w-full border bg-gray-200 hover:bg-gray-300 border-slate-200 dark:border-slate-700 p-2 rounded-md">
                            {{ $article_user->first_name }}
                            {{ $article_user->middle_name }}
                            {{ $article_user->last_name }}
                            </div>
                            <div>
                                <x-button-plain class="ml-2 bg-red-600" wire:click="removeAuthor({{ $article_user->id }})">Remove</x-button-plain>
                            </div>
                        </div>
                        @endforeach 
                    </div>
                    @endif
                </div>

            </div>

        @elseif ($step == 2)
            <div class="w-full">
                <div class="grid grid-cols-12 gap-2">
                    
                    <div class="mt-4 col-span-3">
                        <x-label for="file_attachment" value="File" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input-file wire:model="attachment" id="file_attachment" />
                        <x-input-error for="file_attachment" />
                    </div>
                    <div class="mt-4 col-span-3">
                        <x-label for="file_category_id" value="File Category" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-select wire:model="file_category_id" id="file_category_id" class="w-full" :options="$file_categories" />
                        <x-input-error for="file_category_id" />
                    </div>
                    <div class="mt-4 col-span-4">
                        <x-label for="file_description" value="File Description" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input class="" wire:model="file_description" id="file_description" type="text" placeholder="File Description" />
                        <x-input-error for="file_description" />
                    </div>
                    <div class="mt-4">
                        <x-label for="publish" value="To Publish" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-select wire:model="publish" id="publish" class="w-full" :options="['1'=>'Yes', '0'=>'No']" />
                        <x-input-error for="publish" />
                    </div>
                    <div class="mt-4 text-right">
                        <x-button class="mt-8" wire:click="uploadDocument()" >Upload</x-button>
                    </div>

                </div>

                
                @if(!empty($record?->files))
                    @foreach ($record?->files as $key => $file)
                    
                    <div class="grid grid-cols-3 gap-2 w-full p-2 mt-6 bg-gray-200 rounded-lg">
                        <div class="flex items-center">{{ $file->file_category->name }}</div>
                        <div class="flex items-center">{{ $file->file_description }}</div>
                        <div class="flex gap-2 justify-end">
                            <a href="{{ asset('storage/articles/'.$file->file_path) }} " target="_blank" >
                            <x-button-plain class="bg-blue-700">
                                <svg class="h-4 w-4 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />  <polyline points="7 10 12 15 17 10" />  <line x1="12" y1="15" x2="12" y2="3" /></svg>
                            </x-button-plain>
                            </a>
                            <x-button-plain class="bg-red-700">
                                <svg class="h-4 w-4 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="3 6 5 6 21 6" />  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" /></svg>
                            </x-button-plain>
                        </div>
                    </div>

                    @endforeach
                @else
                    <div class="w-full p-2 mt-6 bg-gray-200 rounded-lg text-center">
                        No File(s) Uploaded
                    </div>
                @endif

            </div>
        @elseif ($step == 3)

            @foreach ($journal->confirmations as $key => $confirmation)
                <div class="w-full flex p-4 border rounded-lg mb-4">
                    <div class="w-11/12 text-justify">{{ $confirmation->description }}</div>
                    <div class="flex w-1/12 items-start justify-center">

                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="1" class="sr-only peer" wire:model="confirmations.{{ $key }}">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>
    
                    </div>
                </div>
            @endforeach

            <div class="grid grid-cols-4 gap-2">
                <div class="mt-4" >
                    <x-label for="figures" value="Number of Figures" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="number" id="figures" class="w-full" wire:model="figures" placeholder="Enter Numer of Figures" />
                    <x-input-error for="figures" />
                </div>
                <div class="mt-4" >
                    <x-label for="tables" value="Numer of Tables" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="number" id="tables" class="w-full" wire:model="tables" placeholder="Enter Numer of tables" />
                    <x-input-error for="tables" />
                </div>
                <div class="mt-4" >
                    <x-label for="words" value="Number of Words" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="number" id="words" class="w-full" wire:model="words" placeholder="Enter Number of Words" />
                    <x-input-error for="words" />
                </div>
                <div class="mt-4" >
                    <x-label for="pages" value="Number of Pages" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="number" id="pages" class="w-full" wire:model="pages" placeholder="Enter Number of Pages" />
                    <x-input-error for="pages" />
                </div>
            </div>

        {{-- @elseif ($step == 4) --}}
        @endif
    </div>
    
    <div class="flex justify-between mt-6">
        <button wire:click="decrementStep" class="bg-gray-500 text-white px-4 py-2 rounded {{ $step == 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $step == 1 ? 'disabled' : '' }}>Previous</button>
        <button wire:click="incrementStep" class="bg-blue-700 text-white px-4 py-2 rounded {{ $step == 4 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $step == 4 ? 'disabled' : '' }}>Next</button>
    </div>

    <div class="mt-4 text-center">

        @if(!empty($record))

            @if ($record->author?->id == auth()->user()->id)
                <x-button type="submit" wire:click="update('Submitted')" wire:loading.attr="disabled">
                    {{ __('Save & Submit') }}
                </x-button>
            @endif

            <x-button type="submit" wire:click="update('Pending')" wire:loading.attr="disabled">
                {{ __('Save as Draft') }}
            </x-button>
        
        @else

            <x-button type="submit" wire:click="store('Submitted')" wire:loading.attr="disabled">
                {{ __('Save & Submit') }}
            </x-button>
    
            <x-button type="submit" wire:click="store('Pending')" wire:loading.attr="disabled">
                {{ __('Save as Draft') }}
            </x-button>
        
        @endif

        
        <a href="{{ route('journals.details', $journal->uuid) }}">
            <x-button-plain class="bg-red-700" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-button-plain>
        </a>
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
                <x-label for="country_id" value="Country" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-select id="country_id" class="w-full" :options="$countries" wire:model="juser_country_id" />
                <x-input-error for="country_id" />
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

</x-module>

<script>
    window.addEventListener('contentChanged', (e) => {
        tinymce.remove('#abstract');
        tinymce.init({
            selector: '#abstract',
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
                    @this.set('abstract', editor.getContent());
                });
            },
        });
    });

</script>