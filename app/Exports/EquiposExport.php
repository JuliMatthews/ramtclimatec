<?php

namespace App\Exports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EquiposExport implements FromCollection, WithHeadings
{
    protected $cliente;

    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    public function collection()
    {
        return $this->cliente->equipos->map(function ($equipo) {
            return [
                'Cliente' => $this->cliente->nombre,
                'Dirección' => $this->cliente->direcciones->first()->direccion_completa ?? '-',
                'Ubicación' => $equipo->ubicacion ?? '-',
                'Estado' => $equipo->activo ? 'Activo' : 'Inactivo',
                'Marca' => $equipo->marca ?? '-',
                'Modelo' => $equipo->modelo ?? '-',
                'Número de Serie' => $equipo->numero_serie ?? '-',
                'Tipo de Equipo' => $equipo->tipo_equipo ?? '-',
                'País de Fabricación' => $equipo->pais_fabricacion ?? '-',
                'Fecha de Fabricación' => $equipo->fecha_fabricacion ?? '-',
                'Tensión Nominal' => $equipo->tension_nominal ?? '-',
                'Frecuencia' => $equipo->frecuencia ?? '-',
                'Potencia Calefacción (W)' => $equipo->potencia_calefaccion ?? '-',
                'Potencia Enfriamiento (W)' => $equipo->potencia_enfriamiento ?? '-',
                'Cap. Calefacción (BTU)' => $equipo->capacidad_calefaccion_btu ?? '-',
                'Cap. Enfriamiento (BTU)' => $equipo->capacidad_enfriamiento_btu ?? '-',
                'Masa Refrigerante (kg)' => $equipo->masa_refrigerante ?? '-',
                'Tipo Refrigerante' => $equipo->tipo_refrigerante ?? '-',
                'Presión Mínima (bar)' => $equipo->presion_minima ?? '-',
                'Presión Máxima (bar)' => $equipo->presion_maxima ?? '-',
                'Última Mantención' => $equipo->ultima_mantencion ? $equipo->ultima_mantencion->format('d-m-Y') : '-',
                'Próxima Mantención' => $equipo->proxima_mantencion ? $equipo->proxima_mantencion->format('d-m-Y') : '-',
                'Observaciones' => $equipo->observaciones ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Cliente',
            'Dirección',
            'Ubicación',
            'Estado',
            'Marca',
            'Modelo',
            'Número de Serie',
            'Tipo de Equipo',
            'País de Fabricación',
            'Fecha de Fabricación',
            'Tensión Nominal',
            'Frecuencia',
            'Potencia Calefacción (W)',
            'Potencia Enfriamiento (W)',
            'Cap. Calefacción (BTU)',
            'Cap. Enfriamiento (BTU)',
            'Masa Refrigerante (kg)',
            'Tipo Refrigerante',
            'Presión Mínima (bar)',
            'Presión Máxima (bar)',
            'Última Mantención',
            'Próxima Mantención',
            'Observaciones',
        ];
    }
}