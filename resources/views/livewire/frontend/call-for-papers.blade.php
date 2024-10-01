<x-module>
    <x-slot name="title">
        {{ __('CALL FOR PAPERS') }}
    </x-slot>
 
    <div class="w-full md:grid md:grid-cols-3 gap-4 mb-4" >
        <div class="">
            <x-input wire:model.live.debounce.500ms="query" placeholder="search..." type="search" />
        </div>
        <div class=""></div>
    </div>

    <div class="grid grid-cols-12 gap-4 w-full">
        <div class="col-span-3">
            <div class="bg-white border rounded p-2 shadow-sm">



            <div class="text-sm text-slate-800 font-bold dark:text-slate-100">Categories</div>
            <ul class="cbfhc">

                {{-- @foreach ($categories as $key => $categ) --}}
                    <li>
                        <label class="flex items-center">
                            <input type="checkbox" class="cybz1">
                            <span class="text-sm ch1ih c6w4h cw92y c9o7o ml-2">Journals</span>
                        </label>
                    </li>

                    <li>
                        <label class="flex items-center">
                            <input type="checkbox" class="cybz1">
                            <span class="text-sm ch1ih c6w4h cw92y c9o7o ml-2">Issues</span>
                        </label>
                    </li>
                {{-- @endforeach --}}
                
            </ul>
        </div>
        </div>
        <div class="col-span-9">
            @foreach ($call as $row)
                <div class="border border-slate-200 dark:border-slate-700 p-4 shadow-md mb-8 rounded-md w-full">
                    
                    <div class="grid grid-cols-12 items-top gap-4">
                        <div class="col-span-2">
                            @if($row->image == '')
                                <svg class="w-full rounded-xl bg-slate-300 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                    <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/>
                                </svg>
                            @else
                                <img class="c7n6y" src="{{ asset('storage/callfor_paper/'.$row->image) }}" width="40" height="40" alt="{{ $row->code }}">
                            @endif
                        </div>
                        <div class="col-span-10">
                            <a href="{{ route('journal.call_detail', $row->uuid) }}">
                            <p class="text-lg font-bold text-blue-700 hover:text-blue-600 cursor-pointer"> {{ $row->title }}</p>
                            </a>
                            <div class="text-sm text-slate-800 dark:text-slate-100 cbfhc cg5st mb-6">
                        <p class="text-justify">{{ Str::words(strip_tags($row->description), '60'); }}</p>
                    </div>
                        </div>
                    </div>

                    
                    <div class="text-right">
                        <a href="{{ route('journal.call_detail', $row->uuid) }}">
                        <x-button>Preview</x-button>
                    </a>
                    </div>
                    

                </div>
            @endforeach

            {{ $call->links() }}
        </div>
    </div>

</x-module>