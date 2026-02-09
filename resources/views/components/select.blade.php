@props(['disabled' => false, 'options' => []])

<select @disabled($disabled) {{ $attributes->merge(['class' => 'w-full bg-mono-50 border-2 border-transparent focus:bg-white focus:border-obsidian focus:ring-0 rounded-2xl shadow-pressed text-obsidian transition-all duration-300 font-medium py-3.5 px-5 tracking-wide appearance-none bg-[url(\'data:image/svg+xml;charset=utf-8,%3Csvg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"%3E%3Cpath stroke="%236b7280" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/%3E%3C/svg%3E\')] bg-[length:1.5rem_1.5rem] bg-no-repeat bg-[right_0.5rem_center] pr-10']) }}>
    {{ $slot }}
</select>
