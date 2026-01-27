@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center w-full ps-4 pe-4 py-3 rounded-xl text-base font-bold text-white bg-obsidian shadow-gloss transition-all duration-200'
            : 'flex items-center w-full ps-4 pe-4 py-3 rounded-xl text-base font-medium text-mono-600 hover:text-obsidian hover:bg-white hover:shadow-tactile-sm transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
