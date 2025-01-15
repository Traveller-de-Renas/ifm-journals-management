<div>
    <div class="bg-gray-800 text-white bg-blend-overlay py-4" style="background-image: url({{ asset('images/auth-image.jpg') }}); background-position: top;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-2 ">
                
                <div class="col-span-10 w-full mb-2 mt-2">
                    <p class="text-4xl font-bold">
                        {{ __($record->title) }} ({{ strtoupper($record->code) }})
                    </p>

                    <div class="mb-2">
                        <div class="text-sm">
                            {{ $record->chief_editor?->salutation?->title }} {{ $record->chief_editor?->first_name }} {{ $record->chief_editor?->middle_name }} {{ $record->chief_editor?->last_name }} 
                            {{ $record->chief_editor?->affiliation != '' ? '('. $record->chief_editor?->affiliation.')' : '' }}
                        </div>
                    </div>

                    <br>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">ISSN </p>
                        <p class="col-span-11">: {{ $record->issn }}</p>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">EISSN </p>
                        <p class="col-span-11">: {{ $record->eissn }}</p>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">EMAIL </p>
                        <p class="col-span-11">: {{ $record->email }}</p>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <p class="text-sm font-bold">CREATED </p>
                        <p class="col-span-11">: {{ $record->created_at }}</p>
                    </div>

                    <br>
                    <hr>

                    <div class="w-full text-justify mt-4 mb-4">
                        {!! $record->description !!}
                    </div>

                    
                </div>
                <div class="col-span-2">
                    @if($record->image == '')
                    <div class="p-2">
                        <svg class="w-full text-white dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/>
                        </svg>
                    </div>
                    @else
                        <img class="w-full rounded-md rounded-bl-md mt-4" src="{{ asset('storage/journals/'.$record->image) }}" alt="{{ strtoupper($record->code) }}">
                    @endif

                    <a href="{{ route('journals.submission', $record->uuid) }}">
                        <x-button class="mb-4 mt-2 w-full">Submit a Paper </x-button>
                    </a>
                </div>

            </div>
        </div>
    </div>

<div class="w-full max-w-7xl mx-auto sm:px-6 lg:px-8">

    <div class="grid grid-cols-12 gap-2 mt-4">
        <div class="col-span-2">
            <a href="{{ route('journals.details', $record->uuid) }}"><div class="p-2 w-full bg-gray-300 hover:bg-gray-400 text-gray-800 shadow-md cursor-pointer text-center">Author</div></a>
        </div>
        <div class="col-span-2">
            <a href="{{ route('journals.editor', $record->uuid) }}"><div class="p-2 w-full bg-gray-300 hover:bg-gray-400 text-gray-800 shadow-md cursor-pointer text-center">Editor</div></a>
        </div>
    </div>

    <br>

    <div class="w-full mb-4">
        <p class="text-lg font-bold mb-2">Editorial Board</p>

        @if ($record->chief_editor?->id == auth()->user()->id || Auth()->user()->hasPermissionTo('Add Editorial Board'))
            <div class="flex gap-2" >
                <div class="w-full">
                    <x-input type="text" class="rounded-md w-full" wire:model="seditor" wire:keyup="searchEditor($event.target.value)" placeholder="Search User" />
                </div>
                <div class="w-2/12">
                    <x-button class="rounded-md w-full" wire:click="createJuser();">Create</x-button>
                </div>
            </div>
        @endif

        <div class="results mt-2 rounded-md">
            @if(!empty($editor_names) && $seditor != '')

            <div class="w-full bg-white shadow-lg rounded-lg">
                @foreach ($editor_names as $key => $editor)
                    <label class="w-full p-2 hover:bg-gray-300 cursor-pointer flex gap-4 rounded-lg" for="editor{{ $editor->id }}" wire:click="assignEditor({{ $editor->id }})">
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

        <div class="w-full mb-4">

            <div class="w-full mt-2">
               @foreach ($record->journal_users()->where('role', 'editor')->get() as $key => $journal_user)
               
                    <div class="flex w-full mb-2" >
                        <div class="w-full border bg-white hover:bg-gray-200 border-slate-200 px-2 cursor-pointer rounded-lg mr-2" wire:click="editorDetails({{ $key }});">
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

                        @if (Auth()->user()->id == $record->user_id || Auth()->user()->hasPermissionTo('Add Editorial Board'))
                            <div class="w-2/12 flex justify-between gap-2">
                                <x-button class="w-full text-sm" wire:click="chiefEditor({{ $journal_user->id }})" >
                                    Chief
                                </x-button>

                                <x-button-plain class="w-full bg-red-600 text-sm flex items-center justify-center" wire:click="removeEditor({{ $journal_user->id }})">
                                    <svg class="h-4 w-4 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="3 6 5 6 21 6" />  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" /></svg>
                                </x-button-plain>
                            </div>
                        @endif
                    </div>
                
                    <div class="p-2 text-sm border mb-2 rounded-lg bg-white @if($key != $editor_detail) hidden @endif" >
                        <div class="w-full grid grid-cols-12 gap-2">
                            <div class="text-sm col-span-2">Affiliation </div><div class="text-sm col-span-10">: {{ $journal_user->affiliation }}</div>
                            <div class="text-sm col-span-2">Degree </div><div class="text-sm col-span-10">: {{ $journal_user->degree }}</div>
                            <div class="text-sm col-span-2">Email </div><div class="text-sm col-span-10">: {{ $journal_user->email }}</div>
                            <div class="text-sm col-span-2">Category </div><div class="text-sm col-span-10">: {{ $journal_user->category }}</div>
                        </div>
                    </div>
                @endforeach 
            </div>
        </div>
    </div>

    <br>

    <p class="text-lg font-bold mb-2">Manuscripts and Submissions</p>
    <div class="md:grid md:grid-cols-12 gap-4 w-full mt-4">

        <div class="col-span-3">
            @foreach ($statuses as $statex)
                <div wire:click="article_status('{{ $statex->code }}')" class="mb-1 ">
                    <p class="w-full font-bold p-2 border-b cursor-pointer text-blue-700 hover:text-blue-500">
                        {{ $statex->name }}
                        ({{ $statex->articles()->where('article_status_id', $statex->id)->where('journal_id', $record->id)->count() }})
                    </p>
                </div>
            @endforeach

            <br>
            <br>
        </div>

        <div class="col-span-9">
            @if ($articles->count() > 0)
                @foreach ($articles as $key => $article)
                    <div class="border rounded-lg mb-4 bg-gray-200">
                        <a href="{{ route('journals.article', $article->uuid) }}">
                            <div class="bg-white p-2 text-sm font-bold hover:bg-gray-100 rounded-t-lg">
                                
                                <div class="text-sm font-bold hover:text-blue-600 ">
                                    {{ $article->title }}
                                </div>
                                <div class="text-xs text-blue-700 hover:text-blue-600 mb-2">

                                    {{ $article?->author?->salutation?->title }} {{ $article?->author?->first_name }} {{ $article?->author?->middle_name }} {{ $article?->author?->last_name }},
                                    
                                    @foreach ($article->article_users()->wherePivot('role', 'author')->get() as $key => $article_user)
                                        {{ $article_user->salutation?->title }} {{ $article_user->first_name }} {{ $article_user->middle_name }} {{ $article_user->last_name }},
                                    @endforeach

                                </div>
                            </div>
                        </a>
                        
                        <div class="w-full p-2 flex gap-2 ">
                            <div class="w-4/12">
                                <span class="w-full text-gray-900 text-xs px-2 py-1 rounded {{ $article->article_status->color }}
                                ">{{ $article->article_status->name }}</span>
                            </div>

                            @php
                                $a_editor = $article->editors()->first();
                            @endphp
                            @if ($record?->chief_editor?->id == auth()->user()->id && !empty($a_editor))
                                <div class="w-8/12 bg-blue-100 text-xs p-1 px-2 rounded-lg items-center">
                                    Assigned to : {{ $a_editor?->salutation?->title }} {{ $a_editor?->first_name }} {{ $a_editor?->middle_name }} {{ $a_editor?->last_name }}
                                </div>
                            @endif
                            
                            <div class="w-full flex gap-2 justify-end">
                                @if((in_array(auth()->user()->id, $article->article_users()->wherePivot('role', 'author')->get()->pluck('id')->toArray()) || $article->author?->id == auth()->user()->id) && ($article->article_status->code == '001' || $article->article_status->code == '012' || $article->article_status->code == '013'))
                                    <a href="{{ route('journals.submission', [$record->uuid, $article->uuid]) }}">
                                        <x-button-plain class="bg-blue-700">
                                            <svg class="h-3 w-3 text-white"  viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" /></svg>
                                        </x-button-plain>
                                    </a>
                                @endif


                                @if ($article->author?->id == auth()->user()->id && $article->article_status->code == '001')
                                    <x-button-plain class="bg-red-700" wire:click="confirmDelete({{ $article->id }})" >
                                        <svg class="h-3 w-3 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <polyline points="3 6 5 6 21 6" />  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" /></svg>
                                    </x-button-plain>
                                @endif


                                @if ($article->author?->id == auth()->user()->id && $article->article_status->code == '002')
                                    <button class="bg-red-700 hover:bg-red-800 text-white text-xs py-1 px-2 rounded" wire:click="confirm({{ $article->id }}, 'Cancel Submission', 'cancelSubmission')" >
                                        <span class="text-xs">Cancel Submission</span>
                                    </button>
                                @endif

                            </div>
                        </div>
                    </div>
                    
                @endforeach
            @else
            
                <div class="w-full bg-blue-400 rounded shadow p-2 text-center">No Articles Found</div>

            @endif

            <div class="mt-4 w-full">
                {{ $articles->links() }}
            </div>
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
            <x-secondary-button class="ml-3" wire:click="$toggle('signupModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>

</div>