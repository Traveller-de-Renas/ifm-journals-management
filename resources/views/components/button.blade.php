<button {{ $attributes->merge(['type' => 'submit', 'class' => 'rounded-md btn bg-[#175883] text-gray-100 hover:bg-[#3180b5] dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white whitespace-nowrap']) }}>
    {{ $slot }}
</button>
