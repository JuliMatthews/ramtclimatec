<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ayudante;
use Illuminate\Http\Request;

class AyudanteController extends Controller
{
    public function index()
    {
        $ayudantes = Ayudante::orderBy('nombre')->paginate(10);
        return view('admin.ayudantes.index', compact('ayudantes'));
    }

    public function create()
    {
        return view('admin.ayudantes.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required']);
        Ayudante::create($request->all());
        return redirect()->route('admin.ayudantes.index')->with('success', 'Ayudante creado');
    }

    public function edit(Ayudante $ayudante)
    {
        return view('admin.ayudantes.edit', compact('ayudante'));
    }

    public function update(Request $request, Ayudante $ayudante)
    {
        $request->validate(['nombre' => 'required']);
        $ayudante->update($request->all());
        return redirect()->route('admin.ayudantes.index')->with('success', 'Ayudante actualizado');
    }

    public function destroy(Ayudante $ayudante)
    {
        $ayudante->delete();
        return redirect()->route('admin.ayudantes.index')->with('success', 'Ayudante eliminado');
    }
}