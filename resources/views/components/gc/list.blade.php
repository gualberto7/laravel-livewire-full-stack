@props(['items'])

<div class="border-t border-gray-200 dark:border-gray-700">
    <dl class="divide-y divide-gray-200 dark:divide-gray-700">
        @foreach ($items as $item)
        <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                {{ $item['label'] }}
            </dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                {{ $item['value'] ?? 'No especificado' }}
            </dd>
        </div>
        @endforeach
    </dl>
</div>