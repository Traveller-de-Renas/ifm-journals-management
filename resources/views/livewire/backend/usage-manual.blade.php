<div>
    <div class="fixed bottom-3 right-0">
        <div class="right-2 z-50 w-42 text-white bg-red-700 hover:bg-red-600 bg-opacity-60 p-2 cursor-pointer rounded-tl-xl rounded-bl-xl flex gap-2 animate-float" wire:click="openManual()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>

            USAGE MANUAL
        </div>
    </div>

    <div>
        <div class="fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform bg-white w-8/12 {{ $userManual ? 'translate-x-0' : 'translate-x-full' }}"
            style="transition: transform 0.3s ease-in-out;">
            <h5 class="inline-flex items-center mb-4 text-base font-semibold text-gray-500">
                <svg class="w-4 h-4 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                Usage Manual
            </h5>

            <button wire:click="closeManual"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close menu</span>
            </button>

            <hr>

            <iframe src="{{ asset('storage/manual.pdf') }}" width="100%" height="100%"></iframe>
        </div>

    </div>
    <!-- Backdrop -->
    <div wire:click="closeManual" class="fixed inset-0 bg-black bg-opacity-50 z-40 {{ $userManual ? 'block' : 'hidden' }}"></div>
</div>