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
            Check-ins
    </x-slot>
    
    <x-slot:subheading>
        Check-ins
    </x-slot>

    <div>
    </div>
    </x-clients.layout>
</div>
