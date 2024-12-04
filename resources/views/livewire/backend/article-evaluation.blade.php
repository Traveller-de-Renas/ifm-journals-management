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
                <div class="w-1/12">
                    EDITOR
                </div>
                <div class="w-full">
                    {{ $editor->salutation?->title }} {{ $editor->first_name }} {{ $editor->middle_name }} {{ $editor->last_name }}
                    <p class="text-sm text-gray-400">{{ $editor->affiliation }}</p>
                </div>
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

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 mb-8">
        @php
            $file = $record->files()->where('publish', 1)->first();
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

            <div class="flex-1 text-right w-full">
                <x-button-plain class="bg-green-700 hover:bg-green-600 text-xs" wire:click="declineArticle()">
                    Accept
                </x-button-plain>
                <x-button-plain class="bg-red-700 hover:bg-red-600 text-xs" wire:click="declineArticle()">
                    Decline
                </x-button-plain>
            </div>

        </div>
    </div>

    <hr>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 mb-8">

    @if(session('success'))
        <div class="p-4 rounded-md mb-4 shadow bg-green-300 w-full">
            {{ session('success') }}
        </div>
    @endif

    

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
                        <x-textarea type="text" id="description" class="w-full mt-2" wire:model="commentWritten.{{ $data->id }}" placeholder="Enter Description" rows="5" />
                        @endif
                    </td>
                    @if($section->category == 'options')
                    @foreach ($section->reviewSectionOption as $key => $option)
                        <td class="whitespace-nowrap px-6 py-4 font-medium text-center">
                            <input type="radio" name="option{{ $data->id }}" wire:model.live="selectedOption.{{ $data->id }}" value="{{ $option->id }}" wire:click="upOptions({{ $data->id }}, {{ $option->id }})" />
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
        <x-input-file wire:model="attachment" id="file_attachment" />
        <x-input-error for="file_attachment" />
    </div>

    <div class="text-center mt-6 mb-4">
        <x-button wire:click="store()">Save and Submit Later</x-button>
        <x-button-plain class="bg-green-700 hover:bg-green-600" wire:click="store()" >Save & Submit</x-button>
    </div>

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
    <div>
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