@props(['sortBy', 'sortAsc', 'sortField'])

@if($sortBy == $sortField)
    @if($sortAsc)
    <span class="w-4 h-4 ml-2 float-right ">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3 ">
            <path fill-rule="evenodd" d="M10 2a.75.75 0 01.75.75v12.59l1.95-2.1a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 111.1-1.02l1.95 2.1V2.75A.75.75 0 0110 2z" clip-rule="evenodd" />
        </svg>          
    </span>
    @endif
    @if(!$sortAsc)
    <span class="w-4 h-4 ml-2 float-right ">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3 ">
            <path fill-rule="evenodd" d="M10 18a.75.75 0 01-.75-.75V4.66L7.3 6.76a.75.75 0 11-1.1-1.02l3.25-3.5a.75.75 0 011.1 0l3.25 3.5a.75.75 0 01-1.1 1.02l-1.95-2.1v12.59A.75.75 0 0110 18z" clip-rule="evenodd" />
        </svg>
    </span>
    @endif
@endif