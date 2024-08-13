<x-module>
    
    <x-slot name="title">
        {{ __($record->title) }}
    </x-slot>
        
    <div class="w-full mb-2 bg-gray-200 p-4">

        <div class="grid grid-cols-12 gap-2">
            <p class="text-sm">ISSN: </p>
            <p class="col-span-11">{{ $record->issn }}</p>
        </div>

        <div class="grid grid-cols-12 gap-2">
            <p class="text-sm">EISSN: </p>
            <p class="col-span-11">{{ $record->eissn }}</p>
        </div>

        <div class="grid grid-cols-12 gap-2">
            <p class="text-sm">EMAIL: </p>
            <p class="col-span-11">{{ $record->email }}</p>
        </div>

        <div class="grid grid-cols-12 gap-2">
            <p class="text-sm">CREATED AT: </p>
            <p class="col-span-11">{{ $record->created_at }}</p>
        </div>
        
    </div>

    <div class="w-full text-justify mt-4 mb-4">
        {{ $record->description }}
    </div>

    <div>
        <x-button>Enroll to this Journal </x-button>

        <x-button>Request to be a Reviewer </x-button>
        <x-button>Request to be an Editor </x-button>

        <a href="{{ route('journals.submission', $record->uuid) }}">
            <x-button class="mb-4">Submit a Paper </x-button>
        </a>
    </div>
    

    <div class="md:grid md:grid-cols-12 gap-4 w-full ">

        <div class="col-span-9">
            <div class="w-full mb-4">
                <p class="text-lg font-bold mb-2">Aim and Scope</p>

                <div class="text-justify">
                    {{ $record->scope }}
                </div>
            </div>

            <div class="w-full mb-4">
                <p class="text-lg font-bold mb-2">Editorial Board</p>
                <div>
                    <x-input type="text" class="rounded-none" wire:model="seditor" wire:keyup="searchEditor($event.target.value)" placeholder="Search User" />
                </div>
                <div class="results">
                    @if(!empty($editor_names) && $seditor != '')

                    <div class="w-full bg-gray-200 shadow-lg">
                        @foreach ($editor_names as $key => $editor)
                            <label class="w-full bg-gray-200 p-2 hover:bg-gray-300 cursor-pointer flex gap-4" for="editor{{ $editor->id }}" wire:click="assignEditor({{ $editor->id }})">
                                
                                <div>
                                    <x-input type="checkbox" wire:model="editor_ids" id="editor{{ $editor->id }}" value="{{ $editor->id }}" />
                                </div>
                                <div>
                                    {{ $editor->first_name }}
                                </div>
                                
                            </label>
                        @endforeach
                    </div>
                    
                    @endif
                    
                </div>

                <div class="mt-6">
                   @foreach ($record->journal_users as $journal_user)
                   <div class="flex items-center">
                        <div class="w-full border bg-green-300 border-slate-200 dark:border-slate-700 p-2 rounded-lg">
                        {{ $journal_user->first_name }}
                        {{ $journal_user->middle_name }}
                        {{ $journal_user->last_name }}
                        </div>
                        <div>
                            <x-button-plain class="ml-2 bg-red-600" wire:click="removeEditor({{ $journal_user->id }})">Remove</x-button-plain>
                        </div>
                    </div>
                    @endforeach 
                </div>
                
                
            </div>

            <div class="w-full mb-4">
                <p class="text-lg font-bold mb-2">Indexing</p>

                @if(!empty($record->journal_indices))
                    @foreach ($record->journal_indices as $index)
                        <div class="rounded-sm dark:bg-slate-800 border border-slate-200 dark:border-slate-700 cx95x ctysv mb-2" x-data="{ open: false }">
                            <button class="flex items-center cmgwo c3ff8 c2djl ci4cg" @click.prevent="open = !open" :aria-expanded="open">
                                <div class="text-sm text-slate-800 dark:text-slate-100 cw92y">
                                    <a href="{{ $index->link }}" target="_blank" >{{ $index->title }}</a>
                                </div>
                                <svg class="ml-3 c1bvt cc44c ciz4v czgoy c3wll c7n6y chmgx c6dxj" :class="{ 'cb4kj': open }" viewBox="0 0 32 32">
                                    <path d="M16 20l-5.4-5.4 1.4-1.4 4 4 4-4 1.4 1.4z"></path>
                                </svg>
                            </button>
                            <div class="text-sm" x-show="open" x-cloak="">
                                {{ $index->description }}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="w-full mb-2">
                <p class="text-lg font-bold mb-2">Authors' Guidelines</p>

                @foreach ($record->journal_instructions as $instruction)
                    <div class="rounded-sm dark:bg-slate-800 border border-slate-200 dark:border-slate-700 cx95x ctysv mb-2" x-data="{ open: false }">
                        <button class="flex items-center cmgwo c3ff8 c2djl ci4cg" @click.prevent="open = !open" :aria-expanded="open">
                            <div class="text-sm text-slate-800 dark:text-slate-100 cw92y">{{ $instruction->title }}</div>
                            <svg class="ml-3 c1bvt cc44c ciz4v czgoy c3wll c7n6y chmgx c6dxj" :class="{ 'cb4kj': open }" viewBox="0 0 32 32">
                                <path d="M16 20l-5.4-5.4 1.4-1.4 4 4 4-4 1.4 1.4z"></path>
                            </svg>
                        </button>
                        <div class="text-sm text-justify" x-show="open" x-cloak="">
                            {{ $instruction->description }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-span-3">
            <div class="bg-gray-100 border rounded p-2">

                <p class="text-center">Recent Articles</p>

            </div>
            @foreach ($record->articles as $key => $article)

            <div class="text-sm font-bold text-blue-700 hover:text-blue-600 hover:bg-gray-100 cursor-pointer p-2 border rounded-lg mb-2 mt-2">
                {{ $article->title }}
            </div>
                
            @endforeach

            <a href="{{ route('journals.articles', $record->uuid) }}">
            <x-button class="mb-4 w-full ">View All </x-button>
            </a>
        </div>

    </div>

</x-module>