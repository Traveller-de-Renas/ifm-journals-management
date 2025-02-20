<div class="bg-white shadow-md p-4 rounded">

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

    <div class="w-full">
        <div class="flex items-center mb-6 w-full">
            <div class="flex flex-1 items-center justify-between w-full">
                <div class="flex items-center w-full cursor-pointer" wire:click="setStep(1)">
                    <div class="rounded-full h-12 w-12 flex items-center justify-center {{ $step >= 1 ? 'bg-blue-700 text-white' : 'bg-gray-300 text-gray-600' }}">
                        1
                    </div>
                    <div class="top-0 left-12 w-full h-1 p-1 {{ $step > 1 ? 'bg-blue-700' : 'bg-gray-300' }}"></div>
                </div>
                <div class="flex items-center w-full cursor-pointer" wire:click="setStep(2)">
                    <div class="rounded-full h-12 w-12 flex items-center justify-center {{ $step >= 2 ? 'bg-blue-700 text-white' : 'bg-gray-300 text-gray-600' }}">
                        2
                    </div>
                    <div class=" top-0 left-12 w-full h-1 p-1 {{ $step > 2 ? 'bg-blue-700' : 'bg-gray-300' }}"></div>
                </div>
                <div class="flex items-center w-full cursor-pointer" wire:click="setStep(3)">
                    <div class="rounded-full h-12 w-12 flex items-center justify-center {{ $step >= 3 ? 'bg-blue-700 text-white' : 'bg-gray-300 text-gray-600' }}">
                        3
                    </div>
                    <div class=" top-0 left-12 w-full h-1 p-1 {{ $step > 3 ? 'bg-blue-700' : 'bg-gray-300' }}"></div>
                </div>
                <div class="flex cursor-pointer" wire:click="setStep(4)">
                    <div class="rounded-full h-12 w-12 flex items-center justify-center {{ $step >= 4 ? 'bg-blue-700 text-white' : 'bg-gray-300 text-gray-600' }}">
                        4
                    </div>
                </div>
            </div>
        </div>
        
        <div>
            <div class="w-full @if($step != 1) hidden  @endif" >

                <div class="grid grid-cols-2 gap-2">
                    <div class="mt-4">
                        <x-label for="article_type_id" value="Article Type" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-select wire:model="article_type_id" id="article_type_id" class="w-full" :options="$article_types" />
                        <x-input-error for="article_type_id" />
                    </div>
                    <div class="mt-4">
                        <x-label for="country_id" value="Country" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-select wire:model="country_id" id="country_id" class="w-full" :options="$countries" />
                        <x-input-error for="country_id" />
                    </div>
                </div>
        
                <div class="mt-4">
                    <x-label for="title" value="Title" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input class="w-full" wire:model="title" id="title" type="text" placeholder="Enter Title" />
                    <x-input-error for="title" />
                </div>
        
                <div class="mt-4" wire:ignore >
                    <x-label for="abstract" value="Abstract" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-textarea type="text" id="abstract" class="w-full" wire:model="abstract" placeholder="Enter Abstract" rows="7" />
                    <x-input-error for="abstract" />
                </div>
                
                <div class="grid grid-cols-2 gap-2">
                    <div class="mt-4" >
                        <x-label for="keywords" value="Keywords - Separate by using comma sign (,)" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input type="text" id="keywords" class="w-full" wire:model="keywords" placeholder="Enter Keywords" />
                        <x-input-error for="keywords" />
                    </div>
                    <div class="mt-4" >
                        <x-label for="areas" value="Areas - Separate by using comma sign (,)" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input type="text" id="areas" class="w-full" wire:model="areas" placeholder="Enter areas" />
                        <x-input-error for="areas" />
                    </div>
                </div>

                <div class="mt-4 mb-4">
                    <x-label for="sauthor" value="Authors List" class="mb-2 block font-medium text-sm text-gray-700" />
                    <div class="flex gap-2" >
                        <x-input type="text" class="w-full" wire:model="sauthor" wire:keyup="searchAuthor($event.target.value)" placeholder="Search User to add as Co Author" />
                        <x-button wire:click="createJuser();">Create</x-button>
                    </div>
                    <div class="results">
                        @if(!empty($authors) && $sauthor != '')

                        <div class="w-full bg-gray-200 rounded-md mt-1 shadow-lg">
                            @foreach ($authors as $key => $author)
                                <label class="w-full bg-gray-200 rounded-md p-2 hover:bg-gray-300 cursor-pointer flex gap-4" for="author{{ $author?->id }}" wire:click="assignAuthor({{ $author->id }})" wire:loading.attr="disabled">
                                    
                                    <div>
                                        <x-input type="checkbox" wire:model="author_ids" id="author{{ $author?->id }}" value="{{ $author?->id }}" />
                                    </div>
                                    <div>
                                        {{ $author?->salutation?->title }} {{ $author?->first_name }} {{ $author?->middle_name }} {{ $author?->last_name }}
                                    </div>
                                    
                                </label>
                            @endforeach
                        </div>
                        
                        @endif
                    </div>

                    
                    
                    @if(!empty($record?->article_journal_users))
                    <div class="mt-6">
                        @foreach ($record->article_journal_users()->orderBy('number', 'ASC')->get() as $key => $article_user)
                        <div class="flex items-center">
                            <div class="w-full border bg-gray-200 hover:bg-gray-300 border-slate-200 p-1 px-2 mb-1 rounded-md">
                                {{ $article_user->user->first_name }}
                                {{ $article_user->user->middle_name }}
                                {{ $article_user->user->last_name }}.
                    
                                @if($article_user->user->affiliation) ({{ $article_user->user->affiliation }}) @endif
                            </div>
                            <div class="w-1/5 border bg-gray-200 hover:bg-gray-300 border-slate-200 p-1 px-4 mb-1 ml-2 rounded-md text-md">
                                Author No.{{ $article_user->pivot->number }}
                            </div>
                            <div class="mb-1">
                                @if(($key + 1) == count($record?->article_journal_users))
                                <x-button class="ml-2 bg-[#3180b5]">
                                    <svg class="h-4 w-4 text-gray-200"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                    </svg>
                                </x-button>
                                @else
                                <x-button class="ml-2" wire:click="changeOrder({{ $article_user->pivot }}, 'down')">
                                    <svg class="h-4 w-4 text-gray-200"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                    </svg>
                                </x-button>
                                @endif
                            </div>
                            <div class="mb-1">
                                @if(($key + 1) == 1)
                                <x-button class="ml-2 bg-[#3180b5]"  >
                                    <svg class="h-4 w-4 text-gray-200"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                    </svg>
                                </x-button>
                                @else 
                                <x-button class="ml-2" wire:click="changeOrder({{ $article_user->pivot }}, 'up')"  >
                                    <svg class="h-4 w-4 text-gray-200"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                    </svg>
                                </x-button>
                                @endif
                                
                            </div>
                            <div class="mb-1">
                                @if($article_user->pivot->number != 1)
                                <x-button class="ml-2 bg-red-500 hover:bg-red-700 text-xs" wire:click="removeAuthor({{ $article_user->id }})">Remove</x-button>
                                @else
                                <x-button class="ml-2 bg-gray-500 hover:bg-gray-700 text-xs cursor-pointer" disabled >Remove</x-button>
                                @endif
                            </div>
                        </div>
                        @endforeach 
                    </div>
                    @endif
                </div>
            </div>

            <div class="w-full @if($step != 2) hidden  @endif">
                <div class="grid grid-cols-12 gap-2">
                    
                    <div class="mt-4 col-span-3">
                        <x-label for="file_attachment" value="File" class="mb-1 block font-medium text-sm text-gray-700" />
                        <x-input-file wire:model="file_attachment" id="file_attachment" />
                        <x-input-error for="file_attachment" />
                    </div>
                    <div class="mt-4 col-span-8">
                        <x-label for="file_category_id" value="File Category" class="mb-1 block font-medium text-sm text-gray-700" />
                        <x-select wire:model="file_category_id" id="file_category_id" class="w-full" :options="$file_categories" />
                        <x-input-error for="file_category_id" />
                    </div>
                    <div class="mt-4 flex text-right">
                        <button class="mt-6 w-full bg-green-500 hover:bg-green-700 text-white p-2 rounded-md shadow font-semibold" wire:click="uploadDocument()" >UPLOAD</button>
                    </div>

                </div>

                
                @if(!empty($record?->files))
                    @foreach ($record?->files as $key => $file)
                    
                    <div class="grid grid-cols-12 gap-2 w-full mt-2">
                        <div class="col-span-11 grid grid-cols-12 bg-gray-200 rounded-lg ">
                            <div class="col-span-3 items-center  p-2 px-4">
                                {{ $file->file_category->name }}
                            </div>

                            <div class="col-span-8 p-2 px-4">
                                <a href="{{ asset('storage/articles/'.$file->file_path) }}">
                                    <span class="font-bold text-blue-500 hover:text-blue-700 cursor-pointer ml-4 hover:underline">
                                        {{ $file->file_description }}

                                        @if(Storage::exists('articles/'.$file->file_path))({{ round((Storage::size('articles/'.$file->file_path) / 1048576), 2) }} MB)@endif
                                    </span>
                                </a>
                            </div>
                            
                            <div class="col-span-1 p-2 px-4">
                                <span class="font-bold text-red-700 hover:text-red-500 cursor-pointer text-right w-full hover:underline" wire:click="deleteFile({{ $file->id }})" >{{ __('delete') }}</span>
                            </div>
                        </div>
                    </div>

                    @endforeach
                @else
                    <div class="w-full p-2 mt-6 bg-gray-200 rounded-lg text-center">
                        No File(s) Uploaded
                    </div>
                @endif

            </div>

            <div class="w-full @if($step != 3) hidden  @endif">
                <div class="mb-6">
                    @foreach ($confirmations as $key => $confirmation)
                        <div class="w-full flex p-2 border-b">
                            <div class="w-11/12 text-justify text-sm">
                                {!! $confirmation->description !!}
                                <x-input-error for="confirmed.{{ $confirmation->id }}" />
                            </div>
                            <div class="flex w-1/12 items-start justify-center">
                                
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" wire:model="confirmed.{{ $confirmation->id }}">
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300  rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                                
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-12 gap-2">
                    <div class="col-span-3 mt-4" >
                        <x-label for="figures" value="Number of Figures" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input type="number" id="figures" class="w-full" wire:model="figures" placeholder="Enter Numer of Figures" />
                        <x-input-error for="figures" />
                    </div>
                    <div class="col-span-3 mt-4" >
                        <x-label for="tables" value="Numer of Tables" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input type="number" id="tables" class="w-full" wire:model="tables" placeholder="Enter Numer of tables" />
                        <x-input-error for="tables" />
                    </div>
                    <div class="col-span-3 mt-4" >
                        <x-label for="words" value="Number of Words" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input type="number" id="words" class="w-full" wire:model="words" placeholder="Enter Number of Words" />
                        <x-input-error for="words" />
                    </div>
                    <div class="col-span-3 mt-4" >
                        <x-label for="pages" value="Number of Pages" class="mb-2 block font-medium text-sm text-gray-700" />
                        <x-input type="number" id="pages" class="w-full" wire:model="pages" placeholder="Enter Number of Pages" />
                        <x-input-error for="pages" />
                    </div>
                </div>
            </div>

            <div class="w-full @if($step != 4) hidden  @endif">
                <div class="flex gap-2">
                    <div class="flex items-center w-2/12 font-bold"> 
                        @if (!empty($title))
                            <svg class="h-4 w-4 text-green-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 12l5 5l10 -10" /></svg>
                        @else
                            <svg class="h-4 w-4 text-red-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="18" y1="6" x2="6" y2="18" />  <line x1="6" y1="6" x2="18" y2="18" /></svg>
                        @endif
                        Article Title
                    </div>
                    <div class="w-full"> : {{ $title }} </div>
                </div>

                <div class="flex gap-2">
                    <div class="flex items-center w-2/12 font-bold">
                        @if (!empty($article_type?->name))
                            <svg class="h-4 w-4 text-green-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 12l5 5l10 -10" /></svg>
                        @else
                            <svg class="h-4 w-4 text-red-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="18" y1="6" x2="6" y2="18" />  <line x1="6" y1="6" x2="18" y2="18" /></svg>
                        @endif
                        Article Type
                    </div>
                    <div class="w-full"> : {{ $article_type?->name }} </div>
                </div>

                <div class="flex gap-2">
                    <div class="flex items-center w-2/12 font-bold">
                        @if (!empty($country?->name))
                            <svg class="h-4 w-4 text-green-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 12l5 5l10 -10" /></svg>
                        @else
                            <svg class="h-4 w-4 text-red-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="18" y1="6" x2="6" y2="18" />  <line x1="6" y1="6" x2="18" y2="18" /></svg>
                        @endif 
                        Country of Origin
                    </div>
                    <div class="w-full"> : {{ $country?->name }} </div>
                </div>

                <div class="flex items-center font-bold"> 
                    @if (!empty($abstract))
                        <svg class="h-4 w-4 text-green-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 12l5 5l10 -10" /></svg>
                    @else
                        <svg class="h-4 w-4 text-red-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="18" y1="6" x2="6" y2="18" />  <line x1="6" y1="6" x2="18" y2="18" /></svg>
                    @endif 
                    Abstract 
                </div>
                <div class="w-full p-4 text-justify"> {!! $abstract !!} </div>

                <div class="flex items-center font-bold"> 
                    @if (!empty($keywords))
                        <svg class="h-4 w-4 text-green-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 12l5 5l10 -10" /></svg>
                    @else
                        <svg class="h-4 w-4 text-red-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="18" y1="6" x2="6" y2="18" />  <line x1="6" y1="6" x2="18" y2="18" /></svg>
                    @endif 
                    Keywords
                </div>
                <div class="w-full p-4 flex flex-wrap gap-2">
                    @php
                        $_keywords = explode(',', $keywords);
                    @endphp
                    @foreach ($_keywords as $key => $keyword)
                        <span class="shadow px-4 py-2 hover:bg-gray-100 cursor-pointer border rounded-xl"> {{ $keyword }} </span>
                    @endforeach
                </div>

                <div class="flex items-center font-bold">
                    @if (!empty($areas))
                        <svg class="h-4 w-4 text-green-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 12l5 5l10 -10" /></svg>
                    @else
                        <svg class="h-4 w-4 text-red-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="18" y1="6" x2="6" y2="18" />  <line x1="6" y1="6" x2="18" y2="18" /></svg>
                    @endif 
                    Areas
                </div>
                <div class="w-full p-4 flex flex-wrap gap-2">
                    @php
                        $_areas = explode(',', $areas);
                    @endphp
                    @foreach ($_areas as $key => $area)
                        <span class="shadow px-4 py-2 hover:bg-gray-100 cursor-pointer border rounded-xl"> {{ $area }} </span>
                    @endforeach
                </div>

                <div class="w-full p-4">
                    <div class="flex items-center font-bold">
                        Authors List
                    </div>

                    <div>
                        @if(!empty($record?->article_journal_users))
                        <div class="mt-6 w-full">
                            @foreach ($record->article_journal_users()->orderBy('number', 'ASC')->get() as $key => $article_user)
                            <div class="flex items-center">
                                <div class="w-full border bg-gray-200 hover:bg-gray-300 border-slate-200 p-1 px-2 mb-1 rounded-md">
                                    {{ $article_user->user->first_name }}
                                    {{ $article_user->user->middle_name }}
                                    {{ $article_user->user->last_name }}.
                        
                                    @if($article_user->user->affiliation) ({{ $article_user->user->affiliation }}) @endif
                                </div>
                            </div>
                            @endforeach 
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="w-full p-4 flex flex-wrap gap-2">
                    <div class="flex items-center font-bold">
                        Uploaded Files
                    </div>

                    @if($record?->files()->pluck('file_category_id')->toArray())
                        @foreach ($filecategories as $key => $file)

                        @php
                            $file_doc = $record->files()->where('file_category_id', $file->id)->first();
                        @endphp
                        
                        <div class="flex gap-2 w-full items-center bg-gray-200 rounded-lg"> 
                            <div class="flex flex-1 items-center w-full p-2">
                                @if (in_array($file->id, $record?->files()->pluck('file_category_id')->toArray()))
                                    <svg class="h-4 w-4 text-green-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 12l5 5l10 -10" /></svg>
                                @else
                                    <svg class="h-4 w-4 text-red-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="18" y1="6" x2="6" y2="18" />  <line x1="6" y1="6" x2="18" y2="18" /></svg>
                                @endif
                                <span class="ml-2">{{ $file->name }}</span>
                            </div>
                            <div class="flex-1 items-center justify-end">
                                <a href="{{ asset('storage/articles/'.$file->file_path) }}">
                                    <span class="font-bold text-blue-500 hover:text-blue-700 cursor-pointer ml-4 hover:underline">
                                        {{ $file_doc?->file_description }}

                                        
                                        @if(Storage::exists('articles/'.$file_doc?->file_path) && $file_doc?->file_path != '')({{ round((Storage::size('articles/'.$file_doc?->file_path) / 1048576), 2) }} MB)@endif
                                    </span>
                                </a>
                            </div>
                        </div>

                        @endforeach
                    @else
                        <div class="w-full p-2 mt-6 bg-gray-200 rounded-lg text-center">
                            No File(s) Uploaded
                        </div>
                    @endif
                </div>

                <div class="w-full p-4 flex flex-wrap gap-2">
                    <div class="flex items-center font-bold">
                        Submission Confirmation Checklist
                    </div>

                    @foreach ($confirmations as $key => $confirmation)
                        <div class="w-full flex p-2 border-b">
                            <div class="w-11/12 text-justify text-sm">{!! $confirmation->description !!}</div>
                            <div class="flex w-1/12 items-start justify-center">

                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="1" class="sr-only peer" wire:model="confirmed.{{ $confirmation->id }}" disabled>
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300  rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
            
                            </div>
                        </div>
                    @endforeach
                </div>
                

                <div class="flex gap-2 justify-between w-full mt-4">
                    <div class="bg-gray-200 w-full p-2 rounded shadow">
                        <div class="flex items-center font-bold"> 
                            @if (!empty($figures))
                                <svg class="h-4 w-4 text-green-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 12l5 5l10 -10" /></svg>
                            @else
                                <svg class="h-4 w-4 text-red-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="18" y1="6" x2="6" y2="18" />  <line x1="6" y1="6" x2="18" y2="18" /></svg>
                            @endif 
                            Figures
                        </div>
                        <div class="ml-4"> {{ $figures }} </div>
                    </div>

                    <div class="bg-gray-200 w-full p-2 rounded shadow">
                        <div class="flex items-center font-bold">
                            @if (!empty($tables))
                                <svg class="h-4 w-4 text-green-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 12l5 5l10 -10" /></svg>
                            @else
                                <svg class="h-4 w-4 text-red-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="18" y1="6" x2="6" y2="18" />  <line x1="6" y1="6" x2="18" y2="18" /></svg>
                            @endif 
                            Tables 
                        </div>
                        <div class="ml-4"> {{ $tables }} </div>
                    </div>

                    <div class="bg-gray-200 w-full p-2 rounded shadow">
                        <div class="flex items-center font-bold"> 
                            @if (!empty($words))
                                <svg class="h-4 w-4 text-green-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 12l5 5l10 -10" /></svg>
                            @else
                                <svg class="h-4 w-4 text-red-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="18" y1="6" x2="6" y2="18" />  <line x1="6" y1="6" x2="18" y2="18" /></svg>
                            @endif 
                            Words 
                        </div>
                        <div class="ml-4"> {{ $words }} </div>
                    </div>

                    <div class="bg-gray-200 w-full p-2 rounded shadow">
                        <div class="flex items-center font-bold"> 
                            @if (!empty($pages))
                                <svg class="h-4 w-4 text-green-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 12l5 5l10 -10" /></svg>
                            @else
                                <svg class="h-4 w-4 text-red-600"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="18" y1="6" x2="6" y2="18" />  <line x1="6" y1="6" x2="18" y2="18" /></svg>
                            @endif 
                            Pages 
                        </div>
                        <div class="ml-4"> {{ $pages }} </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex justify-between mt-6">
            <button wire:click="decrementStep" class="bg-gray-500 text-white px-4 py-2 rounded {{ $step == 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $step == 1 ? 'disabled' : '' }}>Previous</button>
            <button wire:click="incrementStep" class="bg-[#175883] text-white px-4 py-2 rounded {{ $step == 4 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $step == 4 ? 'disabled' : '' }}>Next Step</button>
        </div>

        <div class="mt-4 text-center">
            @if(!empty($record) && ($record?->article_status?->code == '001' || $record?->article_status?->code == '005' || $record?->article_status?->code == '004'))

                <x-button type="submit" wire:click="update('{{ $record?->article_status?->code }}')" wire:loading.attr="disabled">
                    {{ __('Save & Submit Later') }}
                </x-button>

                @if ($record->author?->id == auth()->user()->id && $step == 4)

                    @if ($record?->article_status?->code == '001' || $record?->article_status?->code == '004')
                        <x-button class="bg-green-700 hover:bg-green-600" type="submit" wire:click="update('002')" wire:loading.attr="disabled">
                            {{ __('Save & Submit') }}
                        </x-button>
                    @endif

                    @if ($record?->article_status?->code == '005')
                        <x-button class="bg-green-700 hover:bg-green-600" type="submit" wire:click="update('006')" wire:loading.attr="disabled">
                            {{ __('Save & Submit') }}
                        </x-button>
                    @endif

                @endif
                
            @elseif(empty($record))
        
                <x-button type="submit" wire:click="store('001')" wire:loading.attr="disabled">
                    {{ __('Save & Submit Later') }}
                </x-button>

                @if ($step == 4)
                    <x-button class="bg-green-700 hover:bg-green-600" type="submit" wire:click="store('002')" wire:loading.attr="disabled">
                        {{ __('Save & Submit') }}
                    </x-button>
                @endif

            @elseif(!empty($record) && ($record?->article_status?->code == '019' || $record?->article_status?->code == '020'))
                
                <x-button type="submit" wire:click="store('005')" wire:loading.attr="disabled">
                    {{ __('Save & Resubmit Later') }}
                </x-button>

                @if ($step == 4)
                    <x-button class="bg-green-700 hover:bg-green-600" type="submit" wire:click="store('006')" wire:loading.attr="disabled">
                        {{ __('Save & Resubmit') }}
                    </x-button>
                @endif

            @endif
        </div>
    </div>


    <x-dialog-modal wire:model="create_juser">
        <x-slot name="title">
            {{ __('Create New Author') }}
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-2 gap-2">
                <div class="mt-4">
                    <x-label for="juser_title" value="Title" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="juser_title" class="w-full" :options="$salutations" wire:model="juser_salutation_id" />
                    <x-input-error for="juser_title" />
                </div>

                <div class="mt-4">
                    <x-label for="juser_gender" value="Gender" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="juser_gender" class="w-full" :options="['Male' => 'Male', 'Female' => 'Female']" wire:model="juser_gender" />
                    <x-input-error for="juser_gender" />
                </div>
            </div>
                
            <div class="mt-4">
                <x-label for="juser_lname" value="Last Name" class="mb-2 block font-medium text-sm text-gray-700" />
                <x-input type="text" id="juser_lname" class="w-full" wire:model="juser_lname" />
                <x-input-error for="juser_lname" />
            </div>
            
            
            <div class="grid grid-cols-2 gap-2">
                <div class="mt-4">
                    <x-label for="juser_fname" value="First Name" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="juser_fname" class="w-full" wire:model="juser_fname" />
                    <x-input-error for="juser_fname" />
                </div>
                <div class="mt-4">
                    <x-label for="juser_mname" value="Middle Name" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="juser_mname" class="w-full" wire:model="juser_mname" />
                    <x-input-error for="juser_mname" />
                </div>
            </div>

            <div class="grid grid-cols-2 space-x-2">
                <div class="mt-4">
                    <x-label for="juser_email" value="Email" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="juser_email" class="w-full" wire:model="juser_email" />
                    <x-input-error for="juser_email" />
                </div>
                <div class="mt-4">
                    <x-label for="juser_phone" value="Phone" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="juser_phone" class="w-full" wire:model="juser_phone" />
                    <x-input-error for="juser_phone" />
                </div>
            </div>

            <div class="grid grid-cols-2 space-x-2">
                <div class="mt-4">
                    <x-label for="juser_affiliation" value="Affiliation" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-input type="text" id="juser_affiliation" class="w-full" wire:model="juser_affiliation" />
                    <x-input-error for="juser_affiliation" />
                </div>
                <div class="mt-4">
                    <x-label for="juser_country_id" value="Country" class="mb-2 block font-medium text-sm text-gray-700" />
                    <x-select id="juser_country_id" class="w-full" :options="$countries" wire:model="juser_country_id" />
                    <x-input-error for="juser_country_id" />
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            
            <x-button type="submit" wire:click="storeJuser()" wire:loading.attr="disabled">
                {{ __('Submit') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('create_juser')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>
 
</div>

<script>
    window.addEventListener('contentChangedx', (e) => {
        tinymce.remove('#abstract');
        tinymce.init({
            selector: '#abstract',
            plugins: 'code advlist lists table link',
            
            height: 400,
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
                    @this.set('abstract', editor.getContent());
                });
            },
        });
    });

</script>