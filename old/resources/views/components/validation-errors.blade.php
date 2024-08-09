@if ($errors->any())
    <div {{ $attributes }}>
        {{-- <div class="font-medium text-red-600 text-center">{{ __('Whoops! Something went wrong.') }}</div> --}}

        @if(session('blocked'))
        <div class="font-medium text-red-600 text-center">{{ session('blocked') }}</div>
        @else
            <ul class="mb-3 list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endif
