<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Mobile Specific Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Favicon-->
        <link rel="shortcut icon" href="{{ asset('storage/logo.png') }}">
        <!-- Author Meta -->
        <meta name="author" content="colorlib">
        <!-- Meta Description -->
        <meta name="description" content="The Institute of Finance Management (IFM) stands as the oldest higher learning financial institution in Tanzania and ithas been dedicated to excellence in teaching, research, and consultancy. Currently, the Institute enrolls about 9228 students in both undergraduate and graduate programmes. At IFM, students are inspired and challenged to investigate critical issues of the 21st century in areas of financial management, insurance, social protection, and information technology">
        <!-- Meta Keyword -->
        <meta name="keywords" content="IFM University Academic Institution Chuo Kikuu Chuo Cha Usmimazi wa Fedha Higher Leaning Institution in Tanzania">
        <!-- meta character set -->
        <meta charset="UTF-8">
        <!-- Site Title -->
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased w-full overflow-x-hidden m-0">
        <x-banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 w-full">

            <!-- Page Content -->
            <main>
                <div class="grid grid-cols-12 bottom-0 h-dvh">
                    <div class="col-span-2 bottom-0 bg-gray-100" >

                        <aside id="sidebar-multi-level-sidebar" class="fixed top-0 left-0 z-40 w-80 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
                            
                            <div class="h-full px-3 py-4 overflow-y-auto bg-[#175883] dark:bg-gray-800 text-white">
                                <div class="w-full text-center px-12 py-3">
                                    <a href="{{ url('/dashboard') }}" class="" >
                                        <center>
                                            <img src="{{ asset('storage/logo.png' ) }}" class="max-w-24">
                                        </center>
                                    </a>
                                </div>
                            <ul class="space-y-2 font-medium">

                                <li>
                                    <a href="{{ url('/dashboard') }}" class="flex items-center p-3 text-white hover:text-black rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                        <svg class="w-5 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                                        </svg>
                                        <span class="ms-3">Dashboard</span>
                                    </a>
                                </li>

                                
                                <li>
                                    <button type="button" class="flex items-center w-full p-3 text-base text-white hover:text-black transition duration-75 rounded-lg group hover:bg-gray-100 " aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                                        <svg class="flex-shrink-0 w-5 h-5 text-white transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M4.857 3A1.857 1.857 0 0 0 3 4.857v4.286C3 10.169 3.831 11 4.857 11h4.286A1.857 1.857 0 0 0 11 9.143V4.857A1.857 1.857 0 0 0 9.143 3H4.857Zm10 0A1.857 1.857 0 0 0 13 4.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 21 9.143V4.857A1.857 1.857 0 0 0 19.143 3h-4.286Zm-10 10A1.857 1.857 0 0 0 3 14.857v4.286C3 20.169 3.831 21 4.857 21h4.286A1.857 1.857 0 0 0 11 19.143v-4.286A1.857 1.857 0 0 0 9.143 13H4.857Zm10 0A1.857 1.857 0 0 0 13 14.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 21 19.143v-4.286A1.857 1.857 0 0 0 19.143 13h-4.286Z" clip-rule="evenodd"/>
                                        </svg>  
                                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Journals</span>
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                    <ul id="dropdown-example" class="hidden py-2 space-y-2">
                                        
                                        <li>
                                            <a href="{{ route('journals.index') }}" class="flex items-center w-full p-2 text-white hover:text-black transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 ">Journals List</a>
                                        </li>

                                        <li>
                                            <a href="{{ route('journals.subjects') }}" class="flex items-center w-full p-2 text-white hover:text-black transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 ">Subjects</a>
                                        </li>

                                        <li>
                                            <a href="{{ route('journals.categories') }}" class="flex items-center w-full p-2 text-white hover:text-black transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 ">Categories</a>
                                        </li>

                                    </ul>
                                </li>

                               
                                <li>
                                    <button type="button" class="flex items-center w-full p-3 text-base text-white hover:text-black transition duration-75 rounded-lg group hover:bg-gray-100 " aria-controls="dropdown-9" data-collapse-toggle="dropdown-10">
                                        <svg class="flex-shrink-0 w-5 h-5 text-white transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M4.857 3A1.857 1.857 0 0 0 3 4.857v4.286C3 10.169 3.831 11 4.857 11h4.286A1.857 1.857 0 0 0 11 9.143V4.857A1.857 1.857 0 0 0 9.143 3H4.857Zm10 0A1.857 1.857 0 0 0 13 4.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 21 9.143V4.857A1.857 1.857 0 0 0 19.143 3h-4.286Zm-10 10A1.857 1.857 0 0 0 3 14.857v4.286C3 20.169 3.831 21 4.857 21h4.286A1.857 1.857 0 0 0 11 19.143v-4.286A1.857 1.857 0 0 0 9.143 13H4.857Zm10 0A1.857 1.857 0 0 0 13 14.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 21 19.143v-4.286A1.857 1.857 0 0 0 19.143 13h-4.286Z" clip-rule="evenodd"/>
                                        </svg>                                                                                 
                                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Website</span>
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                    <ul id="dropdown-10" class="hidden py-2 space-y-2">
                                        <li>
                                            <a href="" class="flex items-center w-full p-2 text-white hover:text-black transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 ">Social Media</a>
                                        </li>
                                        
                                        <li>
                                            <a href="" class="flex items-center w-full p-2 text-white hover:text-black transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 ">Sliding Images</a>
                                        </li>
                                        
                                        <li>
                                            <a href="" class="flex items-center w-full p-2 text-white hover:text-black transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 ">Contacts</a>
                                        </li>
                                    </ul>
                                </li>
                                

                                
                                <li>
                                    <button type="button" class="flex items-center w-full p-3 text-base text-white hover:text-black transition duration-75 rounded-lg group hover:bg-gray-100 " aria-controls="dropdown-9" data-collapse-toggle="dropdown-9">
                                        <svg class="flex-shrink-0 w-5 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M9.586 2.586A2 2 0 0 1 11 2h2a2 2 0 0 1 2 2v.089l.473.196.063-.063a2.002 2.002 0 0 1 2.828 0l1.414 1.414a2 2 0 0 1 0 2.827l-.063.064.196.473H20a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-.089l-.196.473.063.063a2.002 2.002 0 0 1 0 2.828l-1.414 1.414a2 2 0 0 1-2.828 0l-.063-.063-.473.196V20a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-.089l-.473-.196-.063.063a2.002 2.002 0 0 1-2.828 0l-1.414-1.414a2 2 0 0 1 0-2.827l.063-.064L4.089 15H4a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2h.09l.195-.473-.063-.063a2 2 0 0 1 0-2.828l1.414-1.414a2 2 0 0 1 2.827 0l.064.063L9 4.089V4a2 2 0 0 1 .586-1.414ZM8 12a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd"/>
                                          </svg>                                                                                 
                                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Configurations</span>
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                    <ul id="dropdown-9" class="hidden py-2 space-y-2">
                                        <li>
                                            <a href="{{ route('admin.salutations') }}" class="flex items-center w-full p-2 text-white hover:text-black transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 ">Salutations</a>
                                        </li>

                                        
                                        <li>
                                            <a href="{{ route('admin.roles') }}" class="flex items-center w-full p-2 text-white hover:text-black transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 ">Roles</a>
                                        </li>

                                        
                                        <li>
                                            <a href="{{ route('admin.permissions') }}" class="flex items-center w-full p-2 text-white hover:text-black transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 ">Permissions</a>
                                        </li>
                                    </ul>
                                </li>

                                
                                <li>
                                    <button type="button" class="flex items-center w-full p-3 text-base text-white hover:text-black transition duration-75 rounded-lg group hover:bg-gray-100 " aria-controls="dropdown-8" data-collapse-toggle="dropdown-8">
                                        <svg class="flex-shrink-0 w-5 h-5 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                            <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                                        </svg>
                                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Users</span>
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                    <ul id="dropdown-8" class="hidden py-2 space-y-2">
                                        <li>
                                            <a href="{{ route('admin.users') }}" class="flex items-center w-full p-2 text-white hover:text-black transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 ">User List</a>
                                        </li>

                                        <li>
                                            <a href="{{ route('admin.logs') }}" class="flex items-center w-full p-2 text-white hover:text-black transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 ">User Logs</a>
                                        </li>
                                    </ul>
                                </li>
                                
                            </ul>
                            </div>
                        </aside>
                    </div>

                    <div class="col-span-10">
                        @livewire('navigation-menu')
                        
                        {{ $slot }}
                    </div>
                </div>
                
            </main>
        </div>

        @stack('modals')
        @stack('scripts')

        @livewireScripts
    </body>
</html>
