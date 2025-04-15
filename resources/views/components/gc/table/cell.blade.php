@props([
    'align' => 'left',
])

<td {{ $attributes->merge(['class' => 'whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 ' . match($align) {
    'left' => 'text-left',
    'center' => 'text-center',
    'right' => 'text-right',
    default => 'text-left'
}]) }}>
    {{ $slot }}
</td> 