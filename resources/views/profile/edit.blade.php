<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <style>
        /* CSS IDENTIQUE AU DASHBOARD & AUTRES PAGES */
        body { font-family: Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 0; display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background-color: #2b2d42; color: #fff; padding: 20px 0; display: flex; flex-direction: column; box-shadow: 2px 0 10px rgba(0,0,0,0.1); position: fixed; height: 100vh; overflow-y: auto; }
        .sidebar-header { padding: 0 20px 20px; border-bottom: 1px solid #3d405b; text-align: center; }
        .sidebar-header h2 { margin: 0; font-size: 20px; color: #ef233c; }
        .sidebar-nav { flex: 1; padding: 20px 10px; }
        .sidebar-nav a { display: block; color: #edf2f4; text-decoration: none; padding: 12px 15px; border-radius: 5px; margin-bottom: 5px; transition: background 0.3s; font-size: 15px; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background-color: #3d405b; color: #fff; }
        .logout-form { padding: 0 10px 20px; margin-top: auto; }
        .logout-form button { width: 100%; background: #ef233c; color: white; border: none; padding: 10px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .logout-form button:hover { background: #d90429; }

        .main-content { flex: 1; margin-left: 260px; padding: 30px; }
        .page-header { margin-bottom: 30px; }
        .page-header h1 { margin: 0; color: #333; }
        
        .card { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .card h2 { margin-top: 0; font-size: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; color: #2b2d42; }

        .form-group { margin-bottom: 20px; display: flex; flex-direction: column; }
        .form-group label { margin-bottom: 8px; font-weight: bold; color: #555; font-size: 14px; }
        .form-group input { padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; }
        .form-group input:focus { border-color: #007bff; outline: none; }

        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: opacity 0.2s; text-decoration: none; display: inline-block; }
        .btn-primary { background: #007bff; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .btn:hover { opacity: 0.8; }

        .alert-success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-danger { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; }

        .danger-zone { border: 2px solid #dc3545; }
        .danger-zone h2 { color: #dc3545; }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>ElectroStock</h2>
            <p style="font-size: 12px; color: #8d99ae;">Gestion de Stock</p>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
            <a href="{{ route('produits.index') }}">📦 Produits</a>
            <a href="{{ route('clients.index') }}">👥 Clients</a>
            <a href="{{ route('factures.index') }}">🧾 Factures</a>
            <a href="{{ route('factures.create') }}" style="color: #ef233c;">➕ Nouvelle Facture</a>
            
            <!-- Lien Actif vers le Profil -->
            <a href="{{ route('profile.edit') }}" class="active" style="margin-top: 20px; border-top: 1px solid #3d405b; padding-top: 15px;">👤 Mon Profil</a>
        </nav>
        <div class="logout-form">
            <form action="{{ route('logout') }}" method="POST">@csrf <button type="submit">🚪 Déconnexion</button></form>
        </div>
    </aside>

    <!-- CONTENU PRINCIPAL -->
    <main class="main-content">
        
        <div class="page-header">
            <h1>Mon Profil</h1>
        </div>

        @if (session('status') == 'profile-updated')
            <div class="alert-success">Informations du profil mises à jour avec succès.</div>
        @elseif (session('status') == 'password-updated')
            <div class="alert-success">Mot de passe modifié avec succès.</div>
        @endif

        @if ($errors->any())
            <div class="alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- CARTE 1 : Informations du profil -->
        <div class="card">
            <h2>Informations du profil</h2>
            <p style="color: #666; font-size: 14px; margin-bottom: 20px;">Mettez à jour les informations de votre compte et votre adresse e-mail.</p>
            
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="form-group" style="max-width: 400px;">
                    <label for="name">Nom complet</label>
                    <input id="name" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required autofocus autocomplete="name">
                </div>

                <div class="form-group" style="max-width: 400px;">
                    <label for="email">Adresse e-mail</label>
                    <input id="email" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required autocomplete="email">
                </div>

                @if (auth()->user() instanceof \App\Models\User && auth()->user()->email_verified_at === null)
                    <p style="font-size: 14px; color: #dc3545; margin-bottom: 15px;">
                        Votre adresse e-mail n'est pas vérifiée. 
                        <a href="{{ route('verification.send') }}" style="color: #007bff; text-decoration: underline;">Renvoyer l'e-mail de vérification</a>
                    </p>
                @endif

                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>

        <!-- CARTE 2 : Mot de passe -->
        <div class="card">
            <h2>Modifier le mot de passe</h2>
            <p style="color: #666; font-size: 14px; margin-bottom: 20px;">Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.</p>
            
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <div class="form-group" style="max-width: 400px;">
                    <label for="current_password">Mot de passe actuel</label>
                    <input id="current_password" type="password" name="current_password" required autocomplete="current-password">
                </div>

                <div class="form-group" style="max-width: 400px;">
                    <label for="password">Nouveau mot de passe</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password">
                </div>

                <div class="form-group" style="max-width: 400px;">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-primary">Modifier le mot de passe</button>
            </form>
        </div>

        <!-- CARTE 3 : Supprimer le compte (Zone Dangereuse) -->
        <div class="card danger-zone">
            <h2>Supprimer le compte</h2>
            <p style="color: #666; font-size: 14px; margin-bottom: 20px;">Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées.</p>
            
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')

                <div class="form-group" style="max-width: 400px;">
                    <label for="delete_password" style="color: #dc3545;">Confirmez avec votre mot de passe pour supprimer</label>
                    <input id="delete_password" type="password" name="password" required autocomplete="current-password" placeholder="Votre mot de passe...">
                </div>

                <button type="submit" class="btn btn-danger" onclick="return confirm('⚠️ Êtes-vous absolument sûr de vouloir supprimer votre compte ? Cette action est irréversible.')">Supprimer définitivement mon compte</button>
            </form>
        </div>

    </main>
</body>
</html>