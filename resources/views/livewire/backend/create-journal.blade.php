<div class="bg-white shadow-md p-4 rounded">
    {{ __('CREATE JOURNAL') }}

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
        
    <div class="p-4 w-full">
        <ol class="relative text-gray-500 border-s border-gray-200 dark:border-gray-700 dark:text-gray-400">                  
            <li class="mb-10 ms-6" > 
                <div class="flex items-center justify-start cursor-pointer" wire:click="setStep(1)">     
                    <span class="absolute flex items-center justify-center w-8 h-8 rounded-full -start-4 ring-4 ring-white {{ $step >= 1 ? 'bg-blue-700 text-white' : 'bg-gray-300 text-gray-600' }}" >
                        <svg class="w-3.5 h-3.5 text-white dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                            <path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z"/>
                        </svg>
                    </span>
                    <h3 class="font-semibold leading-tight hover:text-blue-700" >General Information</h3>
                </div>
               
                <div class="w-full @if ($step != 1) hidden @endif">
                    <div class="mt-4">
                        <x-label for="title" value="Title" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input type="text" id="title" class="w-full" wire:model="title" />
                        <x-input-error for="title" />
                    </div>

                    <div class="grid grid-cols-3 space-x-2">
                        <div class="mt-4">
                            <x-label for="code" value="Code" class="mb-2 block font-medium text-sm text-gray-700" />
                            <x-input type="text" id="code" class="w-full" wire:model="code" />
                            <x-input-error for="code" />
                        </div>
                        <div class="mt-4">
                            <x-label for="issn" value="ISSN" class="mb-2 block font-medium text-sm text-gray-700" />
                            <x-input type="text" id="issn" class="w-full" wire:model="issn" />
                            <x-input-error for="issn" />
                        </div>
                        <div class="mt-4">
                            <x-label for="eissn" value="EISSN" class="mb-2 block font-medium text-sm text-gray-700" />
                            <x-input type="text" id="eissn" class="w-full" wire:model="eissn" />
                            <x-input-error for="eissn" />
                        </div>
                    </div>

                    <div class="grid grid-cols-3 space-x-2">
                        <div class="mt-4">
                            <x-label for="doi" value="DOI" class="mb-2 block font-medium text-sm text-gray-700" />
                            <x-input type="text" id="doi" class="w-full" wire:model="doi" />
                            <x-input-error for="doi" />
                        </div>
                        <div class="mt-4">
                            <x-label for="email" value="Email" class="mb-2 block font-medium text-sm text-gray-700" />
                            <x-input type="text" id="email" class="w-full" wire:model="email" />
                            <x-input-error for="email" />
                        </div>
                        <div class="mt-4">
                            <x-label for="website" value="Website" class="mb-2 block font-medium text-sm text-gray-700" />
                            <x-input type="text" id="website" class="w-full" wire:model="website" />
                            <x-input-error for="website" />
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-3 space-x-2">
                        <div class="mt-4 col-span-2">
                            <x-label for="publisher" value="Publisher" class="mb-2 block font-medium text-sm text-gray-700" />
                            <x-input type="text" id="publisher" class="w-full" wire:model="publisher" />
                            <x-input-error for="publisher" />
                        </div>
                        <div class="mt-4">
                            <x-label for="year" value="Year" class="mb-2 block font-medium text-sm text-gray-700" />
                            <x-input type="text" id="year" class="w-full" wire:model="year" />
                            <x-input-error for="year" />
                        </div>
                    </div>

                    <div class="grid grid-cols-3 space-x-2">
                        <div class="mt-4">
                            <x-label for="image" value="Image" class="mb-2 block font-medium text-sm text-gray-700" />
                            <x-input-file type="file" id="image" class="w-full" wire:model="image" />
                            <x-input-error for="image" />
                        </div>

                        <div class="mt-4">
                            <x-label for="category" value="Category" class="mb-2 block font-medium text-sm text-gray-700" />
                            <x-select id="category" class="w-full" :options="$categories" wire:model="category" :selected="$category" />
                            <x-input-error for="category" />
                        </div>
                            
                        <div class="mt-4">
                            <x-label for="status" value="status" class="mb-2 block font-medium text-sm text-gray-700" />
                            <x-select id="status" class="w-full" :options="['1' => 'Active', '0' => 'Inactive']" wire:model="status" />
                            <x-input-error for="status" />
                        </div>
                    </div>

                    <div class="mt-4" wire:ignore>
                        <x-label for="description" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-textarea type="text" id="description" class="w-full" wire:model="description" rows="6" />
                        <x-input-error for="description" />
                    </div>

                    <div class="mt-4" wire:ignore>
                        <x-label for="scope" value="Aim and Scope" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-textarea type="text" id="scope" class="w-full" wire:model="scope" rows="6" />
                        <x-input-error for="scope" />
                    </div>

                </div>
            </li>


            <li class="mb-10 ms-6">
                <div class="flex items-center justify-start cursor-pointer" wire:click="setStep(2)">     
                    <span class="absolute flex items-center justify-center w-8 h-8 rounded-full -start-4 ring-4 ring-white {{ $step >= 2 ? 'bg-blue-700 text-white' : 'bg-gray-300 text-gray-600' }}" >
                        <svg class="w-3.5 h-3.5 text-white dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                            <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                        </svg>
                    </span>
                    <h3 class="font-semibold leading-tight hover:text-blue-700" > Authors' Guidelines</h3>
                </div>

                <div class="@if ($step != 2) hidden @endif">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="mt-4 col-span-2">
                            <x-label for="" value="Title" class="block font-medium text-sm text-gray-700" />
                        </div>

                        <div class="mt-4 col-span-9" >
                            <x-label for="" value="Description" class="block font-medium text-sm text-gray-700" />
                        </div>

                        <div class="mt-4">
                        </div>
                    </div>
                    @foreach ($instructions as $key => $instruction)
                    
                    <div class="grid grid-cols-12 gap-4 mb-2">
                        <div class="col-span-2">
                            <x-input type="text" id="instruction_title" class="w-full" wire:model="instruction_title.{{ $key }}" />
                            <x-input-error for="instruction_title" />
                        </div>

                        <div class="col-span-9" wire:ignore>
                            <x-textarea type="text" id="instruction_description" class="w-full h-10" wire:model="instruction_description.{{ $key }}" />
                            <x-input-error for="instruction_description" />
                        </div>

                        <div class="text-right">
                            <x-button class="bg-red-700" wire:click="removeRow({{ $key }}, 'instructions')">
                                <svg class="h-5 w-5 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="3 6 5 6 21 6" />  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" /></svg>
                            </x-button>
                        </div>
                    </div>

                    @endforeach

                    <div class="text-right mt-4">
                        <x-button type="button" wire:click="addRows('instructions')" wire:loading.attr="disabled">
                            {{ __('Add More') }}
                        </x-button>
                    </div>
                </div>
            </li>
            

            {{-- <li class="mb-10 ms-6">
                <div class="flex items-center justify-start cursor-pointer" wire:click="setStep(3)">     
                    <span class="absolute flex items-center justify-center w-8 h-8 rounded-full -start-4 ring-4 ring-white {{ $step >= 3 ? 'bg-blue-700 text-white' : 'bg-gray-300 text-gray-600' }}" >
                        <svg class="w-3.5 h-3.5 text-white dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                            <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                        </svg>
                    </span>
                    <h3 class="font-semibold leading-tight hover:text-blue-700" >Indexing</h3>
                </div>

                <div class="@if ($step != 3) hidden @endif">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-3">
                            <x-label for="index_title" value="Title" class="mb-2 block font-medium text-sm text-gray-700" />
                        </div>

                        <div class="col-span-5">
                            <x-label for="index_description" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                        </div>

                        <div class="col-span-3">
                            <x-label for="index_link" value="Link" class="mb-2 block font-medium text-sm text-gray-700" />
                        </div>

                        <div class="">
                        </div>
                    </div>
                    @foreach ($indecies as $key => $index)
                    
                    <div class="grid grid-cols-12 gap-4 mb-2">
                        <div class="col-span-3">
                            <x-input type="text" id="index_title" class="w-full" wire:model="index_title.{{ $key }}" />
                            <x-input-error for="index_title" />
                        </div>

                        <div class="col-span-5" @if(!$form) wire:ignore @endif>
                            <x-textarea type="text" id="index_description" class="w-full h-10" wire:model="index_description.{{ $key }}" />
                            <x-input-error for="index_description" />
                        </div>

                        <div class="col-span-3">
                            <x-input type="text" id="index_link" class="w-full" wire:model="index_link.{{ $key }}" />
                            <x-input-error for="index_link" />
                        </div>

                        <div class="text-right">
                            <x-button class="bg-red-700" wire:click="removeRow({{ $key }}, 'instructions')">
                                <svg class="h-5 w-5 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="3 6 5 6 21 6" />  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" /></svg>
                            </x-button>
                        </div>
                    </div>

                    @endforeach

                    <div class="text-right mt-4">
                        <x-button type="button" wire:click="addRows('indecies')" wire:loading.attr="disabled">
                            {{ __('Add More') }}
                        </x-button>
                    </div>
                </div>
            </li> --}}


            <li class="mb-10 ms-6">
                <div class="flex items-center justify-start cursor-pointer" wire:click="setStep(4)">     
                    <span class="absolute flex items-center justify-center w-8 h-8 rounded-full -start-4 ring-4 ring-white {{ $step >= 4 ? 'bg-blue-700 text-white' : 'bg-gray-300 text-gray-600' }}" >
                        <svg class="w-3.5 h-3.5 text-white dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                            <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                        </svg>
                    </span>
                    <h3 class="font-semibold leading-tight hover:text-blue-700" wire:click="setStep(4)">Article Type</h3>
                </div>

                <div class="@if ($step != 4) hidden @endif">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-4">
                            <x-label for="type_name" value="Title" class="mb-2 block font-medium text-sm text-gray-700" />
                        </div>

                        <div class="col-span-7">
                            <x-label for="type_description" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                        </div>
                        <div class="text-right">
                        </div>
                    </div>
                    
                    @foreach ($article_types as $key => $article_type)
                    
                    <div class="grid grid-cols-12 gap-4 mb-2">
                        <div class="col-span-4">
                            <x-input type="text" id="type_name" class="w-full" wire:model="type_name.{{ $key }}" />
                            <x-input-error for="type_name" />
                        </div>

                        <div class="col-span-7">
                            <x-textarea type="text" id="type_description" class="w-full h-10" wire:model="type_description.{{ $key }}" />
                            <x-input-error for="type_description" />
                        </div>
                        <div class="text-right">
                            <x-button class="bg-red-700" wire:click="removeRow({{ $key }}, 'article_types')">
                                <svg class="h-5 w-5 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="3 6 5 6 21 6" />  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" /></svg>
                            </x-button>
                        </div>
                    </div>

                    @endforeach

                    <div class="text-right mt-4">
                        <x-button type="button" wire:click="addRows('article_types')" wire:loading.attr="disabled">
                            {{ __('Add More') }}
                        </x-button>
                    </div>
                </div>
            </li>


            {{-- <li class="mb-10 ms-6">
                <div class="flex items-center justify-start cursor-pointer" wire:click="setStep(5)">     
                    <span class="absolute flex items-center justify-center w-8 h-8 rounded-full -start-4 ring-4 ring-white {{ $step >= 5 ? 'bg-blue-700 text-white' : 'bg-gray-300 text-gray-600' }}" >
                        <svg class="w-3.5 h-3.5 text-white dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                            <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                        </svg>
                    </span>
                    <h3 class="font-semibold leading-tight hover:text-blue-700" >File Categories</h3>
                </div>

                <div class="@if ($step != 5) hidden @endif">
                    
                </div>
            </li> --}}


            <li class="ms-6">
                <div class="flex items-center justify-start cursor-pointer" wire:click="setStep(6)">     
                    <span class="absolute flex items-center justify-center w-8 h-8 rounded-full -start-4 ring-4 ring-white {{ $step >= 6 ? 'bg-blue-700 text-white' : 'bg-gray-300 text-gray-600' }}" >
                        <svg class="w-3.5 h-3.5 text-white dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                            <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z"/>
                        </svg>
                    </span>
                    <h3 class="font-semibold leading-tight mb-4 hover:text-blue-700" >Confirmation & Submission</h3>
                </div>

                <div class="@if ($step != 6) hidden @endif">
                    @foreach ($confirmations as $key => $confirmation)
                    
                    <div class="grid grid-cols-12 gap-2 mb-2">
                        <div class="col-span-11" wire:ignore>
                            <x-textarea type="text" id="confirmation_description" class="w-full h-10" wire:model="confirmation_description.{{ $key }}" placeholder="Enter Confirmation Description" />
                            <x-input-error for="confirmation_description" />
                        </div>
                        <div class="text-right">
                            <x-button class="bg-red-500 hover:bg-red-700" wire:click="removeRow({{ $key }}, 'confirmations')">
                                <svg class="h-5 w-5 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="3 6 5 6 21 6" />  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" /></svg>
                            </x-button>
                        </div>
                    </div>

                    @endforeach

                    <div class="text-right mt-4 mb-4">
                        <x-button type="button" wire:click="addRows('confirmations')" wire:loading.attr="disabled">
                            {{ __('Add More') }}
                        </x-button>
                    </div>
                </div>
                
            </li>
        </ol>

        <hr>

        <div class="mt-4">
            <div class="text-center text-sm mb-4">Before submission please check and confirm details of the journal</div>
            <div class="text-center">
                
                @if(!empty($record)) 
                <x-button type="submit" wire:click="update({{ $record->id }})" wire:loading.attr="disabled">
                    {{ __('Update Journal') }}
                </x-button>
                
                @else 
                <x-button type="submit" wire:click="store()" wire:loading.attr="disabled">
                    {{ __('Submit Journal') }}
                </x-button>
                
                @endif
                
                <a href="{{ route('journals.index') }}">
                <x-button class="bg-red-500 hover:bg-red-700" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-button>
                </a>

            </div>
        </div>

    </div>


</div>

<script>
    window.addEventListener('contentChanged', (e) => {
        tinymce.remove('#description');
        tinymce.init({
            selector: '#description',
            plugins: 'code advlist lists table link',
            
            /* TinyMCE configuration options */
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
                    @this.set('description', editor.getContent());
                });
            },
        });
    
        tinymce.remove('#scope');
        tinymce.init({
            selector: '#scope',
            plugins: 'code advlist lists table link',
            
            /* TinyMCE configuration options */
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
                    @this.set('scope', editor.getContent());
                });
            },
        });
    });

</script>