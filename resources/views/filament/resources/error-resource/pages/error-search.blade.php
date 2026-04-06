<x-filament-panels::page>
    {{ $this->form }}

    @if (!empty($results))
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Resultados ({{ count($results) }})</h2>
            
            <div class="space-y-4">
                @foreach ($results as $error)
                    <div class="border rounded-lg p-6 bg-gray-50 dark:bg-gray-900">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded text-sm font-semibold mr-2">
                                    {{ $error['marca'] }}
                                </span>
                                <span class="inline-block bg-purple-100 text-purple-800 px-3 py-1 rounded text-sm font-semibold">
                                    {{ $error['codigo_error'] }}
                                </span>
                            </div>
                            <span class="text-gray-500 text-sm">{{ $error['tipo_equipo'] }}</span>
                        </div>

                        <h3 class="text-lg font-bold mb-2">{{ $error['descripcion'] }}</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-semibold text-red-600 mb-2">⚠️ Causa Probable:</h4>
                                <p class="text-gray-700 dark:text-gray-300">{{ $error['causa_probable'] }}</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-green-600 mb-2">✅ Solución:</h4>
                                <p class="text-gray-700 dark:text-gray-300">{{ $error['solucion'] }}</p>
                            </div>
                        </div>

                        @if (!empty($error['notas']))
                            <div class="mt-3 pt-3 border-t">
                                <h4 class="font-semibold text-orange-600 mb-1">📝 Notas:</h4>
                                <p class="text-gray-700 dark:text-gray-300 text-sm">{{ $error['notas'] }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @elseif ($form->getState() !== [])
        <div class="mt-8 text-center py-12 text-gray-500">
            <p class="text-lg">No se encontraron errores con esos criterios.</p>
        </div>
    @else
        <div class="mt-8 text-center py-12 text-gray-500">
            <p class="text-lg">Ingresa marca o código para buscar errores.</p>
        </div>
    @endif
</x-filament-panels::page>