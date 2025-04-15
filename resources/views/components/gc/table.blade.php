@props([
    'paginate' => null,
])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-lg border border-gray-200 dark:border-zinc-700']) }}>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-300">
            <thead>
                <tr>
                    {{ $header }}
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
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