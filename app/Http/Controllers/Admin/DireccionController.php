<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Direccion;
use App\Models\Cliente;
use Illuminate\Http\Request;

class DireccionController extends Controller
{
    public function index()
    {
        $direcciones = Direccion::with('cliente')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.direcciones.index', compact('direcciones'));
    }

    public function create()
    {
        $clientes = Cliente::where('activo', true)->orderBy('nombre')->get();
        return view('admin.direcciones.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'calle' => 'required',
            'cliente_id' => 'required',
        ]);

        // Guardar cada campo por separado
        $direccion = new Direccion();
        $direccion->cliente_id = $request->cliente_id;
        $direccion->calle = $request->calle;
        $direccion->numero = $request->numero;
        $direccion->depto = $request->depto;
        $direccion->region = $request->region;
        $direccion->provincia = $request->provincia;
        $direccion->comuna = $request->comuna;
        $direccion->ciudad = $request->ciudad;
        $direccion->telefono = $request->telefono;
        $direccion->referencia = $request->referencia;
        $direccion->save();
        
        return redirect()->route('admin.direcciones.index')->with('success', 'Dirección creada correctamente');
    }

    public function show(Direccion $direccione)
    {
        return view('admin.direcciones.show', compact('direccione'));
    }

    public function edit(Direccion $direccione)
    {
        $clientes = Cliente::where('activo', true)->orderBy('nombre')->get();
        return view('admin.direcciones.edit', compact('direccione', 'clientes'));
    }

    public function update(Request $request, Direccion $direccione)
    {
        $request->validate([
            'calle' => 'required',
            'cliente_id' => 'required',
        ]);

        // Actualizar cada campo por separado
        $direccione->cliente_id = $request->cliente_id;
        $direccione->calle = $request->calle;
        $direccione->numero = $request->numero;
        $direccione->depto = $request->depto;
        $direccione->region = $request->region;
        $direccione->provincia = $request->provincia;
        $direccione->comuna = $request->comuna;
        $direccione->ciudad = $request->ciudad;
        $direccione->telefono = $request->telefono;
        $direccione->referencia = $request->referencia;
        $direccione->save();
        
        return redirect()->route('admin.direcciones.index')->with('success', 'Dirección actualizada correctamente');
    }

    public function destroy(Direccion $direccione)
    {
        $direccione->delete();
        return redirect()->route('admin.direcciones.index')->with('success', 'Dirección eliminada correctamente');
    }

    public function porCliente($clienteId)
    {
        $direcciones = Direccion::where('cliente_id', $clienteId)->get();
        return response()->json($direcciones);
    }
}