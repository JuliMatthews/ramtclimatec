<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with(['direcciones', 'equipos'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('admin.clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rut' => 'required|unique:clientes',
            'nombre' => 'required',
            'email' => 'nullable|email',
        ]);

        Cliente::create($request->all());
        return redirect()->route('admin.clientes.index')->with('success', 'Cliente creado correctamente');
    }

    public function show(Cliente $cliente)
    {
        return view('admin.clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('admin.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'rut' => 'required|unique:clientes,rut,' . $cliente->id,
            'nombre' => 'required',
            'email' => 'nullable|email',
        ]);

        $cliente->update($request->all());
        return redirect()->route('admin.clientes.index')->with('success', 'Cliente actualizado correctamente');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('admin.clientes.index')->with('success', 'Cliente eliminado correctamente');
    }
}