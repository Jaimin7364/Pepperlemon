<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3.5 bg-[#C49A6C] border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-[#b0875b] active:bg-[#a0774b] focus:outline-none focus:ring-2 focus:ring-[#C49A6C]/50 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg']) }}>
    {{ $slot }}
</button>

