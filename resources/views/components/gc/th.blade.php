@props([
    'sortable' => false,
    'direction' => null,
    'sorted' => false,
])

<th {{ $attributes->merge(['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-zinc-400']) }}>
    @if($sortable)
        <button {{ $attributes->except('class') }} class="group inline-flex items-center space-x-1">
            <span>{{ $slot }}</span>
            <span class="flex-none rounded text-gray-400 group-hover:visible group-focus:visible">
                @if($sorted)
                    @if($direction === 'asc')
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 01-1.08-.02.75.75 0 01.02-1.08l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.01 1.06z" clip-rule="evenodd" />
                        </svg>
                    @else
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    @endif
                @else
                    <svg class="invisible h-5 w-5 group-hover:visible" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                @endif
            </span>
        </button>
    @else
        {{ $slot }}
    @endif
</th> 