@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-5 py-2.5 rounded-full text-sm font-bold text-white bg-obsidian shadow-gloss transition-all duration-300'
            : 'inline-flex items-center px-5 py-2.5 rounded-full text-sm font-medium text-mono-500 hover:text-obsidian hover:bg-white hover:shadow-tactile-sm transition-all duration-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
