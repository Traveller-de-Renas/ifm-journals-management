<div class="w-full">
    <div class="bg-gray-800 text-white py-12 bg-blend-overlay" style="background-image: url({{ asset('images/auth-image.jpg') }}); background-position: top;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <p class="text-4xl font-bold mb-4">{{ __('PEER REVIEW PROCESS') }} </p>

            <p class="text-2xl font-bold"></p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 mb-8 text-justify">
        Our double-anonymous peer review process ensures objectivity, as authors and reviewers remain anonymous to each other. We follow a rigorous review system to uphold the quality, credibility, and originality of published research.

        <br>
        <br>
        Each submitted manuscript undergoes an initial editorial screening to check for compliance with ethical standards and manuscript preparation guidelines. If suitable, the manuscript proceeds to peer review, where a minimum of two independent experts evaluate its coherence and structure, methodology and findings, originality, comprehensiveness, and relevance to current literature.

        <br>
        <br>
        Authors are required to revise their work based on reviewer feedback before final acceptance. Reviewers play a vital role in maintaining scholarly standards, and we encourage them to refer to our Reviewer’s Guide for detailed instructions. This structured process ensures the integrity of academic publishing and contributes to the advancement of knowledge.

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
