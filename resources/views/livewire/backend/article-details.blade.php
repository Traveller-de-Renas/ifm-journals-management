<x-module>
    <x-slot name="title" >
        
        <div class="w-full flex text-xs">
            <p class="underline mr-1 cursor-pointer hover:text-gray-500">
                <a href="{{ route('journals.details', $record?->journal->uuid) }}">
                {{ $record?->journal->title }}
                </a>
            </p>
            <p class="mr-1"> > </p> 
            <p class="underline mr-1 cursor-pointer hover:text-gray-500"> {{ $record->issue?->volume?->description }} </p>
            <p class="mr-1"> > </p>
            <p class="underline mr-1 cursor-pointer hover:text-gray-500"> {{ $record->issue?->description }} </p>
        </div>

        <p class="text-blue-700">
            {{ __($record->title) }}
        </p>

    </x-slot>

    <div class="mb-8">
        <div class="text-sm w-full hover:text-blue-600 hover:cursor-pointer">
            <a href="{{ route('admin.user_preview', $record->author?->uuid) }}" >
            {{ $record->author?->salutation?->title }} {{ $record->author?->first_name }} {{ $record->author?->middle_name }} {{ $record->author?->last_name }} ({{ $record->author?->affiliation }})
            </a>
        </div>

        @php 
            $file = $record->files()->where('publish', 1)->first();
        @endphp
        <div class="flex items-center">
            <a href="{{ route('journal.article_download', $file?->id) }}" >
                <div class="flex items-center text-blue-700 hover:text-blue-600 cursor-pointer">
                    <img src="{{ asset('storage/favicon/pdf.png') }}" class="h-5"> <p class="ml-2 text-lg font-bold">Download Article</p>
                </div>
            </a>
            <p class="ml-2 text-lg text-gray-600 font-bold">| {{ $file?->downloads }} Downloads | Published On {{ date("Y-m-d") }} </p>
        </div>
    </div>


    @if ($record?->journal->chief_editor?->id == auth()->user()->id)
        <div class="flex justify-between gap-2 w-full mb-4">
            <x-button wire:click="sendBack()" class="flex-1">
                Send Back to Author
            </x-button>

            <x-button wire:click="assignEditor()" class="flex-1">
                Assign Editor
            </x-button>

            <x-button wire:click="eFeedback()" class="flex-1">
                Editor Recommendation
            </x-button>

            <x-button wire:click="assignReviewer()" class="flex-1">
                Assign Reviewer
            </x-button>

            @if($record->article_status->code == '006')
            <x-button-plain class="bg-red-700 hover:bg-red-600 flex-1" wire:click="changeStatus('009')">
                Unpublish
            </x-button-plain>
            @else
            <x-button wire:click="changeStatus('006')" class="flex-1">
                Publish Article
            </x-button>
            @endif

            <x-button-plain class="bg-red-700 hover:bg-red-600 flex-1" wire:click="declineArticle()">
                Decline Article
            </x-button-plain>
        </div>
    @endif


    <div class="w-full">
        <p class="text-lg font-bold mb-2">Abstract</p>
        <div class="w-full text-justify mb-4">
            {!! $record->abstract !!}
        </div>
    </div>
    

    <div class="grid grid-cols-12 justify-between gap-2 mb-4">
        @if(auth()->user())
            @if (!$record->journal->journal_users->contains(auth()->user()->id))
                <x-button wire:click="signup()" class="col-span-2">Register </x-button>
            @endif
        @endif

        <a href="{{ route('journals.submission', $record->journal->uuid) }}" class="col-span-2">
            <x-button class="w-full">Submit a Paper </x-button>
        </a>

        @foreach ($statuses as $statex)
            <a href="{{ route('journals.articles', [$record->journal->uuid, $statex->code]) }}" class="col-span-2">
                <x-button class="w-full">{{ $statex->name }} </x-button>
            </a>
        @endforeach
    </div>

    <div class="w-full grid grid-cols-12 gap-2">
        <div class="col-span-8">
            <div class="w-full mb-4">
                <p class="text-lg font-bold">Keywords</p>
                <div class="text-sm font-bold text-blue-700 hover:text-blue-600 cursor-pointer mb-2 mt-2">
                    {{ $record->keywords }}
                </div>
            </div>
        
        
            <div class="w-full mb-4">
                <p class="text-lg font-bold">Areas</p>
                <div class="text-sm font-bold text-blue-700 hover:text-blue-600 cursor-pointer mb-2 mt-2">
                    {{ $record->areas }}
                </div>
            </div>

        
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
        </div>
        <div class="col-span-4">

            @if ($record?->journal->chief_editor?->id == auth()->user()->id)
            <p class="text-lg font-bold mb-4">Volume & Issue</p>
            <div class="flex gap-2 justify-between w-full">
            <x-select wire:model.live="volume" :options="$volumes" :selected="$record->issue?->volume_id" :placeholder="'Select Volume'" class="w-full mb-4" />
            <x-select wire:model.live="issue" :options="$issues" :selected="$record->issue_id" :placeholder="'Select Issue'" class="w-full mb-4" />
            </div>

            <div class="text-right">
                <x-button wire:click="updateVolume()" wire:loading.attr="disabled" >
                    {{ __('Update Volume & Issue') }}
                </x-button>
            </div>
            @endif

            @if ($record->article_users()->wherePivot('role', 'reviewer')->get()->count() > 0)
            
            <p class="text-lg font-bold mb-2">Reviewers</p>
            @foreach ($record->article_users()->wherePivot('role', 'reviewer')->get() as $key => $user)
                <div class="w-full mb-4">
                    <div class="w-full font-bold text-sm hover:text-blue-600 hover:cursor-pointer">
                        <a href="{{ route('admin.user_preview', $user->uuid) }}" >
                        {{ $user->salutation?->title }} {{ $user->first_name }} ({{ $user->affiliation }})
                        </a>
                    </div>

                    <div class="text-sm w-full">Affiliation : {{ $user->affiliation }}</div>
                    <div class="text-sm w-full">Assigned on : {{ $user->pivot->created_at }}</div>

                    <div class="w-full text-blue-700 hover:text-blue-600 cursor-pointer">
                        <a href="{{ route('journals.article_evaluation', [$record->uuid, $user->uuid]) }}" >Evaluation Form</a>
                    </div>

                    <div class="flex gap-2 mt-2">
                        <x-button-plain class="bg-green-700 hover:bg-green-600 text-xs w-2/3" wire:click="reviewFeedback({{ $user->id }})">
                            Review Feedback
                        </x-button-plain>
                        <x-button-plain class="bg-red-700 hover:bg-red-600 text-xs w-1/3" wire:click="removeReviewer({{ $user->id }})">
                            Remove
                        </x-button-plain>
                    </div>
                </div>
            @endforeach

            @endif
        </div>
    </div>
    
    

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

    <x-dialog-modal wire:model="reviewerModal">
        <x-slot name="title">
            {{ __('Assign Reviewer') }}
        </x-slot>
        <x-slot name="content">
            <div class="mt-4">
                Select Reviewer
                <select class="rounded w-full border-gray-300" wire:model="reviewer_id">
                    @foreach($reviewers as $key => $reviewer)
                    <option value="{{ $reviewer->id }}">{{ $reviewer?->salutation?->title }} {{ $reviewer?->first_name }} {{ $reviewer?->middle_name }} {{ $reviewer?->last_name }}</option>
                    @endforeach
                </select>
                <br>
            </div>
        </x-slot>
        <x-slot name="footer">
            
            <x-button type="submit" wire:click="assignRev()" wire:loading.attr="disabled" >
                {{ __('Assign') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('reviewerModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="assignModal">
        <x-slot name="title">
            {{ __('Assign Editor') }}
        </x-slot>
        <x-slot name="content">
            <div class="mt-4">

                @if(!empty($users))
                Select Editor

                <select class="rounded w-full border-gray-300" wire:model="user_id">
                    @foreach($users as $key => $user)
                    <option value="{{ $user->id }}">{{ $user?->salutation?->title }} {{ $user?->first_name }} {{ $user?->middle_name }} {{ $user?->last_name }}</option>
                    @endforeach
                </select>
                @else
                <div class="text-sm text-red-600">No Editors Available</div>
                @endif
                <br>
                <br>

                <p class="font-bold">Currently Assigned Editor</p>
                @php
                $assigned_editor = $record->article_users()->wherePivot('role', 'editor')->first();
                @endphp

                <div class="flex items-center">
                    <a href="{{ route('admin.user_preview', $assigned_editor?->uuid) }}" >
                    {{ $assigned_editor?->salutation?->title }} {{ $assigned_editor?->first_name }} {{ $assigned_editor?->middle_name }} {{ $assigned_editor?->last_name }}
                    {{ $assigned_editor?->affiliation != '' ? '('. $assigned_editor?->affiliation.')' : '' }}
                    </a>
                </div>

            </div>
        </x-slot>
        <x-slot name="footer">
            
            <x-button type="submit" wire:click="attachUser()" wire:loading.attr="disabled" >
                {{ __('Assign') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('assignModal')" wire:loading.attr="disabled">
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

    <x-dialog-modal wire:model="sendModal">
        <x-slot name="title">
            {{ __('Return Article to Author') }}
        </x-slot>
        <x-slot name="content">
            
            <div class="mt-4" wire:ignore>
                <x-label for="description" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-textarea type="text" id="description" class="w-full" wire:model="description" placeholder="Enter Description" rows="7" />
                <x-input-error for="description" />
            </div>

        </x-slot>
        <x-slot name="footer">
            
            <x-button type="submit" wire:click="send_back()" wire:loading.attr="disabled" >
                {{ __('Submit') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('sendModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>


    <x-dialog-modal wire:model="editorFeedback">
        <x-slot name="title">
            {{ __('Return Article to Chief Editor') }}
        </x-slot>
        <x-slot name="content">

            Editor Decision

            <select class="rounded w-full border-gray-300" wire:model="decision">
                <option value="proceed">Send to Reviewer</option>
                <option value="rejected">Rejected</option>
            </select>
            
            <div class="mt-4" wire:ignore>
                <x-label for="description" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-textarea type="text" id="description" class="w-full" wire:model="description" placeholder="Enter Description" rows="7" />
                <x-input-error for="description" />
            </div>

        </x-slot>
        <x-slot name="footer">
            
            <x-button type="submit" wire:click="toChiefEditor()" wire:loading.attr="disabled" >
                {{ __('Submit') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('editorFeedback')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
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

</x-module>

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