<div class="w-full">
    <div class="bg-gray-800 text-white py-12 bg-blend-overlay"
        style="background-image: url({{ asset('images/auth-image.jpg') }}); background-position: top;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="w-full flex text-lg">
                <p class="underline mr-1 cursor-pointer hover:text-gray-500">
                    <a href="{{ route('journal.detail', $record?->journal->uuid) }}">
                        {{ $record?->journal->title }}
                    </a>
                </p>
                @if ($record->issue?->volume?->description)
                    <p class="mr-1"> > </p>
                    <p class="underline mr-1 cursor-pointer hover:text-gray-500">
                        {{ $record->issue?->volume?->description }} </p>
                @endif

                @if ($record->issue?->volume?->description)
                    <p class="mr-1"> > </p>
                    <p class="underline mr-1 cursor-pointer hover:text-gray-500"> {{ $record->issue?->description }}
                    </p>
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
                <div class="w-full">{{ $reviewer->salutation?->title }} {{ $reviewer->first_name }}
                    {{ $reviewer->middle_name }} {{ $reviewer->last_name }}</div>
            </div>

            <div class="mt-6 mb-6">
                <p class="text-lg text-gray-400 font-bold">{{ date('Y-m-d') }} </p>
            </div>

        </div>
    </div>

    @php
        $file  = $record->files()->first();
        $juser = $journal_user->article_journal_users()->where('article_id', $record->id)->first();
    @endphp

    @if ($juser->pivot->review_status == 'disabled')
        <div class="p-4 text-sm mb-4 mt-2 shadow bg-blue-300 w-full text-center">
            This Review link was mistakenly sent to you and its not available for now, sorry for the inconvenience
        </div>
    @else

    @if (session('response'))
        @php
            $bgClass = match (session('response.status')) {
                'success' => 'bg-green-300',
                'error' => 'bg-red-300',
                'warning' => 'bg-yellow-300',
                'info' => 'bg-blue-300',
                default => 'bg-gray-200',
            };
        @endphp
        <div class="p-4 text-sm mb-4 mt-2 shadow {{ $bgClass }} w-full text-center">
            {{ session('response.message') }}
        </div>
    @endif

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 mb-8">
        {{-- <div class="flex gap-2 items-center"> --}}
        @if ($juser->pivot->review_status == 'pending')

            <div class="w-full mb-8">
                <p class="text-lg font-bold mb-2">Abstract</p>
                <div class="w-full text-justify mb-4">
                    {!! $record?->abstract !!}
                </div>
            </div>
            @if ($record?->keywords != '')
                <div class="w-full mb-4">
                    <p class="text-lg font-bold mb-4">Keywords</p>
                    <div class="flex gap-2">
                        @php
                            $keywords = explode(',', $record?->keywords);
                        @endphp
                        @foreach ($keywords as $key => $keyword)
                            <span class="shadow px-4 py-2 hover:bg-gray-100 cursor-pointer border rounded-xl">
                                {{ $keyword }} </span>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        <div class="flex-1 text-left w-full">
            @if ($juser->pivot->review_status == 'pending')
                <p class="text-lg font-bold mb-4">Decision for Reviewing</p>
                <div>
                    Based on your assessment of the abstract, please indicate whether you are willing to proceed with
                    the
                    full review or must decline at this time. Your expertise is greatly valued, and we appreciate your
                    timely response.
                </div>

                <x-button class="bg-green-700 hover:bg-green-600 text-xs mt-4" wire:click="accept()">
                    Accept
                </x-button>
                <x-button class="bg-red-700 hover:bg-red-600 text-xs" wire:click="declineArticle()">
                    Decline
                </x-button>
            @endif
        </div>

        {{-- </div> --}}
    </div>

    <hr>
    

    @if ($juser->pivot->review_status == 'declined')
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 mb-8">
            <div class="flex-1 flex items-center text-justify">
                Dear Reviewer,
                <br>
                Thank you for taking the time to consider reviewing the manuscript titled
                "{{ $record?->title }}" (ID:
                {{ $record->paper_id }}). We appreciate your transparency in declining and value the
                feedback you provided in your
                response.<br>

                While we regret that you were unable to participate this time, we understand that such decisions are
                often due to competing priorities or expertise fit. Your willingness to engage with the process is
                still greatly appreciated.<br>

                We hope to have the opportunity to collaborate on future submissions that align with your
                availability and interests. Thank you again for supporting the peer-review community.
                <br>
                <br>
            </div>
            <span class="font-bold">
                Managing Editor,
                <br>
                {{ $record?->journal->title }}
            </span>
        </div>
    @endif

    @if ($juser->pivot->review_status == 'completed')
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 mb-8">
            <div class="flex-1 flex items-center text-justify">
                Dear Reviewer,
                <br>
                Thank you for submitting your review for the manuscript titled "{{ $record?->title }}"
                (ID:{{ $record?->paper_id }}). Your
                thoughtful feedback and expertise are invaluable in maintaining the quality and rigor of our publication
                process.<br>
                The editorial team will now carefully evaluate your comments alongside other reviews to make a final
                decision
                on the manuscript.<br>
                We sincerely appreciate the time and effort you dedicated to this task.
                <br>
                <br>
            </div>
            <span class="font-bold">
                Managing Editor,
                <br>
                {{ $record?->journal->title }}
            </span>
        </div>
    @endif

    <x-dialog-modal wire:model="declineModal">
        <x-slot name="title">
            {{ __('Reason for Declining to Review') }}
        </x-slot>
        <x-slot name="content">

            <div class="mt-4" wire:ignore>
                {{-- <x-label for="description" value="Description"
                    class="mb-2 block font-medium text-sm text-gray-700" /> --}}
                <x-textarea type="text" id="#" class="w-full" wire:model="description"
                    placeholder="Enter decline reason" rows="7" />
                <x-input-error for="description" />
            </div>
        </x-slot>
        <x-slot name="footer">

            <x-button type="submit" wire:click="decline()" wire:loading.attr="disabled">
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

            setup: function(editor) {
                editor.on('init change', function() {
                    editor.save();
                });
                editor.on('change', function(e) {
                    @this.set('description', editor.getContent());
                });
            },
        });
    });
</script>
