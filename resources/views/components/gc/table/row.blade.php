@props([
    'striped' => false,
])

<tr {{ $attributes->merge(['class' => $striped ? 'even:bg-gray-50' : '']) }}>
    {{ $slot }}
</tr> 