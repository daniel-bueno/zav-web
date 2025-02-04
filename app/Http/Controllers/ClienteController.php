<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClienteController extends Controller
{
    public function index()
    {
        return Inertia::render('Clients/Index', [
            'clientes' => Cliente::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('Clients/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'cnpj' => 'required|max:18'
        ]);

        Cliente::create($validated);

        return redirect()->route('clientes.index')
            ->with('message', 'Cliente criado com sucesso!');
    }

    public function edit(Cliente $cliente)
    {
        return Inertia::render('Clients/Edit', [
            'cliente' => $cliente
        ]);
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'cnpj' => 'required|max:18'
        ]);

        $cliente->update($validated);

        return redirect()->route('clientes.index')
            ->with('message', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('message', 'Cliente excluído com sucesso!');
    }
}
