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
