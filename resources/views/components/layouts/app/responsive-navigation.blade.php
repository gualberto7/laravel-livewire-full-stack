<!-- Responsive Navigation Menu -->
<div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
    <div class="space-y-1 pb-3 pt-2">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
        
        <x-responsive-nav-link :href="route('subscriptions')" :active="request()->routeIs('subscriptions')">
            {{ __('Suscripciones') }}
        </x-responsive-nav-link>
        
        <x-responsive-nav-link :href="route('reports')" :active="request()->routeIs('reports')">
            {{ __('Reportes') }}
        </x-responsive-nav-link>
    </div>
    
    // ... existing code ...
</div>

// ... existing code ... 