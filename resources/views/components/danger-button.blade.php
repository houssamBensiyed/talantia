<button {{ $attributes->merge(['type' => 'submit', 'class' => 'group inline-flex items-center justify-center px-6 py-3 bg-obsidian border border-transparent rounded-full font-bold text-sm text-white tracking-wider uppercase hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-300 shadow-gloss hover:shadow-gloss-hover relative overflow-hidden']) }}>
    <span class="absolute inset-0 bg-gradient-to-b from-white/10 to-transparent pointer-events-none"></span>
    <span class="relative flex items-center gap-2">
        {{ $slot }}
    </span>
</button>
