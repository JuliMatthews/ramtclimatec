<x-filament-panels::page>

    <div style="display:flex; justify-content:flex-end; margin-bottom:10px;">

        <a 
            href="{{ route('export.equipos.cliente', $this->record->id) }}"
            style="background-color:#16a34a; color:white; padding:8px 16px; border-radius:6px; text-decoration:none; font-size:14px; font-weight:600;"
        >
            xlsx
        </a>

    </div>

    {{ $this->table }}

</x-filament-panels::page>