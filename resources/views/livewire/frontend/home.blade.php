<div>
    <div class="relative" wire:ignore >
        <div id="default-carousel" class="relative w-full" data-carousel="slide">
            <!-- Carousel wrapper -->
            <div class="relative h-86 overflow-hidden h-[170px] md:h-dvh md:max-h-[620px]">
                @if(!empty($sliding_image))
                    @foreach ($sliding_image as $image)
                        @if($image->url != "") <a href="{{ $image->url }}" target="_blank"> @endif
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('storage/slider/'.$image->image) }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 h-full" alt="...">
                        </div>
                        @if($image->url != "") </a> @endif
                    @endforeach
                @endif
            </div>
            
            <!-- Slider controls -->
            <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30  group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                    <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30  group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                    <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
    </div>

    <div class="bg-[#175883] p-4">
        <label class="relative block">
            <span class="sr-only">Search</span>
            <span class="absolute inset-y-0 left-0 flex items-center pl-2 pr-2">
                <svg class="h-6 w-6 text-[#175883]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"  stroke-linejoin="round">  <circle cx="11" cy="11" r="8" />  <line x1="21" y1="21" x2="16.65" y2="16.65" /></svg>
            </span>
            <input class="placeholder:text-[#175883] placeholder:text-xl placeholder:text-bold block bg-white w-full border border-slate-300 rounded-md py-2 pl-9 pr-3 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 p-4" placeholder="Find a Journal Here..." type="text" wire:model="search" wire:keyup="searchJournal($event.target.value)" />
        </label>
    </div>

    <div class="absolute w-full shadow-md">
        <div class="bg-white z-20 relative w-full">
                
            @if (count($all_journals) > 0 && $search != '')
                @foreach ($all_journals as $one_journal)
                    <a href="{{ route('journal.detail', $one_journal->uuid) }}">
                        <div class="border-b p-4 text-[#175883] hover:bg-[#175883] hover:text-white cursor-pointer">{{ $one_journal->title }} ({{ strtoupper($one_journal->code) }})</div>
                    </a>
                @endforeach
            @endif
            
        </div>
    </div>

    <div class="w-full py-16 mb-6 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 ">
                IFM JOURNALS
            </h5>
            <div class="mb-6 text-justify">
                Welcome to the IFM Journals platform, your gateway to accessing high-quality academic and research publications. Whether you are looking to explore the latest research, respond to active calls for papers, or find the right journal for your work, our platform provides the tools and resources to support you.<br><br>
            We are committed to fostering academic excellence by offering engaging experience for researchers, authors, and readers. Our platform hosts three distinguished journals edited by the Institute of Finance Management (IFM): the Journal of Finance and Business Studies (JFBS), the Journal of Innovation and Social Science Research (JISSR),and the African Journal of Finance and Management (AJFM). Browse our journals, stay informed with recent publications, and contribute to advancing knowledge in your field.

            </div>

            <div class="md:grid md:grid-cols-12 gap-6">


                <div class="col-span-4 p-6 bg-white border border-gray-200 rounded-lg shadow  mb-4">
                    <a href="#">
                        <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 text-center">PEER REVIEW PROCESS</h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-500 text-sm text-justify">
                        Our double-anonymous peer review process ensures objectivity, as authors and reviewers remain anonymous to each other. We follow a rigorous review system to uphold the quality, credibility, and originality of published research.
                    </p>
                    <a href="{{ route('journal.peer_review_process') }}" >
                        <p class="inline-flex font-medium items-center text-blue-600 hover:underline text-center">Read More</p>
                    </a>
                </div>


                <div class="col-span-4 p-6 bg-white border border-gray-200 rounded-lg shadow  mb-4">
                    <a href="#">
                        <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 text-center">ONLINE SUBMISSION</h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-500 text-sm text-justify">
                        We enable you to submit your manuscript online in any of our journals that are related to your manuscript. Make sure you follow all guidelines provided by specific journal.
                    </p>
                    <a href="{{ route('journal.viewall') }}" >
                        <p class="inline-flex font-medium items-center text-blue-600 hover:underline text-center">Find Journal</p>
                        
                    </a>
                </div>
        
        
                
        
            
                <div class="col-span-4 p-6 bg-white border border-gray-200 rounded-lg shadow  mb-4">
                    <a href="#">
                        <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 text-center">PUBLISH WITH US</h5>
                    </a>
                    <p class="mb-3 col-span-4 font-normal text-gray-500 text-sm text-justify">Publish with us your research across our journals, books, teaching cases and open access options. Follow our guides and find the resources to help you submit, publish and promote your work.</p>
                    <a href="{{ route('journal.viewall') }}" >
                        <p class="inline-flex font-medium items-center text-blue-600 hover:underline text-center w-full">Journals</p>
                        
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-12 w-full rounded-r-lg shadow">

                <div class="col-span-4">
                    <img class="object-cover object-center w-full h-full" src="{{ asset('images/auth-image.jpg') }}" width="760" height="1024" alt="Authentication image" />
                </div>

                <div class="col-span-8 p-6 bg-white border border-gray-200 rounded-r-lg ">
                    <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 ">CALL FOR PAPERS</h5>
                    <p class="font-normal text-sm text-gray-500">
                        Here are the latest calls for papers and special issues from our extensive journal and case study range.
                    </p>
                    <a href="{{ route('journal.callfor_paper') }}" >
                        <p class="inline-flex font-medium items-center text-blue-600 hover:underline text-center w-full">Calls for papers </p>
                    </a>

                </div>

            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <p class="font-bold text-xl md:text-[32px] drop-shadow-lg text-center w-full">LATEST JOURNAL ISSUE RELEASES</p>
        <p class="text-center text-sm mt-2">Get Latest Journal Issue Releases from the Institute of Finance Management</p>

        <div class="md:grid grid-cols-12 md:gap-6 mt-10">
            @foreach ($journals as $journal)
                <div class="col-span-4 overflow-hidden mb-8 hover:shadow-lg bg-gray-200 border border-gray-200 rounded-lg">
                    <a href="{{ route('journal.detail', $journal->uuid) }}">
                        <div class="flex justify-center min-w-40 bg-white ">
                            @if($journal->image == '')
                                <img class="max-h-[400px] lg:max-h-[250px] min-w-40 bg-gray-200" src="{{ asset('storage/favicon/placeholder-image.png') }}" width="40" height="40" alt="{{ $journal->code }}">
                            @else
                                <img class="max-h-[400px] lg:max-h-[250px] min-w-40 " src="{{ asset('storage/journals/'.$journal->image) }}" width="40" height="40" alt="{{ $journal->code }}">
                            @endif
                        </div>
                        <div class="p-5">
                            <p class="mb-2 text-md text-center font-bold tracking-tight text-gray-900">{{ Str::words(strtoupper($journal?->title), '15'); }} ({{ strtoupper($journal?->code) }})</p>
                            
                            <div class="flex text-sm items-center justify-center">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z"/>
                                </svg>
                                <p class="ml-2 text-sm text-gray-500">{{ $journal->created_at }}</p>
                            </div>

                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('journal.viewall') }}" class="inline-flex p-3 px-24 text-white bg-[#175883] rounded hover:bg-[#176183]">
                <p class="w-full text-center">View More Journals</p>
            </a>
        </div>
    </div>





    <div class="max-w-7xl mx-auto mt-12 p-6">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-4 w-full p-6 bg-white border border-gray-200 rounded-lg shadow mb-4 text-center">
                <a href="#">
                    <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900">Journals</h5>
                </a>
                <p class="font-bold text-gray-500 text-center">
                    {{ $journals_count }}
                </p>
            </div>

            <div class="col-span-4 w-full p-6 bg-white border border-gray-200 rounded-lg shadow mb-4 text-center">
                <a href="#">
                    <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900">Issues </h5>
                </a>
                <p class="font-bold text-gray-500 text-center">
                    {{ $issues_count }}
                </p>
            </div>

            <div class="col-span-4 w-full p-6 bg-white border border-gray-200 rounded-lg shadow mb-4 text-center">
                <a href="#">
                    <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900">Articles </h5>
                </a>
                <p class="font-bold text-gray-500 text-center">
                    {{ $articles_count }}
                </p>
            </div>
        </div>
    </div>
</div>
