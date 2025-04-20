<!-- Navigation Links -->
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>
    
    <x-nav-link :href="route('subscriptions')" :active="request()->routeIs('subscriptions')">
        {{ __('Suscripciones') }}
    </x-nav-link>
    
    <x-nav-link :href="route('reports')" :active="request()->routeIs('reports')">
        {{ __('Reportes') }}
    </x-nav-link>
</div> 