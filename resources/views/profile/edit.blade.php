@extends('layouts.app')

@section('title', 'Mon Profil')
@section('page_title', 'Mon Profil')

@section('content')
    @if (session('status')) <div class="alert-success">Mis à jour avec succès.</div> @endif
    @if ($errors->any()) <div class="alert-danger"><ul style="margin: 0; padding-left: 20px;">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul></div> @endif

    <div class="card">
        <h2>Informations du profil</h2>
        <form method="POST" action="{{ route('profile.update') }}"> @csrf @method('PUT')
            <div class="form-group" style="max-width: 400px;"><label>Nom complet</label><input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required></div>
            <div class="form-group" style="max-width: 400px;"><label>Email</label><input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required></div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>

    <div class="card">
        <h2>Modifier le mot de passe</h2>
        <form method="POST" action="{{ route('password.update') }}"> @csrf @method('PUT')
            <div class="form-group" style="max-width: 400px;"><label>Mot de passe actuel</label><input type="password" name="current_password" required></div>
            <div class="form-group" style="max-width: 400px;"><label>Nouveau mot de passe</label><input type="password" name="password" required></div>
            <div class="form-group" style="max-width: 400px;"><label>Confirmer</label><input type="password" name="password_confirmation" required></div>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>

    <div class="card" style="border: 2px solid #dc3545;">
        <h2 style="color: #dc3545;">Supprimer le compte</h2>
        <form method="POST" action="{{ route('profile.destroy') }}"> @csrf @method('DELETE')
            <div class="form-group" style="max-width: 400px;"><label>Confirmez avec votre mot de passe</label><input type="password" name="password" required></div>
            <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer définitivement ?')">Supprimer mon compte</button>
        </form>
    </div>
@endsection