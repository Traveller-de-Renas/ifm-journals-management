<div class="w-full">
    <div class="bg-gray-800 text-white py-12 bg-blend-overlay" style="background-image: url({{ asset('images/auth-image.jpg') }}); background-position: top;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
            <div class="w-full flex text-lg">
                <p class="underline mr-1 cursor-pointer hover:text-gray-500">
                    <a href="{{ route('journal.detail', $record?->journal->uuid) }}">
                    {{ $record?->journal->title }}
                    </a>
                </p>
                @if ($record->issue?->volume?->description)
                    <p class="mr-1"> > </p> 
                    <p class="underline mr-1 cursor-pointer hover:text-gray-500"> {{ $record->issue?->volume?->description }} </p>
                @endif

                @if ($record->issue?->description)
                    <p class="mr-1"> > </p>
                    <p class="underline mr-1 cursor-pointer hover:text-gray-500"> {{ $record->issue?->description }} </p>
                @endif

            </div>
            
            <p class="text-white text-3xl font-bold mt-4 mb-4">
                {{ __($record->title) }}
            </p>

            <a href="{{ route('journal.detail', $record?->journal->uuid) }}">
                <p class="text-xl text-gray-300">{{ $record?->journal->title }}</p>
            </a>

            <p> ISSN : {{ $record?->journal->issn }} </p>
        
        <div class="mb-2">
            @if ($record->article_status->code == '006')
                <p class="text-lg font-bold w-full">Aticle Publication Date : {{ $record->publication_date }} </p>
            @else
                <p class="text-lg font-bold w-full">Aticle Submission Date : {{ date("Y-m-d") }} </p>
            @endif

            <div class="text-sm w-full hover:text-blue-600 hover:cursor-pointer mb-2">
                <a href="{{ route('admin.user_preview', $record->author?->uuid) }}" >
                {{ $record->author?->salutation?->title }} {{ $record->author?->first_name }} {{ $record->author?->middle_name }} {{ $record->author?->last_name }} ({{ $record->author?->affiliation }})
                </a>
            </div>
            <br>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 mb-8">
    @php
        $file = $record->files()->where('publish', 1)->first();
    @endphp
    <div class="flex items-center">
        <a href="{{ route('journal.article_download', $file?->id) }}" >
            <div class="flex items-center text-blue-700 hover:text-blue-600 cursor-pointer">
                <img src="{{ asset('storage/favicon/pdf.png') }}" class="h-5"> <p class="ml-2 text-lg font-bold">Download Article @if(!empty($file)) {{ Storage::size('storage/articles/'.$file?->file) }} @endif</p>
            </div>
        </a>
        <p class="ml-2 text-lg text-gray-600 font-bold">{{ $file?->downloads ?? 0 }} Downloads </p>
    </div>
</div>

<hr>

    @if ($record->article_status->code == '007')
        <div class="p-4 mb-4 shadow bg-red-600 w-full text-center text-white">
            {{ 'This Manuscript is Declined' }}
        </div>
    @elseif($record->article_status->code == '009')
        <div class="p-4 mb-4 shadow bg-gray-600 w-full text-center text-white">
            {{ 'This Manuscript is Unpublished' }}
        </div>
    @elseif($record->article_status->code == '011')
        <div class="p-4 mb-4 shadow bg-yellow-600 w-full text-center text-white">
            {{ 'This Manuscript is waiting for Publication Processes' }}
        </div>
    @endif

    @if(session('success'))
        <div class="p-4 mb-4 shadow bg-green-300 w-full text-center">
            {{ session('success') }}
        </div>
    @endif

    @if(session('danger'))
        <div class="p-4 mb-4 shadow bg-red-600 w-full text-center">
            {{ session('danger') }}
        </div>
    @endif

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    @php
        $assigned_editor = $record->article_users()->wherePivot('role', 'editor')->first();
    @endphp
    
    <div class="gap-2 w-full mt-2 text-right">
        @if ($record?->journal->chief_editor?->id == auth()->user()->id && $record->article_status->code != '007')
            
            @if($record->article_status->code == '006' && $record->author?->id != auth()->user()->id)
                <x-button-plain class="bg-gray-700 hover:bg-gray-500" wire:click="changeStatus('009')">
                    Unpublish
                </x-button-plain>
            @endif

            @if(($record->article_status->code == '011' || $record->article_status->code == '009') && $record->author?->id != auth()->user()->id)
                <x-button class="" wire:click="changeStatus('006')" >
                    Publish Article
                </x-button>
            @endif
        
            @if(($record->article_status->code == '011' || $record->article_status->code == '009') && $record->author?->id != auth()->user()->id)
                <x-button-plain class="bg-red-700 hover:bg-red-600" wire:click="changeStatus('007')">
                    Decline Article
                </x-button-plain>
            @endif
        
            @if($record->article_status->code == '005' && $record->author?->id != auth()->user()->id)
                <x-button-plain class="bg-green-700 hover:bg-green-600" wire:click="changeStatus('011')">
                    Send to Publication Processes
                </x-button-plain>
            @endif

        @endif
    </div>

    <div class="border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
            <li class="me-2">
                <button class="font-bold inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300" wire:click="changeTab('taba')">Overview</button>
            </li>

            @if (auth()->user()->id == $assigned_editor?->id && $record->article_status->code == '014')
                <li class="me-2">
                    <button class="font-bold inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300" wire:click="changeTab('tabb')">Recommendations</button>
                </li>
            @endif

            @if ($record?->journal->chief_editor?->id == auth()->user()->id && $record->article_status->code != '007')

                @if (($record->article_status->code == '002' || $record->article_status->code == '003' || $record->article_status->code == '005') && $record->author?->id != auth()->user()->id)
                <li class="me-2">
                    <button class="font-bold inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300" wire:click="changeTab('tabc')">Send Back to Author</button>
                </li>
                @endif

                @if (($record->article_status->code == '002' || $record->article_status->code == '003') && $record->author?->id != auth()->user()->id)
                <li class="me-2">
                    <button class="font-bold inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300" wire:click="changeTab('tabd')">Assign Editor</button>
                </li>
                @endif

                @if ($record->article_status->code == '003' && $record->author?->id != auth()->user()->id)
                <li class="me-2">
                    <button class="font-bold inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300" wire:click="changeTab('tabe')">Recommendations From Editor</button>
                </li>
                @endif 

                @if(($record->article_status->code == '003' || $record->article_status->code == '004' || $record->article_status->code == '005') && $record->author?->id != auth()->user()->id) 
                <li>
                    <button class="font-bold inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300" wire:click="changeTab('tabf')">Assign Reviewer</button>
                </li>
                @endif

            @endif

            @if($record->article_status->code == '013' && $record->author?->id == auth()->user()->id)
                <li>
                    <button class="font-bold inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300" wire:click="changeTab('tabg')">Editor Recommendations</button>
                </li>
            @endif
        </ul>
    </div>
    <div id="">
        <div class="{{ ($tab == 'taba') ? 'block' : 'hidden' }}" >
            <div class="w-full bg-white p-4 ">
                <div class="w-full">
                    <p class="text-lg font-bold mb-2">Abstract</p>
                    <div class="w-full text-justify mb-4">
                        {!! $record->abstract !!}
                    </div>
                </div>

                <div class="w-full grid grid-cols-12 gap-2">
                    <div class="col-span-12">

                        <div class="w-full mb-12 grid grid-cols-12 gap-2">
                            <div class="col-span-12">
                
                                @if($record->keywords != '')
                                <div class="w-full mb-4">
                                    <p class="text-lg font-bold mb-4">Keywords</p>
                                    <div class="flex gap-2">
                                        @php
                                            $keywords = explode(',', $record->keywords);
                                        @endphp
                                        @foreach ($keywords as $key => $keyword)
                                            <span class="shadow px-4 py-2 hover:bg-gray-100 cursor-pointer border rounded-xl"> {{ $keyword }} </span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>

                        @if($record->article_users()->wherePivot('role', 'author')->count() > 0)
                        <div class="w-full mb-4">
                            <p class="text-lg font-bold">Co Authors</p>
                            <div class="text-sm text-blue-700 hover:text-blue-600 cursor-pointer mb-2 mt-2">
                                @foreach ($record->article_users()->wherePivot('role', 'author')->get() as $key => $user)
                                <div class="flex items-center">
                                    <a href="{{ route('admin.user_preview', $user->author?->uuid) }}" >
                                    {{ $user->salutation?->title }} {{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}
                                    {{ $user->affiliation != '' ? '('. $user->affiliation.')' : '' }}
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                    </div>
                </div> 
            </div>

            <div class="w-full bg-white p-4 mt-4">
                <div class="w-full mb-4">
                    <p class="text-lg font-bold">Attached Files</p>
                    <div class="text-sm text-blue-700 hover:text-blue-600 cursor-pointer mb-2 mt-2"></div>
                    @foreach ($record->files as $key => $file)
                    <div class="flex items-center border-b pb-2 w-full">
                        <div class="w-full">
                            {{ $file->file_category?->name }}
                            <p class="text-sm text-gray-400">Uploaded on {{ $file->created_at }}</p>
                        </div>
                        <div class="w-2/12 text-right">
                            <a href="{{ asset('storage/articles/'.$file->file_path) }}" target="_blank" class="text-blue-700 hover:text-blue-600">
                                <x-button>Download Article
                                    <svg class="h-5 w-5 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="12" y1="5" x2="12" y2="19" />  <line x1="16" y1="15" x2="12" y2="19" />  <line x1="8" y1="15" x2="12" y2="19" /></svg>
                                </x-button>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="{{ ($tab == 'tabb') ? 'block' : 'hidden' }}">
            <div class="w-full bg-white p-4">
                <div class="text-sm">Editor Decision</div>

                <select class="rounded w-full border-gray-300" wire:model="decision">
                    <option value="proceed">Send to Reviewer</option>
                    <option value="rejected">Rejected</option>
                </select>
                
                <div class="mt-4" wire:ignore>
                    <x-label for="description" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-textarea type="text" id="description" class="w-full" wire:model="description" placeholder="Enter Description" rows="7" />
                    <x-input-error for="description" />
                </div>

                <div class="mt-4">
                    <x-button type="submit" wire:click="toChiefEditor()" wire:loading.attr="disabled" >
                        {{ __('Send Back to Chief Editor') }}
                    </x-button>
                </div>
            </div>
        </div>

        <div class="{{ ($tab == 'tabc') ? 'block' : 'hidden' }}">
            <div class="w-full bg-white p-4 ">
                <div class="mt-4" wire:ignore>
                    <x-label for="description" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-textarea type="text" id="description" class="w-full" wire:model="description" placeholder="Enter Description" rows="7" />
                    <x-input-error for="description" />
                </div>

                <div class="mt-4">
                <x-button type="submit" wire:click="send_back()" wire:loading.attr="disabled" >
                    {{ __('Send Back') }}
                </x-button>
                </div>
            </div>
        </div>

        <div class="{{ ($tab == 'tabd') ? 'block' : 'hidden' }}">
            <div class="w-full bg-white p-4">
                <div class="mt-4">

                    @if(!empty($editors))
                        <div class="text-sm text-gray-600">Select Editor</div>
                        <div>
                            <select class="rounded w-full border-gray-300" wire:model="user_id">
                                <option>Select Editor</option>
                                @foreach($editors as $key => $user)
                                <option value="{{ $user->id }}">{{ $user?->salutation?->title }} {{ $user?->first_name }} {{ $user?->middle_name }} {{ $user?->last_name }}</option>
                                @endforeach
                            </select>
                            <x-input-error for="user_id" />
                        </div>

                        <div class="mt-4">
                            <x-button type="submit" wire:click="attachUser()" wire:loading.attr="disabled" >
                                {{ __('Assign Editor') }}
                            </x-button>
                        </div>
                    @else
                        <div class="text-sm text-red-600">No Editors Available</div>
                    @endif
                    <br>
                    <br>
    
                    <p class="font-bold text-sm">Currently Assigned Editor</p>
                    @if($assigned_editor)
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.user_preview', $assigned_editor?->uuid) }}" class="w-full" >
                                <div class="w-full text-sm hover:text-blue-600 hover:cursor-pointer border p-2 rounded">
                                    {{ $assigned_editor?->salutation?->title }} {{ $assigned_editor?->first_name }} {{ $assigned_editor?->middle_name }} {{ $assigned_editor?->last_name }}
                                    {{ $assigned_editor?->affiliation != '' ? '('. $assigned_editor?->affiliation.')' : '' }}
                                </div>
                            </a>
                            <x-button-plain class="bg-red-700 hover:bg-red-600 text-xs" wire:click="removeUser({{ $user->id }}, 'article', 'reviewer')">
                                Remove
                            </x-button-plain>
                        </div>
                    @else
                        <div class="text-sm text-red-600">No Editor Assigned</div>
                    @endif
    
                </div>
            </div>
        </div>

        <div class="{{ ($tab == 'tabe') ? 'block' : 'hidden' }}">
            <div class="w-full bg-white p-4">
                <div class="">
                    @if ($record?->movement_logs != null)
    
                    @foreach ($record->movement_logs as $movement_log)
                    <div class="p-2 text-sm text-justify bg-gray-100 mb-2">
                        {!! $movement_log?->description !!}
                        
                        <div class="text-xs text-gray-400 mt-2">{!! $movement_log?->user->first_name !!}</div>
                        <div class="text-xs text-gray-400">{!! $movement_log?->created_at !!}</div>
                    </div>
                    @endforeach
                    
                    @endif
                </div>
            </div>
        </div>

        <div class="{{ ($tab == 'tabf') ? 'block' : 'hidden' }}">
            <div class="w-full bg-white p-4">
                
                <div class="flex gap-2" >
                    <div class="w-full">
                        <x-input type="text" class="rounded-md w-full" wire:keyup="searchUser($event.target.value)" placeholder="Search User" />
                    </div>
                    <div class="w-2/12">
                        <x-button class="rounded-md w-full" wire:click="createNewUser();">Create</x-button>
                    </div>
                </div>

                <div class="results mt-2 rounded-md">
                    @if(!empty($user_names) && $user_search != '')

                        <div class="w-full bg-white shadow-lg rounded-lg">
                            @foreach ($user_names as $key => $user_data)
                                <label class="w-full p-2 hover:bg-gray-300 cursor-pointer flex gap-4 rounded-lg" for="userinfo{{ $user_data->id }}" wire:click.prevent="assignUser({{ $user_data->id }}, 'article', 'reviewer')">
                                    <div>
                                        <x-input type="checkbox" wire:model="userinfo_ids" id="userinfo{{ $user_data->id }}" value="{{ $user_data->id }}" />
                                    </div>
                                    <div>
                                        {{ $user_data->salutation?->title }} {{ $user_data->first_name }} {{ $user_data->middle_name }} {{ $user_data->last_name }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    
                    @endif
                </div>

                <div class="w-full mb-4">
                    <div class="w-full mt-8">
                        @if ($record->article_users()->wherePivot('role', 'reviewer')->get()->count() > 0 && $record?->journal->chief_editor?->id == auth()->user()->id)
                            <p class="font-bold mb-2">Assigned Reviewers</p>
                            <hr>
                            @foreach ($record->article_users()->wherePivot('role', 'reviewer')->get() as $key => $user)
                                <div class="w-full mt-2 mb-8">
                                    <div class="w-full font-bold text-sm hover:text-blue-600 hover:cursor-pointer">
                                        <a href="{{ route('admin.user_preview', $user->uuid) }}" >
                                        {{ $user->salutation?->title }} {{ $user->first_name }}  {{ $user->middle_name }}  {{ $user->last_name }} ({{ $user->affiliation }})
                                        </a>
                                    </div>
                                    <div class="text-xs w-full mt-2">Assigned on : {{ $user->pivot->created_at }}</div>

                                    <div class="w-full text-blue-700 hover:text-blue-600 cursor-pointer">
                                        <a href="{{ route('journals.article_evaluation', [$record->uuid, $user->uuid]) }}" >Evaluation Form</a>
                                    </div>

                                    <div class="mt-2">
                                        <x-button-plain class="bg-green-700 hover:bg-green-600 text-xs" wire:click="reviewFeedback({{ $user->id }})">
                                            Review Feedback
                                        </x-button-plain>
                                        <x-button-plain class="bg-red-700 hover:bg-red-600 text-xs" wire:click="removeUser({{ $user->id }}, 'article', 'reviewer')">
                                            Remove
                                        </x-button-plain>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="w-full text-sm text-center bg-blue-300 p-2 shadow rounded">No Reviewer Assigned</div>
                        @endif
                    </div>
                </div>


            </div>
        </div>

        <div class="{{ ($tab == 'tabg') ? 'block' : 'hidden' }}">
            <div class="w-full bg-white p-4">
                @if ($record?->movement_logs != null)
    
                    @foreach ($record->movement_logs as $movement_log)
                    <div class="p-2 text-sm text-justify bg-gray-100 mb-2">
                        {!! $movement_log?->description !!}
    
                        <div class="text-xs text-gray-400">{!! $movement_log?->user->first_name !!}</div>
                        <div class="text-xs text-gray-400">{!! $movement_log?->created_at !!}</div>
                    </div>
                    @endforeach
                    
                @endif
            </div>
        </div>
    </div>


    <x-dialog-modal wire:model="create_newuser">
        <x-slot name="title">
            {{ __('Create New User') }}
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
            
            <x-button type="submit" wire:click="storeNewUser()" wire:loading.attr="disabled" >
                {{ __('Submit') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('create_newuser')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>


    <x-dialog-modal wire:model="declineModal">
        <x-slot name="title">
            {{ __('Decline This Article') }}
        </x-slot>
        <x-slot name="content">
            
            <div class="mt-4" wire:ignore>
                <x-label for="description" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-textarea type="text" id="description" class="w-full" wire:model="description" placeholder="Enter Description" rows="7" />
                <x-input-error for="description" />
            </div>

        </x-slot>
        <x-slot name="footer">
            
            <x-button type="submit" wire:click="decline()" wire:loading.attr="disabled" >
                {{ __('Submit') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('declineModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>


    <x-dialog-modal wire:model="viewFeedback">
        <x-slot name="title">
            {{ __('Feedbacks') }}
        </x-slot>
        <x-slot name="content">
            
            <div class="mt-4">
                @if ($record?->movement_logs != null)

                @foreach ($record->movement_logs as $movement_log)
                <div class="p-2 text-sm text-justify bg-gray-100 mb-2">
                    {!! $movement_log?->description !!}

                    <div class="text-xs text-gray-400">{!! $movement_log?->created_at !!}</div>
                </div>
                @endforeach
                
                @endif
            </div>

        </x-slot>
        <x-slot name="footer">
        
            <x-secondary-button class="ml-3" wire:click="$toggle('viewFeedback')" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>


    <x-dialog-modal wire:model="reviewerFeedback" :maxWidth="'4xl'" >
        <x-slot name="title">
            {{ __('Reviewer Feedback') }}
        </x-slot>
        <x-slot name="content">
            
            <div class="mt-4 text-xs">

                @if(!empty($sections))
                    @foreach ($sections as $key => $section)
                
                        <table class="min-w-full text-left font-light">
                            <thead class="border-b font-medium grey:border-neutral-500">
                                <tr class="bg-neutral-200 font-bold">
                                    <th scope="col" class="whitespace-nowrap px-4 py-2 font-bold">
                                        {{ $section->title }}
                                    </th>
                                    @foreach ($section->reviewSectionOption as $key => $option)
                                        <th scope="col" class="whitespace-nowrap px-4 py-2 font-bold text-center">
                                            {{ $option->title }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($section->reviewSectionQuery as $key => $data)
                                <tr class="border-b transition duration-300 ease-in-out @if($section->category == 'options') hover:bg-neutral-100 @endif grey:border-neutral-500 grey:hover:bg-neutral-600">
                                    <td class="whitespace-nowrap px-4 py-2 font-medium">
                                        <p class="w-full @if($section->category == 'comments') font-bold @endif">{{ $data->title }}</p>

                                        @if($section->category == 'comments')
                                        <x-textarea type="text" id="description" class="w-full mt-2" wire:model="reviewComment.{{ $data->id }}" placeholder="Enter Description" rows="5" readonly />
                                        @endif
                                    </td>
                                    @if($section->category == 'options')
                                        @foreach ($section->reviewSectionOption as $key => $option)
                                            <td class="whitespace-nowrap px-4 py-2 font-medium text-center">
                                                <input type="radio" name="option{{ $data->id }}" wire:model.live="reviewOption.{{ $data->id }}" value="{{ $option->id }}" wire:click="upOptions({{ $data->id }}, {{ $option->id }})" />
                                            </td>
                                        @endforeach
                                    @endif
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    @endforeach
                @endif

            </div>

        </x-slot>
        <x-slot name="footer">

            <x-secondary-button class="ml-3" wire:click="$toggle('reviewerFeedback')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>
</div>

<script>
    window.addEventListener('contentChanged', (e) => {
        tinymce.remove('#description');
        tinymce.init({
            selector: '#description',
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
                    @this.set('description', editor.getContent());
                });
            },
        });
    });
</script>