<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-tactile-bg border border-mono-200 rounded-full font-semibold text-sm text-obsidian tracking-wide shadow-pressed hover:shadow-pressed-hover hover:bg-mono-100 focus:outline-none focus:ring-2 focus:ring-obsidian focus:ring-offset-2 disabled:opacity-25 transition-all duration-300 active:shadow-pressed']) }}>
    {{ $slot }}
</button>
