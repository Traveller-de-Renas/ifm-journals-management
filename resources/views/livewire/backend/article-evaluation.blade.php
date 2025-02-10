<div class="w-full">
    <div class="bg-gray-800 text-white py-12 bg-blend-overlay" style="background-image: url({{ asset('images/auth-image.jpg') }}); background-position: top;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="w-full flex text-lg">
                <p class="underline mr-1 cursor-pointer hover:text-gray-500">
                    <a href="{{ route('journal.detail', $record?->journal->uuid) }}">
                    {{ $record?->journal->title }}
                    </a>
                </p>
                @if($record->issue?->volume?->description)
                <p class="mr-1"> > </p> 
                <p class="underline mr-1 cursor-pointer hover:text-gray-500"> {{ $record->issue?->volume?->description }} </p>
                @endif

                @if($record->issue?->volume?->description)
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

            <div class="flex gap-2">
                <div class="w-1/12">
                    ISSN
                </div>
                <div class="w-full">
                    {{ $record?->journal->issn }}
                </div>
            </div>

            <div class="flex gap-2">
                
            </div>
            <div class="flex gap-2">
                <div class="w-1/12">
                    REVIEWER
                </div>
                <div class="w-full">{{ $reviewer->salutation?->title }} {{ $reviewer->first_name }} {{ $reviewer->middle_name }} {{ $reviewer->last_name }}</div>
            </div>

            <div class="mt-6 mb-6">
                <p class="text-lg text-gray-400 font-bold">{{ date("Y-m-d") }} </p>
            </div>

        </div>
    </div>

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

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 mb-8">
        @php
            $file = $record->files()->first();
        @endphp
        <div class="flex gap-2 items-center">
            
            <div class="flex-1 flex items-center text-blue-700 hover:text-blue-600 cursor-pointer">
                <img src="{{ asset('storage/favicon/pdf.png') }}" class="h-5">
                <p class="ml-2 text-lg font-bold">
                    <a href="{{ asset('storage/articles/'.$submission?->file_path) }}" target="_blank" title="{{ $submission?->file_path }}" class="text-blue-700 hover:text-blue-600"> 
                        Download Original Submission 
                    </a>
                </p>
            </div>

            @php
                $juser = $journal_user->article_journal_users()->where('article_id', $record->id)->first();
            @endphp

            <div class="flex-1 text-right w-full">
                @if($juser->pivot->review_status == 'pending')
                <x-button class="bg-green-700 hover:bg-green-600 text-xs" wire:click="accept()">
                    Accept
                </x-button>
                <x-button class="bg-red-700 hover:bg-red-600 text-xs" wire:click="declineArticle()">
                    Decline
                </x-button>
                @endif
            </div>

        </div>
    </div>

    <hr>
    @if($juser->pivot->review_status == 'accepted')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 mb-8">

        <div class="p-3 bg-[#175883] text-white ">
            {{ "Article Evaluation Form" }}
        </div>

        @foreach ($sections as $key => $section)
            
            <table class="min-w-full text-left text-sm font-light">
                <thead class="border-b font-medium grey:border-neutral-500">
                    <tr class="bg-neutral-200 font-bold">
                        <th scope="col" class="whitespace-nowrap px-6 py-4 font-bold">
                            {{ $section->title }}
                        </th>
                        @foreach ($section->reviewSectionOption as $key => $option)
                            <th scope="col" class="whitespace-nowrap px-6 py-4 font-bold text-center">
                                {{ $option->title }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($section->reviewSectionQuery as $key => $data)
                    <tr class="border-b transition duration-300 ease-in-out @if($section->category == 'options') hover:bg-neutral-100 @endif grey:border-neutral-500 grey:hover:bg-neutral-600">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            <p class="w-full @if($section->category == 'comments') font-bold @endif">{{ $data->title }}</p>

                            @if($section->category == 'comments')
                                <x-textarea type="text" id="reviewComment" class="w-full mt-2" wire:model="reviewComment.{{ $data->id }}" placeholder="Enter Description" rows="5" />
                                <x-input-error for="reviewComment" />
                            @endif
                        </td>
                        @if($section->category == 'options')
                            @foreach ($section->reviewSectionOption as $key => $option)
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-center">
                                    <input type="radio" name="option{{ $data->id }}" wire:model.live="reviewOption.{{ $data->id }}" value="{{ $option->id }}" wire:click="upOptions({{ $data->id }}, {{ $option->id }})" />
                                </td>
                            @endforeach
                        @endif
                    </tr>
                    @endforeach

                </tbody>
            </table>

        @endforeach

        <div class="bg-gray-200 px-6 py-4 font-bold">
            Attachments
        </div>

        <div class="p-6 border-b">
            <x-input-file wire:model="review_attachment" id="review_attachment" multiple />
            <x-input-error for="review_attachment" />

            <div class="mt-4 flex gap-2">
                @foreach($record->review_attachments as $key => $file)
                <div class="flex">
                    <a href="" class="bg-yellow-400 hover:bg-yellow-600 shadow-md rounded-l p-2 cursor-pointer">
                        <div class="flex items-center gap-2">
                        <svg class="h-6 w-6 text-gray-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />  <polyline points="14 2 14 8 20 8" />  <line x1="16" y1="13" x2="8" y2="13" />  <line x1="16" y1="17" x2="8" y2="17" />  <polyline points="10 9 9 9 8 9" /></svg>

                        {{ $file->attachment }}
                        </div>
                    </a>
                    <div class="bg-red-500 hover:bg-red-700 shadow-md rounded-r p-2 cursor-pointer" wire:click="removeAttachment({{ $file->id }})">
                        <svg class="h-6 w-6 text-gray-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="flex gap-4 justify-center mt-6 mb-4">
            <x-button wire:click="store('incomplete')">Save and Submit Later</x-button>
            <x-button class="bg-green-700 hover:bg-green-600" wire:click="store('complete')" >Save & Submit</x-button>
        </div>
    <div>
    @endif

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