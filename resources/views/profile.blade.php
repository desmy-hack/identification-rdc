<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil de {{ $user->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; padding: 20px; }
        .card { background: #fff; padding: 20px; border-radius: 10px; width: 400px; margin: auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1);}
        .card img { width: 150px; height: 150px; border-radius: 50%; object-fit: cover; }
        .card h2 { margin: 10px 0; }
        .card p { margin: 5px 0; color: #555; }
    </style>
</head>
<body>
    <div class="card">
        @if($user->photo)
            <img src="{{ asset($user->photo) }}" alt="Photo de {{ $user->name }}">
        @else
            <img src="https://via.placeholder.com/150" alt="Pas de photo">
        @endif
        <h2>{{ $user->name }}</h2>
        <p><strong>ID National:</strong> {{ $user->national_id ?? 'Non renseigné' }}</p>
        <p><strong>Téléphone:</strong> {{ $user->phone ?? 'Non renseigné' }}</p>
        <p><strong>Adresse:</strong> {{ $user->address ?? 'Non renseigné' }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
    </div>
</body>
</html>
