<?php

namespace App\Http\Controllers;

use App\Models\Boleto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BoletoController extends Controller
{
    public function index()
    {
        return Inertia::render('Boletos/Index', [
            'boletos' => Boleto::with('cliente')->get(),
            'clientes' => Cliente::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'nome_devedor' => 'required|max:255',
            'data_vencimento' => 'required|date',
            'titulo_numero' => 'required|max:255',
            'valor' => 'required|numeric',
            'juro' => 'required|numeric',
        ]);

        Boleto::create($validated);

        return redirect()->route('boletos.index')
            ->with('message', 'Boleto criado com sucesso!');
    }

    public function update(Request $request, Boleto $boleto)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'nome_devedor' => 'required|max:255',
            'data_vencimento' => 'required|date',
            'titulo_numero' => 'required|max:255',
            'valor' => 'required|numeric',
            'juro' => 'required|numeric',
        ]);

        $boleto->update($validated);

        return redirect()->route('boletos.index')
            ->with('message', 'Boleto atualizado com sucesso!');
    }

    public function destroy(Boleto $boleto)
    {
        $boleto->delete();

        return redirect()->route('boletos.index')
            ->with('message', 'Boleto excluído com sucesso!');
    }
}
