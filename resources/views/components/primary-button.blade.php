<button {{ $attributes->merge(['type' => 'submit', 'class' => 'group inline-flex items-center justify-center px-7 py-3.5 bg-obsidian border border-transparent rounded-full font-bold text-sm text-white tracking-wider uppercase hover:bg-obsidian-light focus:outline-none focus:ring-2 focus:ring-obsidian focus:ring-offset-2 transition-all duration-300 shadow-gloss hover:shadow-gloss-hover hover:scale-[1.02] active:scale-[0.98] relative overflow-hidden']) }}>
    <span class="absolute inset-0 bg-gradient-to-b from-white/10 to-transparent pointer-events-none"></span>
    <span class="relative flex items-center gap-2">
        {{ $slot }}
    </span>
</button>
