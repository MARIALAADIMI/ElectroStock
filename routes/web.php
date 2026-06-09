<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProduitController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ClientController::class, 'index']);
Route::get('/produits', [ProduitController::class, 'index'])->name('produits.index');
Route::post('/produit', [ProduitController::class, 'store'])->name('produits.store');
Route::put('/produit/{produit}', [ProduitController::class, 'update'])->name('produits.update');
Route::delete('/produit/{produit}', [ProduitController::class, 'destroy'])->name('produits.destroy');
