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
        @php
            $file = $record->files()->first();
        @endphp

        @php
            $juser = $journal_user->article_journal_users()->where('article_id', $record->id)->first();
        @endphp
        {{-- <div class="flex gap-2 items-center"> --}}
        @if ($juser->pivot->review_status == 'pending')

            <div class="w-full mb-8">
                <p class="text-lg font-bold mb-2">Abstract</p>
                <div class="w-full text-justify mb-4">
                    {!! $submission?->article->abstract !!}
                </div>
            </div>
            @if ($submission?->article->keywords != '')
                <div class="w-full mb-4">
                    <p class="text-lg font-bold mb-4">Keywords</p>
                    <div class="flex gap-2">
                        @php
                            $keywords = explode(',', $submission?->article->keywords);
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
    @if ($juser->pivot->review_status == 'accepted')
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 mb-8">
            <span class="text-lg font-bold mb-4" style="color: green">Deadline for submission of the reviewers comments
                should be before {{ \Carbon\Carbon::parse($juser->pivot->review_end_date)->isoFormat('MMM Do, YYYY') }}
                ({{ abs(round(\Carbon\Carbon::parse($juser->pivot->review_end_date)->diffInDays(now(), false))) }}
                days left)
            </span>

            <div class="flex-1 flex items-center text-blue-700 hover:text-blue-600 cursor-pointer mb-4 mt-4">
                <br>
                <img src="{{ asset('storage/favicon/pdf.png') }}" class="h-5">
                <p class="ml-2 text-lg font-bold">

                    <a href="{{ asset('storage/articles/' . $submission?->file_path) }}" target="_blank"
                        title="{{ $submission?->file_path }}" class="text-blue-700 hover:text-blue-600">
                        Download Manuscript File
                    </a>
                </p>
            </div>
            <hr>

            @foreach ($sections as $key => $sub_sections)
                <div class="p-3 bg-[#175883] text-white ">
                    {{ $sub_sections->title }}
                </div>

                @foreach ($sub_sections->reviewSections as $skey => $section)
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
                                <tr class="">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">
                                        <p class="w-full">{{ $data->title }}</p>
                                    </td>

                                    @foreach ($section->reviewSectionOption as $key => $option)
                                        <td class="whitespace-nowrap px-6 py-4 font-medium text-center">
                                            <input type="radio" name="option{{ $data->id }}"
                                                wire:model.live="reviewOption.{{ $data->id }}"
                                                value="{{ $option->id }}"
                                                wire:click="upOptions({{ $data->id }}, {{ $option->id }}, '{{ $option->option_value }}')" />
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mb-6">
                        (<i class="text-ms text-red-500">Optional</i>)
                        <x-textarea type="text" id="reviewSComment" class="w-full mt-2"
                            wire:model="reviewSComment.{{ $section->id }}" placeholder="Enter Comments..........."
                            rows="3" />
                        <x-input-error for="reviewSComment" />
                    </div>
                @endforeach
            @endforeach

            <div class="bg-gray-200 px-6 py-4 font-bold">
                Decision
            </div>
            <div class="p-4 border-b">
                <div class="text-justify">
                    <b>Accepted:</b> The paper is approved for publication with no further revisions or only minor
                    editorial changes. The manuscript has merit, the research procedures are appropriate, the findings
                    are credible, and it is well-structured and well-presented. The author may be required to submit a
                    final version that adheres to formatting guidelines.
                    <br><br>

                    <b>Minor revisions:</b> Requires the author to make relatively small adjustments to the paper, which
                    don’t take much time. They might be related to author guideline requirements, e.g., a slight
                    reduction in word count; formatting changes, such as the labelling of tables or figures; further
                    evidence of an understanding of the research literature in the field; or a slight elaboration on the
                    research findings.
                    <br><br>

                    <b>Major revisions:</b> Requires the author to make more significant improvements, the type which
                    take weeks or even months, rather than days. Authors may be asked to address flaws in the
                    methodology; collect more data; conduct a more thorough analysis; or even adjust the research
                    question to ensure the paper contributes something truly original to the body of work.
                    <br><br>

                    <b>Rejected:</b> The paper does not meet the journal's standards and will not be considered for
                    publication due to fundamental flaws in the research, a lack of originality or poor methodology.
                </div>
                <br>
                <br>
                <p class="font-bold">(Determine whether the article is publishable or not, tick the appropriate box)</p>

                <label class="inline-flex items-center cursor-pointer w-full border-b py-2">
                    <x-input type="radio" value="accepted" class="" wire:model.live="review_decision"
                        name="decision" />
                    <span class="ms-3 text-sm font-medium text-gray-900 w-full">
                        Accepted
                    </span>
                </label>

                <label class="inline-flex items-center cursor-pointer w-full border-b py-2">
                    <x-input type="radio" value="minor revision" class="" wire:model.live="review_decision"
                        name="decision" />
                    <span class="ms-3 text-sm font-medium text-gray-900 w-full">
                        Minor Revision
                    </span>
                </label>

                <label class="inline-flex items-center cursor-pointer w-full border-b py-2">
                    <x-input type="radio" value="major revision" class="" wire:model.live="review_decision"
                        name="decision" />
                    <span class="ms-3 text-sm font-medium text-gray-900 w-full">
                        Major Revision
                    </span>
                </label>

                <label class="inline-flex items-center cursor-pointer w-full border-b py-2">
                    <x-input type="radio" value="rejected" class="" wire:model.live="review_decision"
                        name="decision" />
                    <span class="ms-3 text-sm font-medium text-gray-900 w-full">
                        Rejected
                    </span>
                </label>
                <br>
                <br>


            </div>


            <div class="bg-gray-200 px-6 py-4 font-bold">
                Attachment File (<i>Optional</i>)
            </div>

            <div class="p-4 border-b">
                <x-input-file wire:model="review_attachment" id="review_attachment" multiple />
                <x-input-error for="review_attachment" />

                <div class="mt-4 flex gap-2">
                    @foreach ($record->review_attachments as $key => $file)
                        <div class="flex">
                            <a href=""
                                class="bg-yellow-400 hover:bg-yellow-600 shadow-md rounded-l p-2 cursor-pointer">
                                <div class="flex items-center gap-2">
                                    <svg class="h-6 w-6 text-gray-500" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14 2 14 8 20 8" />
                                        <line x1="16" y1="13" x2="8" y2="13" />
                                        <line x1="16" y1="17" x2="8" y2="17" />
                                        <polyline points="10 9 9 9 8 9" />
                                    </svg>

                                    {{ $file->attachment }}
                                </div>
                            </a>
                            <div class="bg-red-500 hover:bg-red-700 shadow-md rounded-r p-2 cursor-pointer"
                                wire:click="removeAttachment({{ $file->id }})">
                                <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if (session('response'))
                @php
                    $bgClass = match (session('response.status')) {
                        'error' => 'bg-red-300',
                        default => 'bg-gray-200',
                    };
                @endphp
                <div class="p-4 text-sm mb-4 mt-2 shadow {{ $bgClass }} w-full text-center">
                    {{ session('response.message') }}
                </div>
            @endif

            <div class="flex gap-4 justify-center mt-6 mb-4">
                <x-button wire:click="store('incomplete')">Save and Submit Later</x-button>
                <x-button class="bg-green-700 hover:bg-green-600" wire:click="store('complete')">Save &
                    Submit</x-button>
            </div>
    @endif

    @if ($juser->pivot->review_status == 'declined')
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 mb-8">
            <div class="flex-1 flex items-center text-justify">
                Dear Reviewer,
                <br>
                Thank you for taking the time to consider reviewing the manuscript titled
                "{{ $submission?->article->title }}" (ID:
                {{ $submission?->article->paper_id }}). We appreciate your transparency in declining and value the
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
                Thank you for submitting your review for the manuscript titled "{{ $submission?->article->title }}"
                (ID:{{ $submission?->article->paper_id }}). Your
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
