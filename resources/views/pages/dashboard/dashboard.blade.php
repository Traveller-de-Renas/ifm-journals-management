<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Dashboard actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Dashboard</h1>
            </div>

        </div>
        
        <!-- Cards -->

            <div class="w-full grid grid-cols-3 gap-2 mb-6">
                <div class="bg-white p-3 rounded-md shadow-md">
                    Assigned Journals

                    <div class="border-b border-gray-200 mt-1"></div>
        
                    <a href="">
                    
                    <div class="flex text-xs py-2" >
                        <div class="w-full">Incomplete</div>
                        <div class="w-1/12">0</div>
                    </div>
        
                    </a>
        
                    <div class="flex text-xs">
                        <div class="w-full">Sent Back</div>
                        <div class="w-1/12">0</div>
                    </div>
                    <div class="flex text-xs">
                        <div class="w-full">In Process</div>
                        <div class="w-1/12">0</div>
                    </div>
                    <div class="flex text-xs">
                        <div class="w-full">Declined</div>
                        <div class="w-1/12">0</div>
                    </div>
                </div>
                <div class="bg-white p-3 rounded-md shadow-md">
                    Revisions

                    <div class="border-b border-gray-200 mt-1"></div>
                    
                    <div class="flex text-xs">
                        <div class="w-full">Requiring Revision</div>
                        <div class="w-1/12">0</div>
                    </div>
                    <div class="flex text-xs">
                        <div class="w-full">Sent Back</div>
                        <div class="w-1/12">0</div>
                    </div>
                    <div class="flex text-xs">
                        <div class="w-full">In Process</div>
                        <div class="w-1/12">0</div>
                    </div>
                    <div class="flex text-xs">
                        <div class="w-full">Declined Revision</div>
                        <div class="w-1/12">0</div>
                    </div>
                </div>
                <div class="bg-white p-3 rounded-md shadow-md">
                    Completed

                    <div class="border-b border-gray-200 mt-1"></div>
                    <div class="flex text-xs">
                        <div class="w-full">Completed</div>
                        <div class="w-1/12">0</div>
                    </div>
                </div>
            </div>


    </div>
</x-app-layout>
