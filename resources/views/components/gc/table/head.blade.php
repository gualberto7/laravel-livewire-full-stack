@props([
    'align' => 'left',
])

<th {{ $attributes->merge(['class' => 'py-3.5 pl-4 pr-3 text-sm font-semibold text-gray-900 ' . match($align) {
    'left' => 'text-left',
    'center' => 'text-center',
    'right' => 'text-right',
    default => 'text-left'
}]) }} scope="col">
    {{ $slot }}
</th> 