<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-6 py-3.5 bg-white border border-gray-300 rounded-lg font-bold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#C49A6C]/50 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>

