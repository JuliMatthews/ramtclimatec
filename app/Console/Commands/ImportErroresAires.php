<?php

namespace App\Console\Commands;

use App\Models\ErrorAire;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportErroresAires extends Command
{
    protected $signature = 'import:errores-aires';
    protected $description = 'Importar errores de aires acondicionados desde Excel';

    public function handle()
    {
        $this->info('Importando errores...');
        
        $data = Excel::toCollection(null, storage_path('app/errores_aires_acondicionados.xlsx'));
        
        if (isset($data[0])) {
            foreach ($data[0]->skip(1) as $row) {
                $rowArray = $row->toArray();
                if (isset($rowArray[2]) && !empty(trim($rowArray[2]))) {
                    ErrorAire::create([
                        'codigo' => isset($rowArray[0]) ? trim($rowArray[0]) : null,
                        'marca' => isset($rowArray[1]) ? trim($rowArray[1]) : null,
                        'error' => isset($rowArray[2]) ? trim($rowArray[2]) : '',
                        'causa' => isset($rowArray[3]) ? trim($rowArray[3]) : null,
                        'solucion' => isset($rowArray[4]) ? trim($rowArray[4]) : null,
                    ]);
                }
            }
        }
        
        $this->info('Importación completada.');
        $this->info('Total de errores: ' . ErrorAire::count());
        
        return 0;
    }
}