<div>
    <div class="bg-white shadow-md p-4 rounded-t">
        <div class="w-full grid grid-cols-3 gap-4" >
            <div class="">
                <p class="font-bold text-xl">{{ __('DASHBOARD') }}</p>
            </div>
            <div class="col-span-2 flex gap-2 justify-end">
                <x-input wire:model.live.debounce.500ms="query" placeholder="Search Journal..." type="search" />
            </div>
        </div>
    </div>

    @if(auth()->user()->hasPermissionTo('View Dashboard'))
        <div class="bg-white shadow-md rounded-b">
            @foreach ($journals as $data)
                <div class="border-b">
                    <p class="p-4 font-bold cursor-pointer text-lg hover:text-blue-600" wire:click="setJournal('{{ $data->uuid }}')">{{ $data->title }} - {{ strtoupper($data->code) }}</p>
                    
                    <div class="flex flex-wrap">
                        @foreach ($statuses as $status)
                            <div class="w-1/4 text-xs text-gray-600 font-light border-r px-4 py-4 flex">
                                @php
                                    $article_count = $status->articles()->where('journal_id', $data->id)->count();
                                @endphp

                                @if($article_count > 0)
                                    <p class="w-full cursor-pointer hover:text-blue-600" wire:click="filterArticles('{{ $data->uuid }}', '{{ $status->id }}')">{{ $status->name }}</p>
                                    <span class="text-right font-bold cursor-pointer hover:text-blue-600" wire:click="filterArticles('{{ $data->uuid }}', '{{ $status->id }}')">
                                        {{ $article_count }}
                                    </span>
                                @else
                                    <p class="w-full cursor-pointer" >{{ $status->name }}</p>
                                    <span class="text-right font-bold cursor-pointer">
                                        {{ $article_count }}
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="{{ $data->uuid == $currentJournal ? 'block' : 'hidden' }} bg-gray-100">
                    
                    <table class="min-w-full text-left text-sm font-light">
                        <thead class="border-b font-medium grey:border-neutral-500">
                            <tr>
                                <th scope="col" class="px-6 py-4 w-2">#</th>
                                <th scope="col" class="px-6 py-4 ">
                                    <button wire:click="sort('title')" >Title</button>
                                    <x-sort-icon class="float-right" sortField="title" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                                </th>
                                <th scope="col" class="px-6 py-4 w-2">Paper Id</th>
                                <th scope="col" class="px-6 py-4 w-2">Due Date</th>
                                <th scope="col" class="px-6 py-4 w-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sn = 1;
                            @endphp
                            @foreach ($data->articles as $article)
                
                            <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 grey:border-neutral-500 grey:hover:bg-neutral-600">
                                <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $sn }}</td>
                                <td class="whitespace-normal px-6 py-3 break-words">
                                    
                                    <a href="{{ route('journals.article', $article->uuid) }}" class="block px-4 py-2 hover:bg-gray-100 text-blue-500 hover:text-blue-700 cursor-pointer" wire:loading.attr="disabled">{{ $article->title }}</a>

                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ $article->paper_id }}
                                </td>
                                
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ $article->deadline }}

                                    @if ($article->deadlineDays())
                                        @if ($article->deadlineDays() > 0)
                                            <span class="text-green-500 font-bold">
                                                {{ '('.$article->deadlineDays().' Days to Overdue)' }}
                                            </span>
                                        @else
                                            <span class="text-red-500 font-bold">
                                                {{ '(Overdue For '.abs($article->deadlineDays()).' Days)' }}
                                            </span>
                                        @endif
                                    @endif
                                    
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="px-2 text-[12px] text-center rounded" style="{{ $article->article_status->color }}">
                                        {{ $article->article_status->name }}
                                    </div>
                                </td>
                                
                            </tr>
                            
                            @php
                                $sn++;
                            @endphp
                            @endforeach
                        
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-lg font-semibold text-gray-600">You dont have permission to view this page</p>
    @endif
</div>