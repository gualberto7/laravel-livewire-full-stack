@props([
    'name' => null,
])

@php
    // Extract initials from the first two words of the name
    $words = explode(' ', trim($name));
    $initials = '';
    
    if (count($words) >= 1) {
        $initials .= strtoupper(substr($words[0], 0, 1));
    }
    
    if (count($words) >= 2) {
        $initials .= strtoupper(substr($words[1], 0, 1));
    }
@endphp

<div class="flex-shrink-0">
    <div role="img" aria-label="{{ $name }}" class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
        <span class="text-2xl font-medium text-gray-600 dark:text-gray-300">
            {{ $initials }}
        </span>
    </div>
    <span class="sr-only">{{ $name }}</span>
</div>
