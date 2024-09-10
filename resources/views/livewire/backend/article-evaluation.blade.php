<x-module>
    
    <p class="font-bold text-lg mb-2">
        <span class="font-bold">Journal : </span>{{ $record->journal->title }}
    </p>

    <p class="font-bold text-2xl mb-2">
        {{ $record->title }}
    </p>

    <p class="mb-2 text-lg">
        <span class="font-bold">Editor : </span>{{ $editor->salutation?->title }} {{ $editor->first_name }} {{ $editor->middle_name }} {{ $editor->last_name }}
    </p>

    <p class="mb-2 text-lg">
        <span class="font-bold">Reviewer : </span>{{ $reviewer->salutation?->title }} {{ $reviewer->first_name }} {{ $reviewer->middle_name }} {{ $reviewer->last_name }}
    </p>

    <div class="flex mb-4 text-lg">
        <p class="font-bold">Original Submission : </p>
        <a href="{{ asset('storage/articles/'.$submission?->file_path) }}" target="_blank" class="text-blue-700 hover:text-blue-600"> 
            {{ $submission?->file_path }}
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-md mb-4 shadow bg-green-300 w-full">
            {{ session('success') }}
        </div>
    @endif

    <div class="py-2 text-right">
        <x-button-plain class="bg-red-700 hover:bg-red-600" wire:click="declineArticle()">
            Decline
        </x-button-plain>
    </div>

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

    <div class="mt-4 p-6">
        <x-label for="file_attachment" value="Attachments" class="mb-2 block text-sm text-gray-700" />
        <x-input-file wire:model="attachment" id="file_attachment" />
        <x-input-error for="file_attachment" />
    </div>

    <div class="text-center mt-4 mb-4">
        <x-button wire:click="store()">Save Only</x-button>
        <x-button >Save & Submit</x-button>
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