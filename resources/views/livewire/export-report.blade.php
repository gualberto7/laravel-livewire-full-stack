<div>
    <div class="sm:flex sm:items-start">
        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10 dark:bg-emerald-900/20">
            <flux:icon name="heroicon-o-arrow-down-tray" class="h-6 w-6 text-emerald-600 dark:text-emerald-400" />
        </div>
        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
            <h3 class="text-base font-semibold leading-6 text-zinc-900 dark:text-zinc-100">
                Exportar Reporte
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
        <div class="rounded-lg bg-zinc-50 p-4 dark:bg-zinc-800/50">
            <h4 class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Formato de Exportación</h4>
            <div class="mt-4 space-y-4">
                <div class="flex items-center">
                    <flux:radio wire:model="format" value="pdf" id="format-pdf" />
                    <label for="format-pdf" class="ml-3 block text-sm font-medium leading-6 text-zinc-900 dark:text-zinc-100">
                        PDF
                    </label>
                </div>
                <div class="flex items-center">
                    <flux:radio wire:model="format" value="excel" id="format-excel" />
                    <label for="format-excel" class="ml-3 block text-sm font-medium leading-6 text-zinc-900 dark:text-zinc-100">
                        Excel
                    </label>
                </div>
                <div class="flex items-center">
                    <flux:radio wire:model="format" value="csv" id="format-csv" />
                    <label for="format-csv" class="ml-3 block text-sm font-medium leading-6 text-zinc-900 dark:text-zinc-100">
                        CSV
                    </label>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-6 flex justify-end gap-3">
        <flux:button wire:click="$dispatch('closeModal')" color="zinc">
            Cancelar
        </flux:button>
        <flux:button wire:click="export" color="primary">
            Exportar
        </flux:button>
    </div>
</div> 