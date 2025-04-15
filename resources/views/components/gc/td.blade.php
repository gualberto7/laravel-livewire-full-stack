@props([
    'variant' => 'default'
])

@php
    $classes = match ($variant) {
        'strong' => 'px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white',
        default => 'px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-zinc-400'
    };
@endphp

<td {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</td> 