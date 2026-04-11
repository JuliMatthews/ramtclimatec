<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrdenTrabajo;
use App\Models\Cliente;
use App\Models\Direccion;
use App\Models\Tecnico;
use App\Models\Ayudante;
use App\Models\Material;
use App\Models\Equipo;
use Illuminate\Http\Request;

class OrdenTrabajoController extends Controller
{
    public function index()
    {
        $ordenes = OrdenTrabajo::with('cliente')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.ordenes_trabajo.index', compact('ordenes'));
    }

    public function create()
    {
        $clientes = Cliente::where('activo', true)->orderBy('nombre')->get();
        $direcciones = Direccion::orderBy('direccion')->get();
        $tecnicos = Tecnico::orderBy('nombre')->get();
        $ayudantes = Ayudante::orderBy('nombre')->get();
        $materiales = Material::orderBy('nombre')->get();
        $equipos = Equipo::orderBy('nombre')->get();
        
        return view('admin.ordenes_trabajo.create', compact('clientes', 'direcciones', 'tecnicos', 'ayudantes', 'materiales', 'equipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required',
            'direccion_id' => 'required',
            'tipo_servicio' => 'required',
            'estado' => 'required',
        ]);

        $orden = OrdenTrabajo::create($request->all());
        
        if ($request->has('tecnicos')) {
            $orden->tecnicos()->attach($request->tecnicos);
        }
        
        if ($request->has('ayudantes')) {
            $orden->ayudantes()->attach($request->ayudantes);
        }

        return redirect()->route('admin.ordenes_trabajo.index')->with('success', 'Orden de Trabajo creada correctamente');
    }

    public function show(OrdenTrabajo $ordenes_trabajo)
    {
        $ordenes_trabajo->load(['cliente', 'direccion', 'tecnicos', 'ayudantes', 'materiales', 'equipos']);
        return view('admin.ordenes_trabajo.show', compact('ordenes_trabajo'));
    }

    public function edit(OrdenTrabajo $ordenes_trabajo)
    {
        $clientes = Cliente::where('activo', true)->orderBy('nombre')->get();
        $direcciones = Direccion::orderBy('direccion')->get();
        $tecnicos = Tecnico::orderBy('nombre')->get();
        $ayudantes = Ayudante::orderBy('nombre')->get();
        $materiales = Material::orderBy('nombre')->get();
        $equipos = Equipo::orderBy('nombre')->get();
        
        $ordenes_trabajo->load(['tecnicos', 'ayudantes', 'materiales', 'equipos']);
        
        return view('admin.ordenes_trabajo.edit', compact('ordenes_trabajo', 'clientes', 'direcciones', 'tecnicos', 'ayudantes', 'materiales', 'equipos'));
    }

    public function update(Request $request, OrdenTrabajo $ordenes_trabajo)
    {
        $request->validate([
            'cliente_id' => 'required',
            'direccion_id' => 'required',
            'tipo_servicio' => 'required',
            'estado' => 'required',
        ]);

        $ordenes_trabajo->update($request->all());
        
        if ($request->has('tecnicos')) {
            $ordenes_trabajo->tecnicos()->sync($request->tecnicos);
        } else {
            $ordenes_trabajo->tecnicos()->detach();
        }
        
        if ($request->has('ayudantes')) {
            $ordenes_trabajo->ayudantes()->sync($request->ayudantes);
        } else {
            $ordenes_trabajo->ayudantes()->detach();
        }

        return redirect()->route('admin.ordenes_trabajo.index')->with('success', 'Orden de Trabajo actualizada correctamente');
    }

    public function destroy(OrdenTrabajo $ordenes_trabajo)
    {
        $ordenes_trabajo->delete();
        return redirect()->route('admin.ordenes_trabajo.index')->with('success', 'Orden de Trabajo eliminada correctamente');
    }
}