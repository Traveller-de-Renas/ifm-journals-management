<div class="w-full">
    <div class="bg-gray-800 text-white py-12 bg-blend-overlay" style="background-image: url({{ asset('images/auth-image.jpg') }}); background-position: top;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <p class="text-4xl font-bold mb-4">{{ __('JOURNALS') }} </p>

            <p class="text-2xl font-bold">Publish in a journal</p>

            <div class="w-full md:grid md:grid-cols-3 gap-4" >
                <p class="col-span-2 text-justify">
                    Choose which journal to publish in or search our active calls for papers. When you're ready, find out&nbsp;how to submit your paper.&nbsp;
                    <br>
                    <br>
                    
                    Use our search to find your chosen journal and find out what is required to submit your paper in the author guidelines. You will then submit your paper online.&nbsp;You can only submit your paper to one journal at a time. Follow the guide to publishing your paper and find resources to support you. Our journal publishing guide/infographic will help you understand each step, from submission to publication.
                </p>
            </div>

            <div class="w-full md:grid md:grid-cols-3 gap-4 mt-6 mb-4" >
                <div class="">
                    <x-input class="w-full text-gray-700" wire:model.live.debounce.500ms="query" placeholder="search..." type="search" />
                </div>
                <div class=""></div>
                <div class="flex justify-end text-right">
                    
                    <x-button class="flex gap-2 items-center" wire:click="$toggle('filters')" >
                        
                        <svg class="h-3 w-3 text-white"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <span>Filter Journals</span>
                          
                    </x-button>
                </div>
            </div>

        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 mb-8">

        <div class="mb-4 {{ $filters ? '' : 'hidden' }}">
            <div class="bg-white border rounded p-2 shadow-sm">
                <div class="text-sm text-slate-800 font-bold">Subjects</div>
                <ul class="cbfhc">

                    @foreach ($subjects as $key => $subject)
                        <li>
                            <label class="flex items-center">
                                <input type="checkbox" class="" wire:click="checkOption('subjects', {{ $subject->id }})" value="{{ $subject->id }}">
                                <span class="text-sm ml-2">{{ $subject->name }}</span>
                            </label>
                        </li>
                    @endforeach
                    
                </ul>

                <div class="text-sm text-slate-800 font-bold mt-6">Categories</div>
                <ul class="cbfhc">

                    @foreach ($categories as $key => $categ)
                        <li>
                            <label class="flex items-center">
                                <input type="checkbox" class="" wire:click="checkOption('categories', {{ $categ->id }})" value="{{ $categ->id }}">
                                <span class="text-sm ml-2">{{ $categ->name }}</span>
                            </label>
                        </li>
                    @endforeach
                    
                </ul>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-4 w-full">
            
            <div class="col-span-12">
                @foreach ($data as $row)
                    <div class="border border-slate-200 p-4 shadow-md mb-8 rounded-md w-full">
                        
                        <div class="flex gap-4 items-top">
                            <div class="w-2/12">
                                @if($row->image == '')
                                    <svg class="w-8 h-8 text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                        <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/>
                                    </svg>
                                @else
                                    <img class="w-full" src="{{ asset('storage/journals/'.$row->image) }}" alt="{{ strtoupper($row->code) }}">
                                @endif
                            </div>
                            <div class="w-full">
                                <a href="{{ route('journal.detail', $row->uuid) }}">
                                <p class="text-lg font-bold text-blue-700 hover:text-blue-600 cursor-pointer"> {{ $row->title }} ({{ strtoupper($row->code) }})</p>
                                </a>

                                <div class="text-sm text-slate-800 mb-6">
                                    <p class="text-justify">{!! $row->description !!}</p>
                                </div>
            
                                <a href="{{ route('journal.detail', $row->uuid) }}">
                                    <x-button>Preview</x-button>
                                </a>

                                <a href="{{ route('register', $row->uuid) }}" class="">
                                    <x-button>Register </x-button>
                                </a>
            
                                
                            </div>
                        </div>

                        

                    </div>
                @endforeach

                {{ $data->links() }}
            </div>
        </div>

    </div>

    <x-dialog-modal wire:model="signupModal">
        <x-slot name="title">
            {{ __('Delete Data') }}
        </x-slot>
        <x-slot name="content">
            <div class="mt-4">
                <p class="text-center">Are you sure you want to sign up for the journal.?</p>
                <p class="text-center font-bold text-blue-700">{{ $journal?->title }}</p>
            </div>
        </x-slot>
        <x-slot name="footer">
            
            <x-button type="submit" wire:click="confirmSignUp()" wire:loading.attr="disabled" >
                {{ __('Confirm') }}
            </x-button>
            <x-secondary-button class="ml-3" wire:click="$toggle('Edit')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

        </x-slot>
    </x-dialog-modal>

</div>