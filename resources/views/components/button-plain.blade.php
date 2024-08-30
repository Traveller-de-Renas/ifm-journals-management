<button {{ $attributes->merge(['class' => 'px-4 py-[7px] border border-transparent rounded font-semibold text-sm text-white tracking-widest active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
