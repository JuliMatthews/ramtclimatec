<?php

namespace Database\Seeders;

use App\Models\Error;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class ErrorSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = storage_path('app/errores_aires_acondicionados.xlsx');

        if (!file_exists($filePath)) {
            $this->command->error('Archivo no encontrado: ' . $filePath);
            return;
        }

        $collection = Excel::toCollection(null, $filePath);
        $rows = $collection[0];

        // Saltar encabezado (primera fila)
        foreach ($rows->skip(1) as $row) {
            if ($row[0] === null) {
                continue;
            }

            Error::create([
                'marca' => $row[0],
                'tipo_equipo' => $row[1],
                'codigo_error' => $row[2],
                'descripcion' => $row[3],
                'causa_probable' => $row[4],
                'solucion' => $row[5],
                'notas' => $row[6] ?? null,
            ]);
        }

        $this->command->info('Errores importados exitosamente.');
    }
}