<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\ProfileController;

Route::get('/', [ClientController::class, 'index']);
Route::get('/Dashboard', [DashboardController::class, 'Dashboard'])->middleware(['auth', 'verified'])->name('dashboard');



// Routes pour les produits

Route::get('/produits', [ProduitController::class, 'index'])->name('produits.index');
Route::post('/produit', [ProduitController::class, 'store'])->name('produits.store');
Route::put('/produit/{produit}', [ProduitController::class, 'update'])->name('produits.update');
Route::delete('/produit/{produit}', [ProduitController::class, 'destroy'])->name('produits.destroy');


// Routes pour les clients

Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
Route::post('/client', [ClientController::class, 'store'])->name('clients.store');
Route::put('/client/{client}', [ClientController::class, 'update'])->name('clients.update');
Route::delete('/client/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');


// Routes pour les factures
Route::get('/factures', [FactureController::class, 'index'])->name('factures.index');
Route::get('/addfacture', [FactureController::class, 'create'])->name('factures.create');
Route::post('/facture', [FactureController::class, 'store'])->name('factures.store');
Route::get('/facture/{facture}', [FactureController::class, 'show'])->name('factures.show');
Route::get('/facture/{facture}/pdf', [FactureController::class, 'generatePDF'])->name('factures.pdf');








Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
