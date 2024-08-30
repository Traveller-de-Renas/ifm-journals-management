<div class="max-w-screen-xl mx-auto w-full overflow-hidden mt-4">
    
    <p class="font-bold mb-2">
        <span class="font-bold">Journal : </span>{{ $record->journal->title }}
    </p>

    <p class="font-bold mb-2">
        <span class="font-bold">Title : </span>{{ $record->title }}
    </p>

    <p class="mb-2">
        <span class="font-bold">Editor : </span>{{ $editor->salutation?->title }} {{ $editor->first_name }} {{ $editor->middle_name }} {{ $editor->last_name }}
    </p>

    <p class="mb-2">
        <span class="font-bold">Reviewer : </span>{{ $reviewer->salutation?->title }} {{ $reviewer->first_name }} {{ $reviewer->middle_name }} {{ $reviewer->last_name }}
    </p>

    <div class="flex mb-4">
        <p class="font-bold">Original Submission : </p>
        <a href="{{ asset('storage/articles/'.$submission->file_path) }}" target="_blank" class="text-blue-700 hover:text-blue-600"> 
        {{ $submission->file_path }}
        </a>
    </div>

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
                <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 grey:border-neutral-500 grey:hover:bg-neutral-600">
                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $data->title }}</td>
                
                    @foreach ($section->reviewSectionOption as $key => $option)
                        <td class="whitespace-nowrap px-6 py-4 font-medium text-center">
                            <input type="radio" name="option{{ $data->id }}" wire:model.live="selectedOption.{{ $data->id }}" value="{{ $option->id }}" wire:click="upOptions({{ $data->id }}, {{ $option->id }})" />
                        </td>
                    @endforeach
                </tr>
                @endforeach
                

            </tbody>
        </table>

    @endforeach

    <div class="text-center mt-4">
        <x-button wire:click="store()">Save Only</x-button>
        <x-button >Save & Submit</x-button>
    </div>
</div>
