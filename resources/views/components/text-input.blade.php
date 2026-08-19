@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200']) }}>

