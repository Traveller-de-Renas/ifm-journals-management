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
        body * {
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

        <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar"
            aria-controls="sidebar-multi-level-sidebar" type="button"
            class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd" fill-rule="evenodd"
                    d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                </path>
            </svg>
        </button>

        <aside id="sidebar-multi-level-sidebar"
            class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
            aria-label="Sidebar">

            <div class="h-full py-4 overflow-y-auto bg-[#2B579A]">
                <div class="w-full text-center px-12 py-3">
                    <a href="{{ url('/dashboard') }}" class="">
                        <center>
                            <img src="{{ asset('storage/logo.png') }}" class="max-w-24">
                        </center>
                    </a>
                </div>


                @if (auth()->user()->hasAnyPermission(['View Dashboard', 'Settings', 'Call for Papers']))
                    <ul class="space-y-2 font-medium border-t border-gray-400">


                        @if (auth()->user()->hasPermissionTo('View Dashboard'))
                            <li>
                                <a href="{{ route('journals.dashboard') }}"
                                    class="flex items-center px-4 py-2 text-white hover:text-gray-950 hover:bg-gray-100 group">
                                    <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 group-hover:text-gray-900 "
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <rect x="3" y="12" width="6" height="8" rx="1" />
                                        <rect x="9" y="8" width="6" height="12" rx="1" />
                                        <rect x="15" y="4" width="6" height="16" rx="1" />
                                        <line x1="4" y1="20" x2="18" y2="20" />
                                    </svg>
                                    <span class="ms-3">Dashboard</span>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->hasPermissionTo('Settings') && session('journal'))
                            <li>
                                <button type="button"
                                    class="flex items-center w-full px-4 py-2 text-base text-white hover:text-gray-950 transition duration-75 group hover:bg-gray-100"
                                    aria-controls="dropdown-f" data-collapse-toggle="dropdown-f">
                                    <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 group-hover:text-gray-900 "
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Setting</span>
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>
                                <ul id="dropdown-f" class="hidden py-2 space-y-2">



                                    @if (auth()->user()->hasPermissionTo('Edit Journals'))
                                        <li>
                                            <a href="{{ route('journals.create', session('journal')) }}"
                                                class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Journal
                                                Details</a>
                                        </li>
                                    @endif

                                    @if (auth()->user()->hasPermissionTo('Journal Team'))
                                        <li>
                                            <a href="{{ route('journals.team', session('journal')) }}"
                                                class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Journal
                                                Team</a>
                                        </li>
                                    @endif

                                    @if (auth()->user()->hasPermissionTo('Reviewers'))
                                        <li>
                                            <a href="{{ route('journals.reviewer', session('journal')) }}"
                                                class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Reviewers</a>
                                        </li>
                                    @endif

                                    @if (auth()->user()->hasPermissionTo('Journal Users'))
                                        <li>
                                            <a href="{{ route('journals.users', session('journal')) }}"
                                                class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Journal
                                                Users</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif


                        <li>
                            <a href="{{ route('journals.editor_checklist') }}"
                                class="flex items-center px-4 py-2 text-white hover:text-gray-950 hover:bg-gray-100 group">
                                <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 group-hover:text-gray-900 "
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <line x1="8" y1="6" x2="21" y2="6" />
                                    <line x1="8" y1="12" x2="21" y2="12" />
                                    <line x1="8" y1="18" x2="21" y2="18" />
                                    <line x1="3" y1="6" x2="3.01" y2="6" />
                                    <line x1="3" y1="12" x2="3.01" y2="12" />
                                    <line x1="3" y1="18" x2="3.01" y2="18" />
                                </svg>
                                <span class="ms-3">Editorial Checklist</span>
                            </a>
                        </li>


                        @if (auth()->user()->hasPermissionTo('Call for Papers') && session('journal'))
                            <li>
                                <a href="{{ route('journals.call_for_papers', session('journal')) }}"
                                    class="flex items-center px-4 py-2 text-white hover:text-gray-950 hover:bg-gray-100 group">
                                    <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 group-hover:text-gray-900 "
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                    <span class="ms-3">Call for Papers</span>
                                </a>
                            </li>
                        @endif

                    </ul>
                @endif


                @if (in_array(auth()->user()->id, $ceditor) || (auth()->user()->hasRole('Administrator') && session('journal')))
                    <div class="px-4 py-2 text-gray-300 mt-4"> Editors</div>

                    <ul class="space-y-2 font-medium border-t border-gray-400">

                        <li>
                            <button type="button"
                                class="flex items-center w-full px-4 py-2 text-base text-white hover:text-gray-950 transition duration-75 group hover:bg-gray-100"
                                aria-controls="dropdown-a" data-collapse-toggle="dropdown-a">
                                <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 group-hover:text-gray-900"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 18 18">
                                    <path
                                        d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                                </svg>
                                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Submission</span>

                                @if ($submitted + $resubmitted > 0)
                                    <span
                                        class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-xs font-medium text-white bg-red-700 rounded-full">{{ $submitted + $resubmitted }}</span>
                                @endif

                                <svg class="w-3 h-3 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <ul id="dropdown-a" class="hidden py-2 space-y-2">
                                <li>
                                    <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'submitted']) }}"
                                        class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">

                                        <span class="flex-1 text-left rtl:text-right whitespace-nowrap">New
                                            Submission</span>
                                        @if ($submitted > 0)
                                            <span
                                                class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-xs font-medium text-white bg-red-700 rounded-full">{{ $submitted }}</span>
                                        @endif
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'resubmitted']) }}"
                                        class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">
                                        <span
                                            class="flex-1 text-left rtl:text-right whitespace-nowrap">Resubmissions</span>
                                        @if ($resubmitted > 0)
                                            <span
                                                class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-xs font-medium text-white bg-red-700 rounded-full">{{ $resubmitted }}</span>
                                        @endif
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li>
                            <button type="button"
                                class="flex items-center w-full px-4 py-2 text-base text-white hover:text-gray-950 transition duration-75 group hover:bg-gray-100"
                                aria-controls="dropdown-b" data-collapse-toggle="dropdown-b">
                                <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 group-hover:text-gray-900 "
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 18 18">
                                    <path
                                        d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                                </svg>
                                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Review</span>

                                @if ($onreview > 0)
                                    <span
                                        class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-xs font-medium text-white bg-red-700 rounded-full">{{ $onreview }}</span>
                                @endif

                                <svg class="w-3 h-3 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <ul id="dropdown-b" class="hidden py-2 space-y-2">
                                <li>
                                    <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'on_review']) }}"
                                        class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">
                                        <span class="flex-1 text-left rtl:text-right whitespace-nowrap">On
                                            Review</span>
                                        @if ($onreview > 0)
                                            <span
                                                class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-xs font-medium text-white bg-red-700 rounded-full">{{ $onreview }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'returned_to_author']) }}"
                                        class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Returned
                                        to Author</a>
                                </li>
                                <li>
                                    <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'rejected']) }}"
                                        class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Rejected
                                        Paper</a>
                                </li>
                            </ul>
                        </li>


                        <li>
                            <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'production']) }}"
                                c
                                class="flex items-center px-4 py-2 text-white hover:text-gray-950 hover:bg-gray-100 group">
                                <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 group-hover:text-gray-900 "
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 18 18">
                                    <path
                                        d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                                </svg>
                                <span class="ms-3">Production</span>
                            </a>
                        </li>


                        <li>
                            <button type="button"
                                class="flex items-center w-full px-4 py-2 text-base text-white hover:text-gray-950 transition duration-75 group hover:bg-gray-100"
                                aria-controls="dropdown-c" data-collapse-toggle="dropdown-c">
                                <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 group-hover:text-gray-900 "
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 18 18">
                                    <path
                                        d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                                </svg>
                                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Publication</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <ul id="dropdown-c" class="hidden py-2 space-y-2">
                                <li>
                                    <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'pending_publications']) }}"
                                        class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Pending
                                        for Publication</a>
                                </li>
                                <li>
                                    <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'online_first']) }}"
                                        class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Online
                                        First</a>
                                </li>
                                <li>
                                    <a href="{{ route('journals.publication', session('journal')) }}"
                                        class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Issue
                                        Assignment</a>
                                </li>
                                <li>
                                    <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'published']) }}"
                                        class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Published</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ route('journals.editor_guide', session('journal')) }}"
                                class="flex items-center px-4 py-2 text-white hover:text-gray-950 hover:bg-gray-100 group">
                                <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 group-hover:text-gray-900 "
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                <span class="ms-3">Editorial Guidelines</span>
                            </a>
                        </li>
                    </ul>
                @endif


                <div class="px-4 py-2 text-gray-300 mt-4"> Author</div>

                <ul class="space-y-2 font-medium border-t border-gray-400">
                    <li>
                        <a href="{{ route('journals.submission', session('journal')) }}"
                            class="flex items-center px-4 py-2 text-white hover:text-gray-950 hover:bg-gray-100 group">
                            <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 group-hover:text-gray-900 "
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
                            </svg>

                            <span class="ms-3">New Submission</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'pending']) }}"
                            class="flex items-center px-4 py-2 text-white hover:text-gray-950 hover:bg-gray-100 group">
                            <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 group-hover:text-gray-900 "
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>


                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Pending</span>
                            @if ($pending > 0)
                                <span
                                    class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-xs font-medium text-white bg-red-700 rounded-full">{{ $pending }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'onprogress']) }}"
                            class="flex items-center px-4 py-2 text-white hover:text-gray-950 hover:bg-gray-100 group">
                            <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 group-hover:text-gray-900 "
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>

                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">On Progress</span>
                        </a>
                    </li>


                    <li>
                        <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'returned']) }}"
                            class="flex items-center px-4 py-2 text-white hover:text-gray-950 hover:bg-gray-100 group">
                            <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 group-hover:text-gray-900 "
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
                            </svg>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Returned</span>

                            @if ($returned > 0)
                                <span
                                    class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-white bg-red-700 rounded-full">{{ $returned }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('journals.articles', ['journal' => session('journal'), 'status' => 'with_decisions']) }}"
                            class="flex items-center px-4 py-2 text-white hover:text-gray-950 hover:bg-gray-100 group">
                            <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 group-hover:text-gray-900 "
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span class="ms-3">Manuscript with Decision</span>
                        </a>
                    </li>
                </ul>


                @role('Administrator')

                    <div class="px-4 py-2 text-gray-300 mt-4"> Administrator</div>

                    <ul class="space-y-2 font-medium border-t border-gray-400">


                        @if (auth()->user()->hasPermissionTo('Journals'))
                            <li>
                                <button type="button"
                                    class="flex items-center w-full px-4 py-2 text-base text-white hover:text-gray-950 transition duration-75 group hover:bg-gray-100"
                                    aria-controls="dropdown-d" data-collapse-toggle="dropdown-d">
                                    <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 group-hover:text-gray-900 "
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M6 4h11a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-11a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1m3 0v18" />
                                        <line x1="13" y1="8" x2="15" y2="8" />
                                        <line x1="13" y1="12" x2="15" y2="12" />
                                    </svg>
                                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Journals</span>
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>
                                <ul id="dropdown-d" class="hidden py-2 space-y-2">
                                    @if (auth()->user()->hasPermissionTo('View Journals'))
                                        <li>
                                            <a href="{{ route('journals.index') }}"
                                                class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">All
                                                Journals</a>
                                        </li>
                                    @endif


                                    @if (auth()->user()->hasPermissionTo('View Journal Subjects'))
                                        <li>
                                            <a href="{{ route('journals.subjects') }}"
                                                class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Subjects</a>
                                        </li>
                                    @endif


                                    @if (auth()->user()->hasPermissionTo('View Journal Categories'))
                                        <li>
                                            <a href="{{ route('journals.categories') }}"
                                                class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Categories</a>
                                        </li>
                                    @endif


                                    @if (auth()->user()->hasPermissionTo('View Notification Messages'))
                                        <li>
                                            <a href="{{ route('journals.review_messages') }}"
                                                class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Notification
                                                Message</a>
                                        </li>
                                    @endif


                                    @if (auth()->user()->hasPermissionTo('View Review Sections'))
                                        <li>
                                            <a href="{{ route('journals.review_sections') }}"
                                                class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Review
                                                Sections</a>
                                        </li>
                                    @endif


                                    @if (auth()->user()->hasPermissionTo('View File Categories'))
                                        <li>
                                            <a href="{{ route('journals.file_categories') }}"
                                                class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">File
                                                Categories</a>
                                        </li>
                                    @endif


                                    @if (auth()->user()->hasPermissionTo('View Submission Confirmation'))
                                        <li>
                                            <a href="{{ route('journals.submission_confirmations') }}"
                                                class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Submission
                                                Confirmation</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        @if (auth()->user()->hasPermissionTo('Users'))
                            <li>
                                <button type="button"
                                    class="flex items-center w-full px-4 py-2 text-base text-white hover:text-gray-950 transition duration-75 group hover:bg-gray-100"
                                    aria-controls="dropdown-e" data-collapse-toggle="dropdown-e">
                                    <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 group-hover:text-gray-900 "
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                    </svg>
                                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Users</span>
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>
                                <ul id="dropdown-e" class="hidden py-2 space-y-2">
                                    @if (auth()->user()->hasPermissionTo('View Journal Subjects'))
                                        <li>
                                            <a href="{{ route('admin.users') }}"
                                                class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">All
                                                Users</a>
                                        </li>
                                    @endif

                                    @if (auth()->user()->hasPermissionTo('View Roles'))
                                        <li>
                                            <a href="{{ route('admin.roles') }}"
                                                class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Roles</a>
                                        </li>
                                    @endif

                                    @if (auth()->user()->hasPermissionTo('View Permissions'))
                                        <li>
                                            <a href="{{ route('admin.permissions') }}"
                                                class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Permissions</a>
                                        </li>
                                    @endif

                                    @if (auth()->user()->hasPermissionTo('View Salutations'))
                                        <li>
                                            <a href="{{ route('admin.salutations') }}"
                                                class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Salutations</a>
                                        </li>
                                    @endif

                                    @if (auth()->user()->hasPermissionTo('View User Logs'))
                                        <li>
                                            <a href="{{ route('admin.user_logs') }}"
                                                class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Activity
                                                Logs</a>
                                        </li>
                                    @endif
                                    @if (auth()->user()->hasPermissionTo('View Roles'))
                                        <li>
                                            <a href="{{ route('admin.failed_jobs') }}"
                                                class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Failed
                                                Jobs</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif


                        @if (auth()->user()->hasPermissionTo('Website'))
                            <li>
                                <button type="button"
                                    class="flex items-center w-full px-4 py-2 text-base text-white hover:text-gray-950 transition duration-75 group hover:bg-gray-100"
                                    aria-controls="dropdown-g" data-collapse-toggle="dropdown-g">
                                    <svg class="flex-shrink-0 w-4 h-5 text-white transition duration-75 group-hover:text-gray-900 "
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <circle cx="12" cy="12" r="9" />
                                        <line x1="3.6" y1="9" x2="20.4" y2="9" />
                                        <line x1="3.6" y1="15" x2="20.4" y2="15" />
                                        <path d="M11.5 3a17 17 0 0 0 0 18" />
                                        <path d="M12.5 3a17 17 0 0 1 0 18" />
                                    </svg>
                                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Website</span>
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>
                                <ul id="dropdown-g" class="hidden py-2 space-y-2">
                                    @if (auth()->user()->hasPermissionTo('View Sliding Images'))
                                        <li>
                                            <a href="{{ route('journals.sliding_images') }}"
                                                class="flex items-center w-full p-2 text-white hover:text-gray-950 transition duration-75 pl-11 group hover:bg-gray-100">Sliding
                                                Images</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif

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
