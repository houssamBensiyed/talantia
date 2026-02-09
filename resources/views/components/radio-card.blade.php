@props(['value', 'name', 'label', 'icon' => null, 'description' => null, 'checked' => false])

<label {{ $attributes->merge(['class' => 'relative flex cursor-pointer rounded-2xl border-2 border-mono-200 bg-mono-50/50 p-4 hover:border-mono-400 focus:outline-none transition-all duration-300 group selection-card']) }}
       :class="{ 'bg-white shadow-tactile border-obsidian scale-[1.02]': selected === '{{ $value }}', 'bg-mono-50/50 border-mono-200': selected !== '{{ $value }}' }"
       @click="selected = '{{ $value }}'">
    <input type="radio" name="{{ $name }}" value="{{ $value }}" class="sr-only" wire:model.live="{{ $name }}" {{ $checked ? 'checked' : '' }}>
    <span class="flex flex-1 flex-col items-center text-center">
        @if($icon)
            <span class="flex h-12 w-12 items-center justify-center rounded-xl transition-all duration-300 mb-2"
                  :class="{ 'bg-obsidian text-brand-accent shadow-gloss scale-110': selected === '{{ $value }}', 'bg-white text-mono-400 shadow-pressed': selected !== '{{ $value }}' }">
                <i class="{{ $icon }} text-lg"></i>
            </span>
        @endif
        <span class="block text-sm font-bold text-obsidian group-hover:text-obsidian transition-colors">{{ $label }}</span>
        @if($description)
            <span class="mt-1 text-xs text-mono-500">{{ $description }}</span>
        @endif
    </span>
    <span class="pointer-events-none absolute -inset-px rounded-2xl border-2 border-transparent transition-all duration-300"
          :class="{ 'border-obsidian': selected === '{{ $value }}' }"
          aria-hidden="true"></span>
</label>
