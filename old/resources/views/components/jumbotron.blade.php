@props(['title' => '', 'image' => ''])

<div class="md:mt-20">
    @if ($title)
    
    <section class="bg-center bg-no-repeat bg-cover  @if($image != '') bg-[#2b3033] @else bg-[#175883] @endif bg-blend-overlay" @if($image != '') style="background-image: url({{ asset($image) }}); background-position: top;" @endif>
        <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-28">
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-4xl">{{ $title }}</h1>
            <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48"></p>
        </div>
    </section>

    @endif
</div>