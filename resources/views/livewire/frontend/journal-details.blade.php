<x-module>
    <x-slot name="title">
        {{ __($record->title) }} ({{ $record->code }})
    </x-slot>
    
    <div class="grid grid-cols-12 gap-2 bg-gray-200 rounded">
        <div class="col-span-1">
            @if($record->image == '')
            <div class="p-2">
                <svg class="w-full text-white dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                    <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/>
                </svg>
            </div>
            @else
                <img class="h-full w-full rounded-tl-md rounded-bl-md" src="{{ asset('storage/journals/'.$record->image) }}" width="40" height="40" alt="{{ $record->code }}">
            @endif
        </div>
        <div class="col-span-11 w-full mb-2 mt-2">
            <div class="grid grid-cols-12 gap-2">
                <p class="text-sm">ISSN </p>
                <p class="col-span-11">: {{ $record->issn }}</p>
            </div>

            <div class="grid grid-cols-12 gap-2">
                <p class="text-sm">EISSN </p>
                <p class="col-span-11">: {{ $record->eissn }}</p>
            </div>

            <div class="grid grid-cols-12 gap-2">
                <p class="text-sm">EMAIL </p>
                <p class="col-span-11">: {{ $record->email }}</p>
            </div>

            <div class="grid grid-cols-12 gap-2">
                <p class="text-sm">CREATED </p>
                <p class="col-span-11">: {{ $record->created_at }}</p>
            </div>
        </div>
    </div>

    <div class="w-full text-justify mt-4 mb-4">
        {!! $record->description !!}
    </div>

    <div>
        @if(auth()->user())
            @if (!$record->journal_users->contains(auth()->user()->id))
                <x-button wire:click="signup()" >Register </x-button>
            @endif
        @endif

        <a href="{{ route('journals.submission', $record->uuid) }}">
            <x-button class="mb-4">Submit a Paper </x-button>
        </a>

        <a href="{{ route('journal.articles', $record->uuid) }}">
            <x-button class="mb-4">Publications </x-button>
        </a>
    </div>

    <div class="md:grid md:grid-cols-12 gap-4 w-full ">

        <div class="col-span-9">
            <div class="w-full mb-4">
                <p class="text-lg font-bold mb-2">Aim and Scope</p>
                <div class="text-justify">
                    {!! $record->scope !!}
                </div>
            </div>

            <div class="w-full mb-4">
                <p class="text-lg font-bold mb-2">Editorial Board</p>

                @if(auth()->user())
                @if ($record->chief_editor?->id == auth()->user()->id || Auth()->user()->hasPermissionTo('Add Editorial Board'))
                <div class="flex gap-2" >
                    <x-input type="text" class="rounded-none" wire:model="seditor" wire:keyup="searchEditor($event.target.value)" placeholder="Search User" />
                    <x-button wire:click="createJuser();">Create</x-button>
                </div>
                @endif 

                <div class="results">
                    @if(!empty($editor_names) && $seditor != '')

                    <div class="w-full bg-gray-200 shadow-lg">
                        @foreach ($editor_names as $key => $editor)
                            <label class="w-full bg-gray-200 p-2 hover:bg-gray-300 cursor-pointer flex gap-4" for="editor{{ $editor->id }}" wire:click="assignEditor({{ $editor->id }})">
                                
                                <div>
                                    <x-input type="checkbox" wire:model="editor_ids" id="editor{{ $editor->id }}" value="{{ $editor->id }}" />
                                </div>
                                <div>
                                    {{ $editor->salutation?->title }} {{ $editor->first_name }} {{ $editor->middle_name }} {{ $editor->last_name }}
                                </div>
                                
                            </label>
                        @endforeach
                    </div>
                    
                    @endif
                </div>
                @endif

                <div class="w-full mt-2">
                   @foreach ($record->journal_users()->where('role', 'editor')->get() as $key => $journal_user)
                   
                        <div class="flex w-full" >
                            <div class="w-full border bg-gray-100 hover:bg-gray-200 border-slate-200 px-4 rounded-sm cursor-pointer" wire:click="editorDetails({{ $key }});">
                                {{ $journal_user->salutation?->title }}
                                {{ $journal_user->first_name }}
                                {{ $journal_user->middle_name }}
                                {{ $journal_user->last_name }}

                                {{ $journal_user->affiliation != '' ? '('.$journal_user->affiliation.')' : '' }}

                                @if ($journal_user->id == $record->user_id)
                                    <p class="text-xs text-green-400">Chief Editor</p>
                                @else
                                    <p class="text-xs text-blue-400">Editor</p>
                                @endif
                            </div>

                            @if(auth()->user())
                            @if (Auth()->user()->id == $record->user_id || Auth()->user()->hasPermissionTo('Add Editorial Board'))
                            
                                <x-button class="ml-2 " wire:click="chiefEditor({{ $journal_user->id }})" >
                                    Chief
                                </x-button>

                                <x-button-plain class="ml-2 bg-red-600" wire:click="removeEditor({{ $journal_user->id }})">
                                    <svg class="h-4 w-4 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="3 6 5 6 21 6" />  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" /></svg>
                                </x-button-plain>
                            
                            @endif
                            @endif
                        </div>
                    
                        <div class="p-2 text-sm border @if($key != $editor_detail) hidden @endif" >
                            <div class="w-full">
                                <div class="text-sm w-full">Affiliation : {{ $journal_user->affiliation }}</div>
                                <div class="text-sm w-full">Degree : {{ $journal_user->degree }}</div>
                                <div class="text-sm w-full">Email : {{ $journal_user->email }}</div>
                                <div class="text-sm w-full">Category : {{ $journal_user->category }}</div>
                            </div>
                        </div>
                    @endforeach 
                </div>
            </div>

            @if(!empty($record->indecies))
            <div class="w-full mb-4">
                <p class="text-lg font-bold mb-2">Indexing</p>
                
                @foreach ($record->indecies as $index)
                    <div class="rounded-sm border border-slate-200 mb-2" x-data="{ open: false }">
                        <div class="w-full p-2 cursor-pointer" @click.prevent="open = !open" :aria-expanded="open">
                            <div class="text-slate-800">
                                <a href="{{ $index->link }}" target="_blank" >{{ $index->title }}</a>
                            </div>
                        </div>
                        <div class="text-sm p-2" x-show="open" x-cloak="">
                            {{ $index->description }}
                        </div>
                    </div>
                @endforeach
                
            </div>
            @endif

            @if(!empty($record->instructions))
            <div class="w-full mb-2">
                <p class="text-lg font-bold mb-2">Authors' Guidelines</p>

                @foreach ($record->instructions as $instruction)
                    <div class="rounded-sm border border-slate-200 mb-2" x-data="{ open: false }">
                        <div class="w-full p-2 cursor-pointer" @click.prevent="open = !open" :aria-expanded="open">
                            <div class=" text-slate-800">{{ $instruction->title }}</div>
                        </div>
                        <div class="text-sm text-justify p-2" x-show="open" x-cloak="">
                            {{ $instruction->description }}
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="col-span-3">
            <div class="bg-gray-100 border rounded p-2">
                <p class="text-center">Recent Articles</p>
            </div>
            @foreach ($record->articles()->orderBy('created_at', 'desc')->limit(5)->get() as $key => $article)
                <a href="{{ route('journal.article', $article->uuid) }}">
                    <div class="text-sm font-bold text-blue-700 hover:text-blue-600 hover:bg-gray-100 cursor-pointer p-2 border rounded-md mb-2 mt-2">
                        {{ $article->title }}
                    </div>
                </a>
            @endforeach

            <a href="{{ route('journal.articles', $record->uuid) }}">
                <x-button class="mb-4 w-full ">View All </x-button>
            </a>

            <br>
            <br>

            <div class="bg-gray-100 border rounded p-2">
                <p class="text-center">Acceptable Article Types</p>
            </div>

            @foreach ($record->article_types as $key => $article_type)
                <div class="text-sm font-bold text-blue-700 hover:text-blue-600 hover:bg-gray-100 cursor-pointer p-2 border rounded-md mb-2 mt-2">
                    {{ $article_type->name }}
                </div>
            @endforeach
        </div>
    </div>

    <x-dialog-modal wire:model="create_juser">
        <x-slot name="title">
            {{ __('Create New Editor') }}
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


    <x-dialog-modal wire:model="signupModal">
        <x-slot name="title">
            {{ __('Delete Data') }}
        </x-slot>
        <x-slot name="content">
            <div class="mt-4">
                <p class="text-center">Are you sure you want to sign up for this journal.?</p>
            </div>
        </x-slot>
        <x-slot name="footer">
            
            <x-button type="submit" wire:click="confirmSignUp({{ $record->id }})" wire:loading.attr="disabled" >
                {{ __('Confirm') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('Edit')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>

</x-module>