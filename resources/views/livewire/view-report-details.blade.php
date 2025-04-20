<div>
    <div class="sm:flex sm:items-start">
        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10 dark:bg-emerald-900/20">
            <flux:icon name="heroicon-o-document-chart-bar" class="h-6 w-6 text-emerald-600 dark:text-emerald-400" />
        </div>
        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
            <h3 class="text-base font-semibold leading-6 text-zinc-900 dark:text-zinc-100">
                Detalles del Reporte
            </h3>
            <div class="mt-2">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                    {{ $report->gym->name }} - 
                    @if($report->report_type === 'monthly')
                        {{ \Carbon\Carbon::createFromDate($report->year, $report->month, 1)->format('F Y') }}
                    @else
                        {{ $report->year }}
                    @endif
                </p>
            </div>
        </div>
    </div>
    
    <div class="mt-6">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div class="rounded-lg bg-zinc-50 p-4 dark:bg-zinc-800/50">
                <h4 class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Resumen</h4>
                <dl class="mt-2 grid grid-cols-1 gap-2">
                    <div class="flex justify-between">
                        <dt class="text-sm text-zinc-500 dark:text-zinc-400">Ingresos Totales</dt>
                        <dd class="text-sm font-medium text-emerald-600 dark:text-emerald-400">${{ number_format($report->total_income, 2) }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-zinc-500 dark:text-zinc-400">Suscripciones Activas</dt>
                        <dd class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $report->active_subscriptions }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-zinc-500 dark:text-zinc-400">Nuevas Suscripciones</dt>
                        <dd class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $report->new_subscriptions }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-zinc-500 dark:text-zinc-400">Suscripciones Vencidas</dt>
                        <dd class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $report->expired_subscriptions }}</dd>
                    </div>
                </dl>
            </div>
            
            <div class="rounded-lg bg-zinc-50 p-4 dark:bg-zinc-800/50">
                <h4 class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Desglose por Membresía</h4>
                <dl class="mt-2 space-y-2">
                    @foreach($report->membership_breakdown as $name => $data)
                        <div class="flex justify-between">
                            <dt class="text-sm text-zinc-500 dark:text-zinc-400">{{ $name }}</dt>
                            <dd class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $data['count'] }} (${{ number_format($data['total'], 2) }})
                            </dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        </div>
    </div>
    
    <div class="mt-6 flex justify-end gap-3">
        <flux:button wire:click="$dispatch('closeModal')" color="zinc">
            Cerrar
        </flux:button>
    </div>
</div> 