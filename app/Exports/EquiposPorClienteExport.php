<?php

namespace App\Exports;

use App\Models\Equipo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EquiposPorClienteExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    protected int $clienteId;

    public function __construct(int $clienteId)
    {
        $this->clienteId = $clienteId;
    }

    public function collection()
    {
        return Equipo::query()
            ->where('cliente_id', $this->clienteId)
            ->get([
                'ubicacion',
                'marca',
                'modelo',
                'capacidad_enfriamiento_btu',
                'tipo_refrigerante',
                'ultima_mantencion',
                'proxima_mantencion',
            ])
            ->map(function ($equipo) {
                return [
                    'Ubicación' => $equipo->ubicacion,
                    'Marca' => $equipo->marca,
                    'Modelo' => $equipo->modelo,
                    'BTU' => $equipo->capacidad_enfriamiento_btu,
                    'Refrigerante' => $equipo->tipo_refrigerante,
                    'Última mantención' => $equipo->ultima_mantencion,
                    'Próxima mantención' => $equipo->proxima_mantencion,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Ubicación',
            'Marca',
            'Modelo',
            'BTU',
            'Refrigerante',
            'Última mantención',
            'Próxima mantención',
        ];
    }
}
