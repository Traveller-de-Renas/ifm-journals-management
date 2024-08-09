<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

            <div class="px-4 py-4 w-full">
            
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight mb-4">{{ $title }}</h2>
                <div class="mt-1 flex sm:mt-0 sm:flex-row sm:flex-wrap">
                        
                    @if (session('success'))
                        <div class="p-4 rounded-md mb-4 shadow bg-green-300 w-full">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{ $slot }}

                </div>

            </div>
        </div>
    </div>
</div>