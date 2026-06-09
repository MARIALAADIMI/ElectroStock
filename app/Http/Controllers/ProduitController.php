<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // $produits = Produit::all();
        $query = $request->query('query');

        $produits = Produit::query()
            ->when($query, function ($q) use ($query) {
                $q->where('code', 'like', "%{$query}%")
                    ->orWhere('libelle', 'like', "%{$query}%")
                     ->orWhere('prix', 'like', "%{$query}%")
                     ->orWhere('qte', 'like', "%{$query}%");
            })
            ->paginate(10);

         $editProduit = $request->has('edit')
        ? Produit::find($request->edit)
        : null;

        return view('produits.index', compact('produits', 'editProduit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:produits|min:2|max:10',
            'libelle' => 'required|string|unique:produits|min:2|max:30',
            'prix' => 'required|numeric',
            'description' => 'nullable|string|max:255',
            'qte' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('produits', 'public');
        }

        Produit::create($validated);

        return redirect()->route('produits.index')->with('success', 'Produit ajouté avec succès.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produit $produit)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:produits,code,'.$produit->id.'|min:2|max:10',
            'libelle' => 'required|string|unique:produits,libelle,'.$produit->id.'|min:2|max:30',
            'prix' => 'required|numeric',
            'description' => 'nullable|string|max:255',
            'qte' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($produit->image) {
                Storage::disk('public')->delete($produit->image);
            }
            $validated['image'] = $request->file('image')->store('produits', 'public');
        }

        $produit->update($validated);

        return redirect()->route('produits.index')->with('success', 'Produit modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        if ($produit->image) {
            Storage::disk('public')->delete($produit->image);
        }
        $produit->delete();

        return redirect()->route('produits.index')->with('success', 'Produit supprimé avec succès.');
    }
}
