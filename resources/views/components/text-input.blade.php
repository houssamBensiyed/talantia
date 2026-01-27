@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full bg-mono-50 border-2 border-transparent focus:bg-white focus:border-obsidian focus:ring-0 rounded-2xl shadow-pressed text-obsidian placeholder-mono-400 transition-all duration-300 font-medium py-3.5 px-5 tracking-wide']) }}>
