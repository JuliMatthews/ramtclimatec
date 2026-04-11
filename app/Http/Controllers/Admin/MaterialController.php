<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materiales = Material::orderBy('nombre')->paginate(10);
        return view('admin.materiales.index', compact('materiales'));
    }

    public function create()
    {
        return view('admin.materiales.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required']);
        Material::create($request->all());
        return redirect()->route('admin.materiales.index')->with('success', 'Material creado');
    }

    public function edit(Material $material)
    {
        return view('admin.materiales.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $request->validate(['nombre' => 'required']);
        $material->update($request->all());
        return redirect()->route('admin.materiales.index')->with('success', 'Material actualizado');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('admin.materiales.index')->with('success', 'Material eliminado');
    }
}