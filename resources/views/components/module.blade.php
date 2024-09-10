<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">

            <div class="px-4 py-4 w-full">
                
                @if (isset($title))
                    <h2 class="text-3xl font-bold text-gray-900 mb-4 w-full text-wrap">{{ $title }}</h2>
                @endif

                <div class="mt-1">
                        
                    @if (session('success'))
                        <div class="p-4 rounded-md text-sm mb-4 shadow bg-green-300 w-full">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{ $slot }}

                </div>

            </div>
        </div>
    </div>
</div>