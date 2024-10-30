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

        <div class="flex items-center">
            <div class="flex items-center text-blue-700 hover:text-blue-600 cursor-pointer">
                <img src="{{ asset('storage/favicon/pdf.png') }}" class="h-5"> 
                <p class="ml-2 text-lg font-bold">
                    <a href="{{ asset('storage/articles/') }}" > Download Article </a>
                </p>
            </div>
            <p class="ml-2 text-lg font-bold"> | Published On {{ date("Y-m-d") }} </p>
        </div>
    </div>

    @if ($record?->journal->chief_editor?->id == auth()->user()->id)
        <div class="flex gap-2 w-full mb-4">
            <x-button wire:click="sendBack()">
                Send Back to Author
            </x-button>

            <x-button wire:click="assignReviewer()">
                Assign Reviewer
            </x-button>

            <x-button-plain class="bg-red-700 hover:bg-red-600" wire:click="declineArticle()">
                Decline Article
            </x-button-plain>

            @if($record->status == 'Unpublished')
            <x-button wire:click="changeStatus('Published')">
                Publish
            </x-button>
            @else
            <x-button-plain class="bg-red-700 hover:bg-red-600" wire:click="changeStatus('Unpublished')">
                Unpublish
            </x-button-plain>
            @endif

        </div>
    @endif

    <div class="w-full">
        <p class="text-lg font-bold mb-2">Abstract</p>
        <div class="w-full text-justify mb-4">
            {!! $record->abstract !!}
        </div>
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
                    @foreach ($record->article_users()->wherePivot('role', '<>', 'reviewer')->get() as $key => $user)
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
            <div class="flex gap-2 justify-between w-full">
                <a class="block w-full" href="{{ route('journals.submission', $record->journal->uuid) }}">
                    <x-button class="mb-4 w-full">Submit a Paper </x-button>
                </a>
        
                <a class="block w-full" href="{{ route('journals.articles', $record->journal->uuid) }}">
                    <x-button class="mb-4 w-full">Publications </x-button>
                </a>
            </div>

            @if ($record?->journal->chief_editor?->id == auth()->user()->id)
            <p class="text-lg font-bold mb-4">Volume & Issue</p>
            <x-select wire:model.live="volume" :options="$volumes" :selected="$record->issue?->volume_id" :placeholder="'Select Volume'" class="w-full mb-4" />
            <x-select wire:model.live="issue" :options="$issues" :selected="$record->issue_id" :placeholder="'Select Issue'" class="w-full mb-4" />

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

                    <div class="text-right">
                        <x-button-plain class="bg-red-700 hover:bg-red-600 text-xs" wire:click="removeReviewer({{ $user->id }})">
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