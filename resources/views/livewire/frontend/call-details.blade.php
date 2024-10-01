<x-module>

    

            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-2">
                    @if($record->image == '')
                        <div class="p-2 ">
                            <svg class="w-full bg-slate-300 rounded-xl text-white dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"/>
                            </svg>
                        </div>
                    @else
                        <img class="w-full rounded-md rounded-bl-md" src="{{ asset('storage/journals/'.$record->image) }}" width="40" height="40" alt="{{ $record->code }}">
                    @endif
                </div>
                <div class="col-span-10">
                    <h5 class="text-left text-2xl font-bold text-gray-900 dark:text-white">{{ $record->title }}</h5>
                    <p>Start Date : {{ $record->start_date }}</p>
                    <p>End Date : {{ $record->start_date }}</p>
                </div>
            </div>

            <div class="border-t mb-2"></div>
            
            <span class="text-sm text-gray-500 dark:text-gray-400">{!! $record->description !!}</span>

</x-module>