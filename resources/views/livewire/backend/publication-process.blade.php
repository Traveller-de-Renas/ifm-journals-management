<div class="bg-white shadow-md p-4 rounded">
    {{ __('PUBLICATION PROCESS') }}

    <div class="w-full grid grid-cols-3 gap-4" >
        <div class="">
            <x-input wire:model.live.debounce.500ms="query" placeholder="search..." type="search" />
        </div>
        <div class=""></div>
        <div class="flex gap-2 justify-end">
            <x-button class="" wire:click="volumeModal()" wire:loading.attr="disabled" >Create Volume</x-button>
            
        </div>
    </div>

    @if (session('response'))
        @php
            $bgClass = match (session('response.status')) {
                'success' => 'bg-green-300',
                'danger'  => 'bg-red-300',
                'warning' => 'bg-yellow-300',
                'info'    => 'bg-blue-300',
                default   => 'bg-gray-200',
            };
        @endphp
        <div class="p-4 text-sm mb-4 mt-2 shadow {{ $bgClass }} w-full text-center">
            {{ session('response.message') }}
        </div>
    @endif

    <br>

    <div class="w-full mx-auto">
        <div class="bg-white">

            @foreach ($volumes as $volume)
            <!-- Accordion Item 1 -->
            <div x-data="{ open: false }" class="border-b">

                <div class="flex justify-between bg-gray-100 hover:bg-gray-200">
                    <button @click="open = !open" class="w-full text-left px-4 py-2 font-semibold text-gray-700">
                        {{ $volume->description }}
                    </button>
                    <div>
                        <div x-data="{ open: false }" class="relative inline-block text-left">
                            <button @click="open = !open" class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 " aria-expanded="false" aria-haspopup="true">
                                <svg class="h-6 w-6 text-gray-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="1" />  <circle cx="19" cy="12" r="1" />  <circle cx="5" cy="12" r="1" /></svg>
                            </button>
                          
                            <div x-show="open" ransition @click.away="open = false" class="absolute right-0 z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 min-w-40 ">
                                <div class="py-1">
                                    <button class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" wire:click="createIssue({{ $volume->id }}, 'normal')">Create Normal Issue</button>
                                    <button class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" wire:click="createIssue({{ $volume->id }}, 'special')">Create Special Issue</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div x-show="open" x-transition class="p-2 text-gray-600">
                    <div class="mt-2">
                        @foreach ($volume->issues()->orderBy('number', 'DESC')->get() as $_issue)
                        <div x-data="{ open: false }" class="border-b">
                            <div class="flex justify-between bg-gray-100 hover:bg-gray-200">
                                <button @click="open = !open" class="w-full text-left px-4 py-2 font-semibold text-gray-700">
                                    {{ $_issue->description }}
                                </button>
                                <div class="">

                                    @if($_issue->publication == 'Published' && !(auth()->user()->hasPermissionTo('Submit Manuscript Manually')))
                                        <div class="text-green-500 font-bold flex justify-center items-center h-full px-2">
                                            {{ $_issue->publication }}
                                        </div>
                                    @else
                                        <div x-data="{ open: false }" class="relative inline-block text-left">
                                            <button @click="open = !open" class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 " aria-expanded="false" aria-haspopup="true">
                                                <svg class="h-6 w-6 text-gray-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="1" />  <circle cx="19" cy="12" r="1" />  <circle cx="5" cy="12" r="1" /></svg>
                                            </button>
                                        
                                            <div x-show="open" ransition @click.away="open = false" class="absolute right-0 z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 min-w-40 ">
                                                <div class="py-1">

                                                    @if($_issue->articles()->count() > 0)
                                                        <button class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-right" wire:click="issueModal({{ $_issue->id }})">Publish Issue</button>
                                                    @endif

                                                    <button class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-right" wire:click="openDrawer({{ $_issue->id }})">Assign Manuscripts</button>
                                                    <button class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-right" wire:click="openDrawerA({{ $_issue->id }})">Editorial Remarks</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div x-show="open" x-transition class="text-gray-600">

                                @foreach ($_issue->articles as $article)
                                    <div class="mt-2 border shadow p-2">
                                        <p class="font-bold text-blue-700 hover:text-blue-500 hover:underline cursor-pointer w-full" >
                                            <a href="{{ route('journals.article', $article->uuid) }}" wire:loading.attr="disabled">{{ $article->title }} - {{ $article->paper_id }}</a>
                                        </p>

                                        {{ $article->aticle_journal_users }}

                                        <p class="text-sm mt-2">{{ \Carbon\Carbon::parse($article->submission_date)->format('d-m-Y') }}</p>
                                    </div>
                                @endforeach
                                
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>

    <div class="mt-4 w-full">
        {{ $volumes->links() }}
    </div>

    <div>
        <div 
            class="fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform bg-white w-5/12 {{ $isOpen ? 'translate-x-0' : 'translate-x-full' }}" 
            style="transition: transform 0.3s ease-in-out;"
        >
            <h5 class="inline-flex items-center mb-4 text-base font-semibold text-gray-500">
                <svg class="w-4 h-4 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                Assign Manuscripts to this Issue
            </h5>
    
            <button wire:click="closeDrawer" 
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center ">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close menu</span>
            </button>

            <hr>
            
            @if($articles->count() > 0)

                <div class="mt-2">
                    <x-input wire:model.live.debounce.500ms="search_manuscript" placeholder="Search Manuscript..." type="search" class="w-full" />
                </div>

                @foreach ($articles as $article)
                    <div class="mt-2 flex gap-2 items-center border-b p-2">
                        <div>
                            <input type="checkbox" id="article_{{ $article->id }}" wire:model="selected_articles" value="{{ $article->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-1">
                        </div>
                        <div>
                            <x-label for="article_{{ $article->id }}">{{ $article->title }}</x-label>
                        </div>
                    </div>
                @endforeach

            @else
                <div class="mt-2 bg-red-500 text-center text-white rounded p-2">No Manuscripts Found</div>
            @endif

            <x-button class="float-right mt-4" wire:click="assignManuscript()" wire:loading.attr="disabled" >{{ __('Submit') }}</x-button>
        </div>
    </div>

    <!-- Backdrop -->
    <div wire:click="closeDrawer" class="fixed inset-0 bg-black bg-opacity-50 z-40 {{ $isOpen ? 'block' : 'hidden' }}"></div>



    <div>
        <div 
            class="fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform bg-white w-5/12 {{ $isOpenA ? 'translate-x-0' : 'translate-x-full' }}" 
            style="transition: transform 0.3s ease-in-out;"
        >
            <h5 class="inline-flex items-center mb-4 text-base font-semibold text-gray-500">
                <svg class="w-4 h-4 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                Editorial Remarks for the Issue
            </h5>
    
            <button wire:click="closeDrawerA" 
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center ">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close menu</span>
            </button>

            <hr>
            
            <div class="mb-2 w-full">
                <div class="mt-4" wire:ignore>
                    <x-label for="editorial" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-textarea type="text" id="editorial" class="w-full" wire:model="editorial" rows="6" />
                    <x-input-error for="editorial" />
                </div>
            </div>

            <div class="mt-4">
                <x-label for="editorial_file" value="Select PDF file for Editorial" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input-file type="file" class="" id="editorial_file" wire:model="editorial_file" />
                <x-input-error for="editorial_file" />
            </div>
            
            <div class="text-right mt-4">
                <x-button class="" wire:click="submitEditorial()" wire:loading.attr="disabled" >{{ __('Submit') }}</x-button>
            </div>
            

            <div class="mt-8">
                @if($issue?->editorial_file != '' && Storage::exists('editorial/'.$issue?->editorial_file))
                    <div class="w-full flex gap-2">
                        <p class="bg-gray-100 w-full rounded p-2 shadow-sm">{{ __('Current Editorial Review') }}</p>
                        <x-button class="bg-red-500 hover:bg-red-700" wire:click="removeEditorial()">Remove</x-button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Backdrop -->
    <div wire:click="closeDrawerA" class="fixed inset-0 bg-black bg-opacity-50 z-40 {{ $isOpenA ? 'block' : 'hidden' }}"></div>


    
    <x-dialog-modal wire:model="volumeMod">
        <x-slot name="title">
            <div class="flex items-center">
                <svg class="w-4 h-4 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg> <p>{{ __('Confirm Creating new Volume') }}</p>
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="mt-4 p-2">
                
                <p class="text-center">Creating New Volume will close the current volume and you will not be able to create new issue to the previous volume. Are you sure you want to perform this action.?</p>

            </div>
        </x-slot>
        <x-slot name="footer">
            
            <x-button type="submit" class="bg-green-500 hover:bg-green-700" wire:click="createVolume()" wire:loading.attr="disabled" >
                {{ __('Confirm Create Volume') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('volumeMod')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>


    <x-dialog-modal wire:model="issueMod">
        <x-slot name="title">
            <div class="flex items-center">
                <svg class="w-4 h-4 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg> <p>{{ __('Confirm Publishing Issue') }}</p>
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="mt-4 p-2">
                
                <p class="text-center">Publishing this Issue will close the window for assigning manuscripts on this issue and you will not be able to publish another manuscript to this issue. Are you sure you want to perform this action.?</p>

            </div>
        </x-slot>
        <x-slot name="footer">
            
            <x-button type="submit" class="bg-green-500 hover:bg-green-700" wire:click="publishIssue({{ $issue?->id }})" wire:loading.attr="disabled" >
                {{ __('Confirm and Publish') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('issueMod')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>

</div>

<script>
    window.addEventListener('contentChanged', (e) => {
        tinymce.remove('#editorial');
        tinymce.init({
            selector: '#editorial',
            plugins: 'code advlist lists table link',
            
            height: 300,
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
                    @this.set('editorial', editor.getContent());
                });
            },
        });
    })
</script>