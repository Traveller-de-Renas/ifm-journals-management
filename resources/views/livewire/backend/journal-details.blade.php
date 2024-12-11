<div class="w-full max-w-7xl mx-auto sm:px-6 lg:px-8">

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


    

    <div class="w-full grid grid-cols-3 gap-4 mt-6 mb-6">
        <div class="bg-gray-300 p-2 rounded-md shadow-md">
            Submissions

            <div class="border-b border-gray-200 mt-1"></div>

            <a href="{{ route('journals.articles', $record->uuid) }}">
            <div class="flex text-xs py-1" >
                <div class="w-full">New Submission</div>
                <div class="w-1/12">
                    {{ $record->articles()->whereHas('article_status', function($query){
                        $query->where('code', '002');
                    })->count() }}
                </div>
            </div>
            </a>

            <a href="{{ route('journals.articles', $record->uuid) }}">
            <div class="flex text-xs py-1">
                <div class="w-full">Sent Back</div>
                <div class="w-1/12">
                    {{ $record->articles()->whereHas('article_status', function($query){
                        $query->where('code', '013');
                    })->count() }}
                </div>
            </div>
            </a>
            
            <a href="{{ route('journals.articles', $record->uuid) }}">
            <div class="flex text-xs py-1">
                <div class="w-full">Declined</div>
                <div class="w-1/12">
                    {{ $record->articles()->whereHas('article_status', function($query){
                        $query->where('code', '007');
                    })->count() }}
                </div>
            </div>
            </a>
        </div>
        <div class="bg-gray-300 p-2 rounded-md shadow-md">
            Revisions
            <div class="border-b border-gray-200 mt-1"></div>

            <div class="flex text-xs py-1">
                <div class="w-full">In Revision</div>
                <div class="w-1/12">
                    {{ $record->articles()->whereHas('article_status', function($query){
                        $query->where('code', '004');
                    })->count() }}
                </div>
            </div>

            <div class="flex text-xs py-1">
                <div class="w-full">Sent Back</div>
                <div class="w-1/12">
                    {{ $record->articles()->whereHas('article_status', function($query){
                        $query->where('code', '005');
                    })->count() }}
                </div>
            </div>

            <div class="flex text-xs py-1">
                <div class="w-full">Declined Revision</div>
                <div class="w-1/12">
                    {{ $record->articles()->whereHas('article_status', function($query){
                        $query->where('code', '008');
                    })->count() }}
                </div>
            </div>

        </div>
        <div class="bg-gray-300 p-2 rounded-md shadow-md">
            Completed
            <div class="border-b border-gray-200 mt-1"></div>

            <div class="flex text-xs py-1">
                <div class="w-full">Completed</div>
                <div class="w-1/12">
                    {{ $record->articles()->whereHas('article_status', function($query){
                        $query->where('code', '006');
                    })->count() }}
                </div>
            </div>
            
        </div>
    </div>

    <div class="md:grid md:grid-cols-12 gap-4 w-full">

        <div class="col-span-3">
            @foreach ($statuses as $statex)
                <a href="{{ route('journals.articles', [$record->uuid, $statex->code]) }}" class="mb-1 ">
                    <p class="w-full font-bold text-blue-700 hover:text-blue-500 p-1">{{ $statex->name }} </p>
                </a>
            @endforeach

            {{-- @if(auth()->user() && auth()->user()->id != $record->chief_editor->id)
                @if (!$record->journal_users->contains(auth()->user()->id))
                    <x-button wire:click="signup()" class="col-span-2 w-full mb-4">Register </x-button>
                @endif
            @endif --}}
            <br>

            <a href="{{ route('journals.articles', $record->uuid) }}">
                <x-button class="mb-4 w-full ">View All </x-button>
            </a>

            <br>
            <br>

            {{-- <div class="bg-gray-100 border rounded p-2">
                <p class="text-center">Acceptable Article Types</p>
            </div>

            @foreach ($record->article_types as $key => $article_type)
                <div class="text-sm font-bold text-blue-700 hover:text-blue-600 hover:bg-gray-100 cursor-pointer p-2 border rounded-md mb-2 mt-2">
                    {{ $article_type->name }}
                </div>
            @endforeach --}}
        </div>

        <div class="col-span-9">
            @if($record->scope != '')
            <div class="w-full mb-4">
                <p class="text-lg font-bold mb-2">Aim and Scope</p>
                <div class="text-justify">
                    {!! $record->scope !!}
                </div>
            </div>
            @endif

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

                <div class="w-full mt-2">
                   @foreach ($record->journal_users()->where('role', 'editor')->get() as $key => $journal_user)
                   
                        <div class="flex w-full mb-2" >
                            <div class="w-full border bg-white hover:bg-gray-200 border-slate-200 px-2 cursor-pointer rounded-lg" wire:click="editorDetails({{ $key }});">
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

                                    <x-button-plain class="w-full bg-red-600 text-sm" wire:click="removeEditor({{ $journal_user->id }})">
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

            @if(!empty($record->indecies) && count($record->indecies) > 0)
            <div class="w-full mb-4">
                <p class="text-lg font-bold mb-2">Indexing</p>
                
                @foreach ($record->indecies as $index)
                    <div class="rounded-sm dark:bg-slate-800 border border-slate-200 dark:border-slate-700 cx95x ctysv mb-2" x-data="{ open: false }">
                        <button class="flex items-center cmgwo c3ff8 c2djl ci4cg" @click.prevent="open = !open" :aria-expanded="open">
                            <div class="text-sm text-slate-800 dark:text-slate-100 cw92y">
                                <a href="{{ $index->link }}" target="_blank" >{{ $index->title }}</a>
                            </div>
                            <svg class="ml-3 c1bvt cc44c ciz4v czgoy c3wll c7n6y chmgx c6dxj" :class="{ 'cb4kj': open }" viewBox="0 0 32 32">
                                <path d="M16 20l-5.4-5.4 1.4-1.4 4 4 4-4 1.4 1.4z"></path>
                            </svg>
                        </button>
                        <div class="text-sm" x-show="open" x-cloak="">
                            {{ $index->description }}
                        </div>
                    </div>
                @endforeach
                
            </div>
            @endif

            @if(!empty($record->instructions) && count($record->instructions) > 0)
            <div class="w-full mb-2">
                <p class="text-lg font-bold mb-2">Authors' Guidelines</p>

                @foreach ($record->instructions as $instruction)
                    <div class="rounded-sm dark:bg-slate-800 border border-slate-200 dark:border-slate-700 cx95x ctysv mb-2" x-data="{ open: false }">
                        <button class="flex items-center cmgwo c3ff8 c2djl ci4cg" @click.prevent="open = !open" :aria-expanded="open">
                            <div class="text-sm text-slate-800 dark:text-slate-100 cw92y">{{ $instruction->title }}</div>
                            <svg class="ml-3 c1bvt cc44c ciz4v czgoy c3wll c7n6y chmgx c6dxj" :class="{ 'cb4kj': open }" viewBox="0 0 32 32">
                                <path d="M16 20l-5.4-5.4 1.4-1.4 4 4 4-4 1.4 1.4z"></path>
                            </svg>
                        </button>
                        <div class="text-sm text-justify" x-show="open" x-cloak="">
                            {{ $instruction->description }}
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
        
    </div>

    @if(count($record->articles) > 0)
    <div class="bg-gray-100 border rounded p-2 mb-6">
        <p class="font-bold">Recent Articles</p>
    
        @foreach ($record->articles()->orderBy('created_at', 'desc')->limit(5)->get() as $key => $article)
            <a href="{{ route('journals.article', $article->uuid) }}">
                <div class="text-sm font-bold text-blue-700 hover:text-blue-600 hover:bg-gray-100 cursor-pointer p-2 border rounded-md mb-2 mt-2">
                    {{ $article->title }}
                </div>
            </a>
        @endforeach

    </div>
    @endif

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