<?php 

use App\Models\Client;
use Livewire\Volt\Component;

new class extends Component {
    public Client $client;

    public function mount(Client $client)
    {
        $this->client = $client;
    }
}

?>

<div>
    @include('partials.client-detail-heading')
    
    <x-clients.layout :client="$client">
        <x-slot:heading>
            Detalle del cliente
        </x-slot>
        
        <x-slot:subheading>
            Detalle del cliente
        </x-slot>

        <div class="px-4 py-5 sm:px-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                            <span class="text-2xl font-medium text-gray-600 dark:text-gray-300">
                                {{ $client->initials() }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">
                            {{ $client->name }}
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                            {{ $client->email }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30">
                        {{ $client->phone ?? 'Sin teléfono' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700">
            <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                        {{ $client->phone ?? 'No especificado' }}
                    </dd>
                </div>

                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Correo Electrónico</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                        {{ $client->email ?? 'No especificado' }}
                    </dd>
                </div>

                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de registro</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                        {{ $client->created_at->format('d/m/Y H:i') }}
                    </dd>
                </div>
            </dl>
        </div>
    </x-clients.layout>
</div>
