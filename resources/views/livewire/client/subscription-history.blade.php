<?php 

use App\Models\Client;
use Livewire\Volt\Component;
use App\Traits\VerifiesGymAccess;

new class extends Component {
    use VerifiesGymAccess;

    public Client $client;
    public $currentGym;
    public $subscriptions;

    public function mount(Client $client)
    {
        $this->verifyGymAccess($client);
        $this->client = $client;
        $this->currentGym = auth()->user()->getCurrentGym();
        $this->subscriptions = $client->subscriptionHistories()
            ->where('gym_id', $this->currentGym->id)
            ->latest()
            ->take(50)
            ->get();
    }
}

?>

<div>
    @include('partials.client-detail-heading')

    <x-clients.layout :client="$client">
        <x-slot:heading>
            Historial de suscripciones
        </x-slot>

        <div>
            <x-gc.table>
                <x-slot:header>
                    <tr>
                        <x-gc.th>
                            Fecha Inicio
                        </x-gc.th>
                        <x-gc.th>
                            Fecha Fin
                        </x-gc.th>
                        <x-gc.th>
                            Duración
                        </x-gc.th>
                        <x-gc.th>
                            Suscripción
                        </x-gc.th>
                        <x-gc.th>
                            Precio
                        </x-gc.th>
                    </tr>
                </x-slot>

                @forelse ($subscriptions as $subscription)
                    <tr>
                        <x-gc.td>
                            {{ $subscription->start_date->format('d/m/Y') }}
                        </x-gc.td>
                        <x-gc.td>
                            {{ $subscription->end_date->format('d/m/Y') }}
                        </x-gc.td>
                        <x-gc.td>
                            {{ $subscription->duration }} días
                        </x-gc.td>
                        <x-gc.td>
                            {{ $subscription->membership }}
                        </x-gc.td>
                        <x-gc.td>
                            {{ $subscription->price }} Bs.
                        </x-gc.td>
                    </tr>
                @empty
                    <tr>
                        <x-gc.td colspan="6" class="text-center">
                            No hay historial de suscripciones.
                        </x-gc.td>
                    </tr>
                @endforelse
            </x-gc.table>
        </div>
    </x-clients.layout>
</div>
