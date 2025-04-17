<div>
    <div class="px-4 py-5 sm:px-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                        <span class="text-2xl font-medium text-gray-600 dark:text-gray-300">
                            {{ $staffMember->initials() }}
                        </span>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">
                        {{ $staffMember->name }}
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                        {{ $staffMember->email }}
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30">
                    {{ $role ? ucfirst($role) : 'Sin rol' }}
                </span>
                <span class="inline-flex items-center rounded-md {{ $staffMember->pivot?->is_active ? 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-400/10 dark:text-green-400 dark:ring-green-400/30' : 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-400/10 dark:text-red-400 dark:ring-red-400/30' }} px-2 py-1 text-xs font-medium ring-1 ring-inset">
                    {{ $staffMember->pivot?->is_active ? 'Activo' : 'Inactivo' }}
                </span>
            </div>
        </div>
    </div>

    <div class="border-t border-gray-200 dark:border-gray-700">
        <dl class="divide-y divide-gray-200 dark:divide-gray-700">
            <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                    {{ $staffMember->phone ?? 'No especificado' }}
                </dd>
            </div>

            <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Correo Electrónico</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                    {{ $staffMember->email ?? 'No especificado' }}
                </dd>
            </div>

            <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Roles del Sistema</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                    <div class="flex flex-wrap gap-2">
                        @forelse($roles as $roleName)
                            <span class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-700/10 dark:bg-purple-400/10 dark:text-purple-400 dark:ring-purple-400/30">
                                {{ ucfirst($roleName) }}
                            </span>
                        @empty
                            <span class="text-gray-500 dark:text-gray-400">Sin roles asignados</span>
                        @endforelse
                    </div>
                </dd>
            </div>

            <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Permisos</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                    <div class="flex flex-wrap gap-2">
                        @forelse($permissions as $permission)
                            <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10 dark:bg-indigo-400/10 dark:text-indigo-400 dark:ring-indigo-400/30">
                                {{ $permission }}
                            </span>
                        @empty
                            <span class="text-gray-500 dark:text-gray-400">Sin permisos asignados</span>
                        @endforelse
                    </div>
                </dd>
            </div>

            <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de registro</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                    {{ $staffMember->created_at->format('d/m/Y H:i') }}
                </dd>
            </div>
        </dl>
    </div>

    @if($canManageStaff)
        <div class="mt-6 flex justify-end space-x-3">
            <flux:button href="{{ route('staff.index') }}">
                Volver
            </flux:button>
            <flux:button>
                Editar
            </flux:button>
        </div>
    @endif
</div>
