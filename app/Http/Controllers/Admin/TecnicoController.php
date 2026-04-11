<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tecnico;
use Illuminate\Http\Request;

class TecnicoController extends Controller
{
    public function index()
    {
        $tecnicos = Tecnico::orderBy('nombre')->paginate(10);
        return view('admin.tecnicos.index', compact('tecnicos'));
    }

    public function create()
    {
        return view('admin.tecnicos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rut' => 'required|unique:tecnicos',
            'nombre' => 'required',
        ]);

        Tecnico::create($request->all());
        return redirect()->route('admin.tecnicos.index')->with('success', 'Técnico creado correctamente');
    }

    public function show(Tecnico $tecnico)
    {
        return view('admin.tecnicos.show', compact('tecnico'));
    }

    public function edit(Tecnico $tecnico)
    {
        return view('admin.tecnicos.edit', compact('tecnico'));
    }

    public function update(Request $request, Tecnico $tecnico)
    {
        $request->validate([
            'rut' => 'required|unique:tecnicos,rut,' . $tecnico->id,
            'nombre' => 'required',
        ]);

        $tecnico->update($request->all());
        return redirect()->route('admin.tecnicos.index')->with('success', 'Técnico actualizado correctamente');
    }

    public function destroy(Tecnico $tecnico)
    {
        $tecnico->delete();
        return redirect()->route('admin.tecnicos.index')->with('success', 'Técnico eliminado correctamente');
    }
}