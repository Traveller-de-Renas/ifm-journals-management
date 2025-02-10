<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon-->
        <link rel="shortcut icon" href="{{ asset('storage/logo.png') }}">
        <!-- Author Meta -->
        <meta name="author" content="The Institute of Finance Management">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="bg-gray-100">

        <main class=" dark:bg-gray-900">
            <nav class="bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700">
                <div class="w-full bg-[#175883]">
                    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4 ">
                        <a href="{{ url('/') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                            <img src="{{ asset('storage/logo.png' ) }}" class="w-12 md:w-24 md:h-24" >
                            <div>
                                <p class="text-white text-4xl font-bold">The institute of Finance Management</p>
                                <p class="text-white text-lg">Journals Management System</p>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- @if(explode('/', request()->path())[1] != 'article_evaluation') --}}
                <div class="w-full bg-white shadow-lg">
                    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                        <a href="{{ url('/') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                        </a>
                        <button data-collapse-toggle="navbar-dropdown" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-dropdown" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                            </svg>
                        </button>
                        <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
                            <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                                <li>
                                    <a href="{{ url('/') }}" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500 dark:bg-blue-600 md:dark:bg-transparent" aria-current="page">Home</a>
                                </li>
                                
                                <li>
                                    <a href="{{ route('journal.viewall') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Journals</a>
                                </li>
                                <li>
                                    <a href="{{ route('journal.callfor_paper') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Call for Papers</a>
                                </li>
                                @if (explode('/', request()->path())[0] == 'journal' && explode('/', request()->path())[1] == 'detail' && Str::isUuid(explode('/', request()->path())[2]))
                                    <li>
                                        <a href="{{ route('login', explode('/', request()->path())[2]) }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Login</a>
                                    </li>
                                
                                    <li>
                                        <a href="{{ route('register', explode('/', request()->path())[2]) }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Register</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    
                </div>
                {{-- @endif --}}
            </nav>
  
            <div class="relative">
                <div class="w-full">
                    <div class="min-h-[100dvh] h-full flex flex-col after:flex-1">

                        <div class="fixed right-2 z-50 md:flex flex-col gap-2 justify-center items-center w-50 mt-12 text-md hidden">

                            @foreach ($social_media as $media)
                            <a href="{{ $media->link }}" target="_blank">
                            <div class="relative flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-300 p-2 w-full cursor-pointer border-2">
                                @if($media->type == 'image')
                                    <img class="rounded-full max-h-[35px] lg:max-h[20px] mt-[2px]" src="{{ asset('storage/social_media/'.$media->icon) }}" alt="" />
                                @else
                                    <div class="max-h-[30px] w-[30px] lg:max-h-[30px] items-center ">{!! $media->icon !!}</div>
                                @endif
                            </div>
                            </a>
                            @endforeach
            
                        </div>

                        {{ $slot }}

                    </div>
                </div>
            </div>

            <div class="p-4 bg-[#175883]">
                <div class="max-w-screen-2xl lg:max-w-screen-lg mx-auto text-white">

                    <div class="grid md:grid-cols-5 w-full space-x-8 md:space-x-8 justify-center mt-6 mb-8">
                        <div class="mb-6">
                            <center>
                                <img src="{{ asset('storage/logo.png' ) }}" class="w-12 md:w-32 md:h-32" >
                            </center>
                        </div>
                        <div class="mb-6">
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-white">{{ __('Contacts') }}</h5>
                            <p class=""> P.O Box 3918, 5 Shaaban Robert Street</p>
                            <p class=""> 11101 Dar es salaam</p>
                            <p class=""> +255 22 2112931-4</p>
                            <p class=""> Fax : +255 22 2112935</p>
                            <p class=""> rector@ifm.ac.tz</p>
                        </div>
                        <div class="mb-6 col-span-2">
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-white">{{ __('Quick Links') }}</h5>
                            
                            <a href="" class="w-full text-sm text-wrap hover:text-gray-400">
                                Frequently Asked Questions 
                            </a>
                            <br>
                            <a href="" class="w-full text-sm text-wrap hover:text-gray-400">
                                Research Areas
                            </a>
                            <br>
                        </div>
                        <div class="mb-6">
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-white">{{ __('Related Links') }}</h5>
                            
                        </div>
                    </div>

                    <div class="border"></div>

                    <div class="z-50 flex gap-2 justify-center items-center w-50 text-md mt-4 mb-4 md:hidden">

                        @foreach ($social_media as $media)
                        <a href="{{ $media->link }}" target="_blank">
                        <div class="relative rounded-full bg-gray-100 hover:bg-gray-400 p-2 w-full cursor-pointer border-2">
                            @if($media->type == 'image')
                            <img class="rounded-full max-h-[35px] mt-[2px]" src="{{ asset('storage/social_media/'.$media->icon) }}" alt="" />
                            @else
                                <div class="max-h-[45px] items-center w-full ">{!! $media->icon !!}</div>
                            @endif
                        </div>
                        </a>
                        @endforeach
        
                    </div>

                    <div class="border md:hidden"></div>

                    <div class="flex w-full m-auto md:space-x-12 mt-6 mb-6 items-center justify-center">
                        
                    </div>

                    <div class="text-center mb-4">
                        © {{ date('Y')}} The Institute of Finance Management. All rights reserved.
                    </div>

                </div>
            </div>

        </main> 

        @livewireScripts
    </body>
</html>