<div>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">Reportes de Ingresos</h2>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                Visualiza los reportes de ingresos por gimnasio, mes y año.
            </p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            {{-- @if(count($this->gyms) > 1)
                <div class="w-full sm:w-auto">
                    <flux:select wire:model.live="gymId" label="Gimnasio">
                        <option value="">Todos los gimnasios</option>
                        @foreach($this->gyms as $gym)
                            <option value="{{ $gym->id }}">{{ $gym->name }}</option>
                        @endforeach
                    </flux:select>
                </div>
            @endif --}}
            
            <div class="w-full sm:w-auto">
                <flux:select wire:model.live="reportType" label="Tipo de Reporte">
                    <option value="monthly">Mensual</option>
                    <option value="yearly">Anual</option>
                </flux:select>
            </div>
            
            <div class="w-full sm:w-auto">
                <flux:select wire:model.live="selectedYear" label="Año">
                    @foreach($this->years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </flux:select>
            </div>
            
            @if($reportType === 'monthly')
                <div class="w-full sm:w-auto">
                    <flux:select wire:model.live="selectedMonth" label="Mes">
                        @foreach($this->months as $key => $month)
                            <option value="{{ $key }}">{{ $month }}</option>
                        @endforeach
                    </flux:select>
                </div>
            @endif
            
            <div class="w-full sm:w-auto self-end">
                <flux:button wire:click="generateReports" color="primary" icon="arrow-path">
                    Generar Reporte
                </flux:button>
            </div>
        </div>
    </div>
    
    <div class="overflow-hidden rounded-lg border border-zinc-200 bg-white shadow dark:border-zinc-700 dark:bg-zinc-800">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-700/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Gimnasio
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Período
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Ingresos
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Suscripciones Activas
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Nuevas Suscripciones
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Suscripciones Vencidas
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-700 dark:bg-zinc-800">
                    @forelse($reports as $report)
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ $report->gym->name }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    @if($report->report_type === 'monthly')
                                        {{ $this->months[$report->month] }} de {{ $report->year }}
                                    @else
                                        {{ $report->year }}
                                    @endif
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <div class="text-sm font-medium text-emerald-600 dark:text-emerald-400">
                                    ${{ number_format($report->total_income, 2) }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    {{ $report->active_subscriptions }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    {{ $report->new_subscriptions }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    {{ $report->expired_subscriptions }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <flux:dropdown>
                                    <flux:button size="xs" color="zinc" icon="ellipsis-horizontal" />
                                    
                                    <flux:menu>
                                        <flux:menu.item wire:click="$dispatch('openModal', { component: 'view-report-details', arguments: { reportId: {{ $report->id }} }})" icon="eye">
                                            Ver Detalles
                                        </flux:menu.item>
                                        
                                        <flux:menu.item wire:click="$dispatch('openModal', { component: 'export-report', arguments: { reportId: {{ $report->id }} }})" icon="arrow-down-tray">
                                            Exportar
                                        </flux:menu.item>
                                    </flux:menu>
                                </flux:dropdown>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                No hay reportes disponibles para los criterios seleccionados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-4">
        {{ $reports->links() }}
    </div>
</div> 