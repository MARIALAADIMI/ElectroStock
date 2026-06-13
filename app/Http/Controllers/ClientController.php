<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->query('query');

        $clients = Client::query()
            ->when($query, function ($q) use ($query) {
                $q->where('cin', 'like', "%{$query}%")
                  ->orWhere('nom', 'like', "%{$query}%")
                  ->orWhere('prenom', 'like', "%{$query}%")
                  ->orWhere('tel', 'like', "%{$query}%");
            })
            ->paginate(10);

        $editClient = $request->has('edit') ? Client::find($request->edit) : null;

        return view('clients.index', compact('clients', 'editClient'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cin' => 'required|string|unique:clients|min:5|max:8',
            'nom' => 'required|string|min:2|max:30',
            'prenom' => 'required|string|min:2|max:30',
            'tel' => ['required', 'regex:/^(\\+212|0)[567][0-9]{8}$/'],
        ], [
            'tel.regex' => 'Le numéro de téléphone doit être valide (Ex: 0612345678 ou +212612345678)',
        ]);

        Client::create($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client ajouté avec succès.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'cin' => 'required|string|unique:clients,cin,' . $client->id . '|min:5|max:8',
            'nom' => 'required|string|min:2|max:30',
            'prenom' => 'required|string|min:2|max:30',
            'tel' => ['required', 'regex:/^(\\+212|0)[567][0-9]{8}$/'],
        ], [
            'tel.regex' => 'Le numéro de téléphone doit être valide (Ex: 0612345678 ou +212612345678)',
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client supprimé avec succès.');
    }
}