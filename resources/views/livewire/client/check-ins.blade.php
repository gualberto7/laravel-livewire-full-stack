<?php 

use App\Models\Client;
use Livewire\Volt\Component;
use App\Traits\VerifiesGymAccess;

new class extends Component {
    use VerifiesGymAccess;

    public Client $client;
    public $currentGym;
    public $checkIns;

    public function mount(Client $client)
    {
        $this->verifyGymAccess($client);
        $this->client = $client;
        $this->currentGym = auth()->user()->getCurrentGym();
        $this->checkIns = $client->checkIns()
            ->where('gym_id', $this->currentGym->id)
            ->latest()
            ->take(15)
            ->get();
    }
}

?>

<div>
    @include('partials.client-detail-heading')

    <x-clients.layout :client="$client">
        <x-slot:heading>
            Check-ins
        </x-slot>

        <div>
            <x-gc.table>
                <x-slot:header>
                    <tr>
                        <x-gc.th>
                            Fecha
                        </x-gc.th>
                        <x-gc.th>
                            Hora
                        </x-gc.th>
                        <x-gc.th>
                            Registrado por
                        </x-gc.th>
                    </tr>
                </x-slot:header>
                @forelse ($checkIns as $checkIn)
                    <tr>
                        <x-gc.td>
                            {{ $checkIn->created_at->format('d/m/Y') }}
                        </x-gc.td>
                        <x-gc.td>
                            {{ $checkIn->created_at->format('H:i') }}
                        </x-gc.td>
                        <x-gc.td>
                            {{ $checkIn->created_by }}
                        </x-gc.td>
                    </tr>
                @empty
                    <tr>
                        <x-gc.td colspan="4" class="text-center">
                            No hay check-ins.
                        </x-gc.td>
                    </tr>
                @endforelse
            </x-gc.table>
        </div>
    </x-clients.layout>
</div>
