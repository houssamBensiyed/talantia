@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-sm text-obsidian tracking-wide mb-2']) }}>
    {{ $value ?? $slot }}
</label>
