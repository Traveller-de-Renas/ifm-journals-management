<x-module>
    
    <x-slot name="title">
        {{ __('JOURNALS') }}
    </x-slot>

    @if ($form)
        
<div class="p-4 w-full">


<ol class="relative text-gray-500 border-s border-gray-200 dark:border-gray-700 dark:text-gray-400">                  
    <li class="mb-10 ms-6">            
        <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                <path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z"/>
            </svg>
        </span>
        <h3 class="font-medium leading-tight">General Information</h3>
        <div class="w-full">
            <div class="mt-4">
                <x-label for="title" value="Title" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input type="text" id="title" class="w-full" wire:model="title" />
                <x-input-error for="title" />
            </div>

            <div class="grid grid-cols-3 space-x-2">
                <div class="mt-4">
                    <x-label for="code" value="Code" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="code" class="w-full" wire:model="code" />
                    <x-input-error for="code" />
                </div>
                <div class="mt-4">
                    <x-label for="issn" value="ISSN" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="issn" class="w-full" wire:model="issn" />
                    <x-input-error for="issn" />
                </div>
                <div class="mt-4">
                    <x-label for="eissn" value="EISSN" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="eissn" class="w-full" wire:model="eissn" />
                    <x-input-error for="eissn" />
                </div>
            </div>
            
            <div class="grid grid-cols-3 space-x-2">
                <div class="mt-4 col-span-2">
                    <x-label for="publisher" value="Publisher" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="publisher" class="w-full" wire:model="publisher" />
                    <x-input-error for="publisher" />
                </div>
                <div class="mt-4">
                    <x-label for="year" value="Year" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="year" class="w-full" wire:model="year" />
                    <x-input-error for="year" />
                </div>
            </div>

            <div class="mt-4" @if(!$form) wire:ignore @endif>
                <x-label for="description" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-textarea type="text" id="description" class="w-full" wire:model="description" />
                <x-input-error for="description" />
            </div>

            <div class="mt-4" @if(!$form) wire:ignore @endif>
                <x-label for="scope" value="Aim and Scope" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-textarea type="text" id="scope" class="w-full" wire:model="scope" />
                <x-input-error for="scope" />
            </div>

            <div class="grid grid-cols-2 space-x-2">
                <div class="mt-4">
                    <x-label for="email" value="Email" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="email" class="w-full" wire:model="email" />
                    <x-input-error for="email" />
                </div>
                <div class="mt-4">
                    <x-label for="website" value="Website" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="website" class="w-full" wire:model="website" />
                    <x-input-error for="website" />
                </div>
            </div>

            <div class="grid grid-cols-3 space-x-2">
                <div class="mt-4">
                    <x-label for="image" value="Image" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input-file type="file" id="image" class="w-full" wire:model="image" />
                    <x-input-error for="image" />
                </div>

                <div class="mt-4">
                    <x-label for="category" value="Category" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="category" class="w-full" :options="$categories" wire:model="category" />
                    <x-input-error for="category" />
                </div>
                    
                <div class="mt-4">
                    <x-label for="status" value="status" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="status" class="w-full" :options="['1' => 'Active', '0' => 'Inactive']" wire:model="status" />
                    <x-input-error for="status" />
                </div>
            </div>

        </div>
    </li>

    <li class="mb-10 ms-6">
        <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
            </svg>
        </span>
        <h3 class="font-medium leading-tight">Authors' Guidelines</h3>

        @foreach ($instructions as $key => $instruction)
        
        <div class="grid grid-cols-3 gap-4">
            <div class="mt-4 ">
                <x-label for="instruction_title" value="Title" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input type="text" id="instruction_title" class="w-full" wire:model="instruction_title.{{ $key }}" />
                <x-input-error for="instruction_title" />
            </div>

            <div class="mt-4 col-span-2" @if(!$form) wire:ignore @endif>
                <x-label for="instruction_description" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-textarea type="text" id="instruction_description" class="w-full h-10" wire:model="instruction_description.{{ $key }}" />
                <x-input-error for="instruction_description" />
            </div>
        </div>

        @endforeach

        <div class="text-right mt-4">
            <x-button type="button" wire:click="addRows('instructions')" wire:loading.attr="disabled">
                {{ __('Add Instructions') }}
            </x-button>
        </div>
    </li>

    <li class="mb-10 ms-6">
        <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
            </svg>
        </span>
        <h3 class="font-medium leading-tight">Indexing</h3>

        @foreach ($indecies as $key => $index)
        
        <div class="grid grid-cols-3 gap-4">
            <div class="mt-4">
                <x-label for="index_title" value="Title" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input type="text" id="index_title" class="w-full" wire:model="index_title.{{ $key }}" />
                <x-input-error for="index_title" />
            </div>

            <div class="mt-4" @if(!$form) wire:ignore @endif>
                <x-label for="index_description" value="Description" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-textarea type="text" id="index_description" class="w-full h-10" wire:model="index_description.{{ $key }}" />
                <x-input-error for="index_description" />
            </div>

            <div class="mt-4">
                <x-label for="index_link" value="Link" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input type="text" id="index_link" class="w-full" wire:model="index_link.{{ $key }}" />
                <x-input-error for="index_link" />
            </div>
        </div>

        @endforeach

        <div class="text-right mt-4">
            <x-button type="button" wire:click="addRows('indecies')" wire:loading.attr="disabled">
                {{ __('Add More Index') }}
            </x-button>
        </div>
    </li>

    <li class="ms-6">
        <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z"/>
            </svg>
        </span>
        <h3 class="font-medium leading-tight">Confirmation & Submission</h3>

        @foreach ($confirmations as $key => $confirmation)
        
        <div class="gap-4">
            <div class="mt-4" @if(!$form) wire:ignore @endif>
                <x-textarea type="text" id="confirmation_description" class="w-full h-10" wire:model="confirmation_description.{{ $key }}" placeholder="Enter Confirmation Description" />
                <x-input-error for="confirmation_description" />
            </div>
        </div>

        @endforeach

        <div class="text-right mt-4">
            <x-button type="button" wire:click="addRows('confirmations')" wire:loading.attr="disabled">
                {{ __('Add Description') }}
            </x-button>
        </div>

        <div class="grid grid-cols-2 mt-4">
            <div class="text-sm ">Before submission please check and confirm details of the journal</div>
            <div class="text-right">
                <x-button type="submit" wire:click="store()" wire:loading.attr="disabled">
                    {{ __('Submit') }}
                </x-button>
                <x-secondary-button class="ml-3" wire:click="$toggle('form')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>
            </div>
        </div>
        
    </li>
</ol>

</div>

    @else
        <div class="w-full md:grid md:grid-cols-3 gap-4" >
            <div class="">
                <x-input wire:model.live.debounce.500ms="query" placeholder="search..." type="search" />
            </div>
            <div class=""></div>
            <div class="">
                <x-button class="float-right" wire:click="$toggle('form')" wire:loading.attr="disabled" >Create New</x-button>
            </div>
        </div>

    @endif


    <x-dialog-modal wire:model="Delete">
        <x-slot name="title">
            {{ __('Delete Data') }}
        </x-slot>
        <x-slot name="content">
            <div class="mt-4">
                <p class="text-center">Are you sure you want to delete this record.?</p>
            </div>
        </x-slot>
        <x-slot name="footer">
            
            <x-button-danger type="submit" wire:click="delete({{ $record }})" wire:loading.attr="disabled" >
                {{ __('Delete') }}
            </x-button-danger>
            <x-secondary-button class="ml-3" wire:click="$toggle('Edit')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>


            <div class="cd2pr">

                <!-- Left + Middle content -->
                <div class="ctin8 cy6kd">

                    <!-- Left content -->
                    <div class="ccs95 cp6dx c3ff8 ce97l">
                        <div class="c1w44 c0u2w cby1z cz385 cda5l c97qj">
                            <div class="ch5dq">

                                <div class="bg-white dark:bg-slate-800 rounded-sm border border-slate-200 dark:border-slate-700 cetne ccg4t ctk06">
                                    <div class="c35uo ccoxm cki30 c5va1">
                                        <!-- Group 1 -->
                                        <div>
                                            <div class="text-sm text-slate-800 dark:text-slate-100 cqosy cvavu">Subjects</div>
                                            <ul class="cbfhc">

                                                @foreach ($subjects as $subject)
                                                    <li>
                                                        <label class="flex items-center">
                                                            <input type="checkbox" class="cybz1" checked="">
                                                            <span class="text-sm ch1ih c6w4h cw92y c9o7o">{{ $subject->name }}</span>
                                                        </label>
                                                    </li>
                                                @endforeach
                                                
                                            </ul>

                                            <div class="text-sm text-slate-800 dark:text-slate-100 cqosy cvavu mt-6">Categories</div>
                                            <ul class="cbfhc">

                                                @foreach ($categories as $key => $categ)
                                                    <li>
                                                        <label class="flex items-center">
                                                            <input type="checkbox" class="cybz1" checked="">
                                                            <span class="text-sm ch1ih c6w4h cw92y c9o7o">{{ $categ }}</span>
                                                        </label>
                                                    </li>
                                                @endforeach
                                                
                                            </ul>
                                        </div>
                                        
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Middle content -->
                    <div class="2xl:mx-8 clt4z cnyty c0kv5 cy6kd">
                        <div class="ch5dq">

                            <!-- Blocks -->
                            <div class="cxebx">

                                @foreach ($journals as $data)
                                <!-- Post 1 -->
                                <div class="bg-white dark:bg-slate-800 shadow-md rounded border border-slate-200 dark:border-slate-700 ctk06">
                                    <!-- Header -->
                                    <header class="flex cmgwo cxbmt cb7d8 cvavu">
                                        <!-- User -->
                                        <div class="flex cxbmt cb7d8">
                                            <img class="rounded-full c7n6y" src="{{ asset('storage/favicon/Male.png') }}" width="40" height="40" alt="User 03">
                                            <div>
                                                <div class="cdknc">
                                                    <a class="text-sm text-slate-800 dark:text-slate-100 cqosy" href="#0">Dominik Lamakani</a>
                                                </div>
                                                <div class="text-slate-500 c0qeg">{{ $data->created_at}}</div>
                                            </div>
                                        </div>
                                        <!-- Menu button -->
                                        <div class="c4ijw">
                                            <div class="inline-flex csmh2 cke32 cvqv9" x-data="{ open: false }">
                                                <button class="rounded-full" :class="open ? 'c6vqo ce4zx text-slate-500 dark:czgoy': 'czgoy cljes ciz4v coyl7'" aria-haspopup="true" @click.prevent="open = !open" :aria-expanded="open">
                                                    <span class="cbl3h">Menu</span>
                                                    <svg class="c3wll chmgx c6dxj" viewBox="0 0 32 32">
                                                        <circle cx="16" cy="16" r="2"></circle>
                                                        <circle cx="10" cy="16" r="2"></circle>
                                                        <circle cx="22" cy="16" r="2"></circle>
                                                    </svg>
                                                </button>
                                                <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded creyy ct1ew cetne csmh2 c8gb2 cjxbp cke32 c8407 cox8h c5xk8" @click.outside="open = false" @keydown.escape.window="open = false" x-show="open" x-transition:enter="c5mjj coq4n ch8aq ccio3" x-transition:enter-start="opacity-0 c3pue" x-transition:enter-end="cqsra cfwq4" x-transition:leave="c5mjj coq4n ch8aq" x-transition:leave-start="cqsra" x-transition:leave-end="opacity-0" x-cloak="">
                                                    <ul>
                                                        <li>
                                                            <a class="text-sm flex cn6r0 cnz6z ch1ih c6w4h cw92y cjm6w cynm4" href="{{ route('journals.details', $data->uuid) }}" @click="open = false" @focus="open = true" @focusout="open = false">View</a>
                                                        </li>
                                                        <li>
                                                            <a class="text-sm flex cn6r0 cnz6z ch1ih c6w4h cw92y cjm6w cynm4" href="#0" @click="open = false" @focus="open = true" @focusout="open = false">Edit</a>
                                                        </li>
                                                        <li>
                                                            <a class="text-sm flex cvu65 c6tg6 cw92y cjm6w cynm4" href="#0" @click="open = false" @focus="open = true" @focusout="open = false">Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </header>
                                    <!-- Body -->
                                    <div class="text-sm text-slate-800 dark:text-slate-100 cbfhc cg5st">
                                        <p>{{ $data->title }}</p>
                                        <p class="text-justify">{{ $data->description }}</p>
                                    </div>

                                    <x-button>Enroll to this Journal </x-button>

                                    <a href="{{ route('journals.submission', $data->uuid) }}">
                                    <x-button>Submit a Paper </x-button>
                                    </a>
                                    
                                </div>
                                @endforeach
                                

                            </div>

                            <div class="mt-4 w-full">
                                {{ $journals->links() }}
                            </div>

                        </div>
                    </div>

                </div>

                <!-- Right content -->
                {{-- <div class="hidden cyz0i czlvn c3ff8">
                    <div class="csw5y cyvom cyd4x cz385 cy50a c3v2o">
                        <div class="ch5dq">

                            

                            <!-- Blocks -->
                            <div class="cxebx">

                                <!-- Block 1 -->
                                <div class="rounded border border-slate-200 dark:border-slate-700 c4q8v cn1je c5mbg">
                                    <div class="ciz4v czgoy cqosy cw3n3 c0qeg c958j">Top Communities</div>
                                    <ul class="cd0mw">
                                        <li>
                                            <div class="flex items-center cmgwo">
                                                <div class="flex items-center ckut6">
                                                    <div class="c4ijw czt1n">
                                                        <img class="rounded-full chmgx c6dxj" src="images/group-avatar-01.png" width="32" height="32" alt="Group 01">
                                                    </div>
                                                    <div class="c32al">
                                                        <span class="text-sm text-slate-800 dark:text-slate-100 cw92y">Introductions</span>
                                                    </div>
                                                </div>
                                                <button class="inline-flex text-indigo-600 rounded-full c0ewf cnzyq c56zo cob4g cw92y csq8i c0qeg cynm4">Join</button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="flex items-center cmgwo">
                                                <div class="flex items-center ckut6">
                                                    <div class="c4ijw czt1n">
                                                        <img class="rounded-full chmgx c6dxj" src="images/group-avatar-02.png" width="32" height="32" alt="Group 02">
                                                    </div>
                                                    <div class="c32al">
                                                        <span class="text-sm text-slate-800 dark:text-slate-100 cw92y">HackerNews</span>
                                                    </div>
                                                </div>
                                                <button class="inline-flex text-indigo-600 rounded-full c0ewf cnzyq c56zo cob4g cw92y csq8i c0qeg cynm4">Join</button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="flex items-center cmgwo">
                                                <div class="flex items-center ckut6">
                                                    <div class="c4ijw czt1n">
                                                        <img class="rounded-full chmgx c6dxj" src="images/group-avatar-03.png" width="32" height="32" alt="Group 03">
                                                    </div>
                                                    <div class="c32al">
                                                        <span class="text-sm text-slate-800 dark:text-slate-100 cw92y">ReactJs</span>
                                                    </div>
                                                </div>
                                                <button class="inline-flex rounded-full cq2p6 cdbjv c6rpu cwvsn cob4g cw92y csq8i c0qeg cynm4">
                                                    <svg class="c3wll c7n6y cgmrc cm474" viewBox="0 0 16 16">
                                                        <path d="m2.457 8.516.969-.99 2.516 2.481 5.324-5.304.985.989-6.309 6.284z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="flex items-center cmgwo">
                                                <div class="flex items-center ckut6">
                                                    <div class="c4ijw czt1n">
                                                        <img class="rounded-full chmgx c6dxj" src="images/group-avatar-04.png" width="32" height="32" alt="Group 04">
                                                    </div>
                                                    <div class="c32al">
                                                        <span class="text-sm text-slate-800 dark:text-slate-100 cw92y">JustChatting</span>
                                                    </div>
                                                </div>
                                                <button class="inline-flex text-indigo-600 rounded-full c0ewf cnzyq c56zo cob4g cw92y csq8i c0qeg cynm4">Join</button>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="cuf7q">
                                        <button class="bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 text-indigo-500 c46uo cm7vt cljmx cjusy c3ff8">View All</button>
                                    </div>
                                </div>

                                <!-- Block 2 -->
                                <div class="rounded border border-slate-200 dark:border-slate-700 c4q8v cn1je c5mbg">
                                    <div class="ciz4v czgoy cqosy cw3n3 c0qeg c958j">Who to follow</div>
                                    <ul class="cd0mw">
                                        <li>
                                            <div class="flex items-center cmgwo">
                                                <div class="flex items-center ckut6">
                                                    <div class="c4ijw czt1n">
                                                        <img class="rounded-full chmgx c6dxj" src="images/user-32-02.jpg" width="32" height="32" alt="User 02">
                                                    </div>
                                                    <div class="c32al">
                                                        <span class="text-sm text-slate-800 dark:text-slate-100 cw92y">Elly Boutin</span>
                                                    </div>
                                                </div>
                                                <button class="inline-flex text-indigo-600 rounded-full c0ewf cnzyq c56zo cob4g cw92y csq8i c0qeg cynm4">Follow</button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="flex items-center cmgwo">
                                                <div class="flex items-center ckut6">
                                                    <div class="c4ijw czt1n">
                                                        <img class="rounded-full chmgx c6dxj" src="images/user-32-04.jpg" width="32" height="32" alt="User 04">
                                                    </div>
                                                    <div class="c32al">
                                                        <span class="text-sm text-slate-800 dark:text-slate-100 cw92y">Rich Harris</span>
                                                    </div>
                                                </div>
                                                <button class="inline-flex text-indigo-600 rounded-full c0ewf cnzyq c56zo cob4g cw92y csq8i c0qeg cynm4">Follow</button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="flex items-center cmgwo">
                                                <div class="flex items-center ckut6">
                                                    <div class="c4ijw czt1n">
                                                        <img class="rounded-full chmgx c6dxj" src="images/user-32-05.jpg" width="32" height="32" alt="User 05">
                                                    </div>
                                                    <div class="c32al">
                                                        <span class="text-sm text-slate-800 dark:text-slate-100 cw92y">Mary Porzio</span>
                                                    </div>
                                                </div>
                                                <button class="inline-flex text-indigo-600 rounded-full c0ewf cnzyq c56zo cob4g cw92y csq8i c0qeg cynm4">Follow</button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="flex items-center cmgwo">
                                                <div class="flex items-center ckut6">
                                                    <div class="c4ijw czt1n">
                                                        <img class="rounded-full chmgx c6dxj" src="images/user-32-01.jpg" width="32" height="32" alt="User 01">
                                                    </div>
                                                    <div class="c32al">
                                                        <span class="text-sm text-slate-800 dark:text-slate-100 cw92y">Brian Lovin</span>
                                                    </div>
                                                </div>
                                                <button class="inline-flex text-indigo-600 rounded-full c0ewf cnzyq c56zo cob4g cw92y csq8i c0qeg cynm4">Follow</button>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="cuf7q">
                                        <button class="bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 text-indigo-500 c46uo cm7vt cljmx cjusy c3ff8">View All</button>
                                    </div>
                                </div>

                                

                            </div>
                        </div>
                    </div>
                </div> --}}

            </div>

</x-module>

<script>
    window.addEventListener('contentChanged', (e) => {
        tinymce.init({
            selector: '#description',
            plugins: 'code advlist lists table link',
            
            /* TinyMCE configuration options */
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