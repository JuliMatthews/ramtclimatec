<x-filament-panels::page>
    <div class="space-y-6">

        {{-- Leyenda --}}
        <div class="flex flex-wrap gap-3">
            <span style="background:#fee2e2;color:#b91c1c;padding:4px 12px;border-radius:999px;font-size:12px;font-weight:600;">● Vencida</span>
            <span style="background:#ffedd5;color:#c2410c;padding:4px 12px;border-radius:999px;font-size:12px;font-weight:600;">● Menos de 15 días</span>
            <span style="background:#fef9c3;color:#a16207;padding:4px 12px;border-radius:999px;font-size:12px;font-weight:600;">● Menos de 30 días</span>
            <span style="background:#dcfce7;color:#15803d;padding:4px 12px;border-radius:999px;font-size:12px;font-weight:600;">● Al día</span>
        </div>

        {{-- Tabla --}}
        <x-filament::section>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left divide-y divide-gray-200 dark:divide-white/5">
                    <thead>
                        <tr class="text-xs uppercase text-gray-500 dark:text-gray-400">
                            <th class="px-4 py-3 font-medium">Equipo</th>
                            <th class="px-4 py-3 font-medium">Ubicación</th>
                            <th class="px-4 py-3 font-medium">Cliente</th>
                            <th class="px-4 py-3 font-medium">Próxima Mantención</th>
                            <th class="px-4 py-3 font-medium">Días restantes</th>
                            <th class="px-4 py-3 font-medium">Estado</th>
                            <th class="px-4 py-3 font-medium">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                        @forelse($this->getClientes() as $cliente)
                            @php
                                $badgeStyle = match($cliente->alerta) {
                                    'vencida' => 'background:#fee2e2;color:#b91c1c;',
                                    'urgente' => 'background:#ffedd5;color:#c2410c;',
                                    'proximo' => 'background:#fef9c3;color:#a16207;',
                                    default   => 'background:#dcfce7;color:#15803d;',
                                };

                                $label = match($cliente->alerta) {
                                    'vencida' => '● Vencida',
                                    'urgente' => '● Urgente',
                                    'proximo' => '● Próximo',
                                    default   => '● Al día',
                                };

                                $dias = $cliente->dias_restantes;

                                $diasTexto = $dias < 0
                                    ? abs($dias) . ' días atrás'
                                    : ($dias === 0 ? 'Hoy' : $dias . ' días');
                            @endphp

                            <tr class="text-gray-900 dark:text-gray-100">
                                <td class="px-4 py-3 font-semibold">
                                    {{ $cliente->equipo_info }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $cliente->ubicacion ?? '—' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $cliente->cliente_nombre }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ \Carbon\Carbon::parse($cliente->proxima_mantencion)->format('d/m/Y') }}
                                </td>

                                <td class="px-4 py-3 font-medium">
                                    {{ $diasTexto }}
                                </td>

                                <td class="px-4 py-3">
                                    <span style="{{ $badgeStyle }}padding:4px 10px;border-radius:999px;font-size:12px;font-weight:600;">
                                        {{ $label }}
                                    </span>
                                </td>

                                <td class="px-4 py-3">
                                    <a href="{{ route('filament.admin.resources.orden-trabajos.create', [
                                        'cliente_id' => $cliente->cliente_id,
                                        'direccion_id' => $cliente->direccion_id,
                                    ]) }}"
                                    style="background:#16a34a;color:#fff;padding:5px 12px;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none;">
                                        + Crear OT
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-400 dark:text-gray-500">
                                    No hay equipos con mantención programada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-filament::section>

    </div>
</x-filament-panels::page>