@props([
    'paginate' => null,
])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-lg border border-gray-200 dark:border-zinc-700']) }}>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
            <thead class="bg-gray-50 dark:bg-zinc-800">
                {{ $header }}
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-zinc-900 dark:divide-zinc-700">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>

@if($paginate)
    <div class="mt-4">
        {{ $paginate->links() }}
    </div>
@endif 