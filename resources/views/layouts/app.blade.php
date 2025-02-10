<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body *{
                /* font-family: 'Open Sans', sans-serif; */
                font-size: 14px;
            }
        </style>

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased ">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                </svg>
            </button>
 
            <aside id="sidebar-multi-level-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">

                <div class="h-full py-4 overflow-y-auto bg-[#2B579A]">
                    <div class="w-full text-center px-12 py-3">
                        <a href="{{ url('/dashboard') }}" class="" >
                            <center>
                                <img src="{{ asset('storage/logo.png' ) }}" class="max-w-24">
                            </center>
                        </a>
                    </div>

                    @if(in_array(auth()->user()->id, $ceditor) || (auth()->user()->hasRole('Administrator') && session('journal')))
                        <div class="px-4 py-2 text-gray-300"> Editors</div>

                        <ul class="space-y-2 font-medium border-t border-gray-400">
                            <li>
                                <button type="button" class="flex items-center w-full px-4 py-2 text-base text-white hover:text-gray-950 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-a" data-collapse-toggle="dropdown-a">
                                    <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                                        <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                                    </svg>
                                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Submission</span>

                                    @if(($submitted + $resubmitted) > 0)
                                        <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-xs font-medium text-white bg-red-700 rounded-full dark:bg-red-900 dark:text-white ">{{ $submitted + $resubmitted }}</span>
                                    @endif

                                    <svg class="w-3 h-3 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <ul id="dropdown-a" class="hidden py-2 space-y-2">
                                    <li>
                                        <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'submitted']) }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                            
                                            <span class="flex-1 text-left rtl:text-right whitespace-nowrap">New Submission</span>
                                            @if($submitted > 0)
                                                <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-xs font-medium text-white bg-red-700 rounded-full dark:bg-red-900 dark:text-white ">{{ $submitted }}</span>
                                            @endif
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'resubmitted']) }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                            <span class="flex-1 text-left rtl:text-right whitespace-nowrap">Resubmissions</span>
                                            @if($resubmitted > 0)
                                                <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-xs font-medium text-white bg-red-700 rounded-full dark:bg-red-900 dark:text-white ">{{ $resubmitted }}</span>
                                            @endif
                                        </a>
                                    </li>
                                </ul>
                            </li>


                            <li>
                                <button type="button" class="flex items-center w-full px-4 py-2 text-base text-white hover:text-gray-950 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-b" data-collapse-toggle="dropdown-b">
                                    <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                                        <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                                    </svg>
                                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Review</span>

                                    @if(($onreview) > 0)
                                        <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-xs font-medium text-white bg-red-700 rounded-full dark:bg-red-900 dark:text-white ">{{ $onreview }}</span>
                                    @endif

                                    <svg class="w-3 h-3 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <ul id="dropdown-b" class="hidden py-2 space-y-2">
                                    <li>
                                        <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'on_review']) }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                            <span class="flex-1 text-left rtl:text-right whitespace-nowrap">On Review</span>
                                            @if($onreview > 0)
                                                <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-xs font-medium text-white bg-red-700 rounded-full dark:bg-red-900 dark:text-white ">{{ $onreview }}</span>
                                            @endif
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'returned_to_author']) }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Returned to Author</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'rejected']) }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Rejected Paper</a>
                                    </li>
                                </ul>
                            </li>


                            <li>
                                <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'production']) }}" c class="flex items-center px-4 py-2 text-white hover:text-gray-950 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                                        <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                                    </svg>
                                    <span class="ms-3">Production</span>
                                </a>
                            </li>


                            <li>
                                <button type="button" class="flex items-center w-full px-4 py-2 text-base text-white hover:text-gray-950 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-c" data-collapse-toggle="dropdown-c">
                                    <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                                        <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                                    </svg>
                                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Publication</span>
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <ul id="dropdown-c" class="hidden py-2 space-y-2">
                                    <li>
                                        <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'pending_publications']) }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Pending for Publication</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'online_first'])  }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Online First</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('journals.publication', session('journal')) }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Issue Assignment</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'published']) }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Published</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <button type="button" class="flex items-center w-full px-4 py-2 text-base text-white hover:text-gray-950 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-f" data-collapse-toggle="dropdown-f">
                                    <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                                        <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                                    </svg>
                                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Setting</span>
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <ul id="dropdown-f" class="hidden py-2 space-y-2">
                                    
                                    @if(auth()->user()->journal_us()->where('journal_id', $journal->id)->first()->hasRole('Chief Editor'))
                                        <li>
                                            <a href="{{ route('journals.create', session('journal')) }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Journal Details</a>
                                        </li>
                                    @endif
                                    <li>
                                        <a href="{{ route('journals.team', session('journal')) }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Journal Team</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('journals.reviewer', session('journal')) }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Reviewers</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="{{ route('journals.call_for_papers', session('journal')) }}" class="flex items-center px-4 py-2 text-white hover:text-gray-950 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                                        <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                                    </svg>
                                    <span class="ms-3">Call for Papers</span>
                                </a>
                            </li>
                            
                        </ul>
                    @endif
                    

                    <div class="px-4 py-2 text-gray-300 mt-4"> Author</div>

                    <ul class="space-y-2 font-medium border-t border-gray-400">
                        <li>
                            <a href="{{ route('journals.submission', session('journal')) }}" class="flex items-center px-4 py-2 text-white hover:text-gray-950 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                                    <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                                </svg>
                                <span class="ms-3">New Submission</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'pending']) }}" class="flex items-center px-4 py-2 text-white hover:text-gray-950 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                                    <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                                </svg>
                                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Pending</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'onprogress']) }}" class="flex items-center px-4 py-2 text-white hover:text-gray-950 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                                    <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                                </svg>
                                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">On Progress</span>
                            </a>
                        </li>


                        <li>
                            <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'returned']) }}" class="flex items-center px-4 py-2 text-white hover:text-gray-950 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                                    <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                                </svg>
                                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Returned</span>
                                
                                @if($returned > 0)
                                    <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-white bg-red-700 rounded-full dark:bg-red-900 dark:text-white">{{ $returned }}</span>
                                @endif
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'with_decisions']) }}" class="flex items-center px-4 py-2 text-white hover:text-gray-950 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                                    <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                                </svg>
                                <span class="ms-3">Manuscript with Decision</span>
                            </a>
                        </li>
                    </ul>


                    @role('Administrator')

                        <div class="px-4 py-2 text-gray-300 mt-4"> Administrator</div>

                        <ul class="space-y-2 font-medium border-t border-gray-400">
                            {{-- <li>
                                <a href="#" class="flex items-center px-4 py-2 text-white hover:text-gray-950 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <svg class="w-4 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                                    <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                                    <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                                    </svg>
                                    <span class="ms-3">Dashboard</span>
                                </a>
                            </li> --}}
                            <li>
                                <button type="button" class="flex items-center w-full px-4 py-2 text-base text-white hover:text-gray-950 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-d" data-collapse-toggle="dropdown-d">
                                    <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                                        <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                                    </svg>
                                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Journals</span>
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <ul id="dropdown-d" class="hidden py-2 space-y-2">
                                    <li>
                                        <a href="{{ route('journals.index') }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">All Journals</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('journals.subjects') }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Subjects</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('journals.categories') }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Categories</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('journals.review_messages') }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Review Message</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('journals.review_sections') }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Review Sections</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('journals.file_categories') }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">File Categories</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('journals.submission_confirmations') }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Submission Confirmation</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <button type="button" class="flex items-center w-full px-4 py-2 text-base text-white hover:text-gray-950 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-e" data-collapse-toggle="dropdown-e">
                                    <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                        <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                                    </svg>
                                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Users</span>
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <ul id="dropdown-e" class="hidden py-2 space-y-2">
                                    <li>
                                        <a href="{{ route('admin.users') }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">All Users</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.roles') }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Roles</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.permissions') }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Permissions</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.salutations') }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Salutations</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.user_logs') }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">User Logs</a>
                                    </li>
                                </ul>
                            </li>


                            <li>
                                <button type="button" class="flex items-center w-full px-4 py-2 text-base text-white hover:text-gray-950 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-g" data-collapse-toggle="dropdown-g">
                                    <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                                        <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                                    </svg>
                                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Website</span>
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <ul id="dropdown-g" class="hidden py-2 space-y-2">
                                    <li>
                                        <a href="{{ route('journals.sliding_images') }}" class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Sliding Images</a>
                                    </li>
                                </ul>
                            </li>

                        </ul>

                    @endrole
                </div>
            </aside>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                <div class="p-6 sm:ml-64">
                {{ $slot }}
                </div>
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
