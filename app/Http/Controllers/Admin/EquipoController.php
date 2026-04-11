<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use App\Models\Cliente;
use App\Models\Direccion;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EquiposExport;

class EquipoController extends Controller
{
    public function index()
    {
        $clientesConEquipos = Cliente::whereHas('equipos')
            ->with(['equipos', 'direcciones'])
            ->orderBy('nombre')
            ->paginate(10);
        return view('admin.equipos.index', compact('clientesConEquipos'));
    }

    public function porCliente(Cliente $cliente)
    {
        $cliente->load(['equipos', 'direcciones']);
        return view('admin.equipos.por-cliente', compact('cliente'));
    }

    public function exportarPdf(Cliente $cliente)
    {
        $cliente->load(['equipos', 'direcciones']);
        $pdf = Pdf::loadView('admin.equipos.pdf', compact('cliente'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('equipos_' . $cliente->nombre . '.pdf');
    }

    public function exportarExcel(Cliente $cliente)
    {
        $cliente->load(['equipos']);
        return Excel::download(new EquiposExport($cliente), 'equipos_' . $cliente->nombre . '.xlsx');
    }

    public function create()
    {
        $clientes = Cliente::where('activo', true)->orderBy('nombre')->get();
        $direcciones = Direccion::orderBy('calle')->get();
        return view('admin.equipos.create', compact('clientes', 'direcciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required',
        ]);

        Equipo::create($request->all());
        return redirect()->route('admin.equipos.index')->with('success', 'Equipo creado correctamente');
    }

    public function show(Equipo $equipo)
    {
        $equipo->load(['cliente', 'direccion', 'ordenesTrabajo']);
        return view('admin.equipos.show', compact('equipo'));
    }

    public function edit(Equipo $equipo)
    {
        $clientes = Cliente::where('activo', true)->orderBy('nombre')->get();
        $direcciones = Direccion::where('cliente_id', $equipo->cliente_id)->orderBy('calle')->get();
        return view('admin.equipos.edit', compact('equipo', 'clientes', 'direcciones'));
    }

    public function update(Request $request, Equipo $equipo)
    {
        $request->validate([
            'cliente_id' => 'required',
        ]);

        $equipo->update($request->all());
        return redirect()->route('admin.equipos.index')->with('success', 'Equipo actualizado correctamente');
    }

    public function destroy(Equipo $equipo)
    {
        $equipo->delete();
        return redirect()->route('admin.equipos.index')->with('success', 'Equipo eliminado correctamente');
    }
}