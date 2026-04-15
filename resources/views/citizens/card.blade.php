<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carte d'Identité N° {{ $citizen->national_id }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        nav { display: none !important; }
    
        /* CSS SUR MESURE POUR LE DESIGN DE TA CARTE */
        body {
            font-family: 'Helvetica', sans-serif;
            margin: 0;
            padding: 0;
            background: #f1f5f9; /* slate-100 */
        }

        /* Format de la carte CR80 (85.6mm x 53.98mm) */
        .card {
            width: 85.6mm;
            height: 53.98mm;
            margin: 20px auto;
            border-radius: 6mm;
            overflow: hidden;
            position: relative;
            background: #ffffff; /* Pour la bordure rouge */
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        /* Corps de la carte avec le dégradé de bleu */
        .card-body {
            position: absolute;
            top: 0;
            left: 0;
            width: calc(100% - 4.5mm); /* Laisse de l'espace pour la bordure rouge */
            height: 100%;
            border-radius: 6mm 0 0 6mm; /* Rayon juste à gauche */
            padding: 8px;
            color: #ffffff;
            z-index: 10;
            
            /* DÉGRADÉ EXACT DE TA CARTE */
            background: linear-gradient(135deg, #007FFF 0%, #007FFF 70%, #CE1126 100%);
        }

        /* Bordure rouge sur le côté droit */
        .card-red-border {
            position: absolute;
            top: 0;
            right: 0;
            width: 4.5mm;
            height: 100%;
            background: #CE1126;
            z-index: 5;
        }

        /* Filigrane "RDC" centré et incliné */
        .card-bg-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-25deg);
            font-size: 80px;
            font-weight: 900;
            color: rgba(255, 255, 255, 0.05); /* Opacité très faible */
            text-transform: uppercase;
            z-index: 0;
        }

        /* Style des labels et valeurs */
        .label {
            font-size: 6px;
            font-weight: bold;
            text-transform: uppercase;
            color: #64748b; /* slate-500 */
            margin-top: 1px;
        }
        .value {
            font-size: 10px;
            font-weight: bold;
            color: #ffffff;
            line-height: 1.1;
        }
        .value-large {
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
        }
        .text-yellow-card {
            color: #F7D002; /* Jaune de ta carte */
        }

        /* Masque pour le logo RDC */
        .logo-mask {
            width: 30px;
            height: 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 3px;
        }

    </style>
</head>
<body class="antialiased">

    <div class="card shadow-2xl">
        
        <div class="card-bg-text">RDC</div>

        <div class="card-red-border"></div>

        <div class="card-body">
            
            <div class="flex items-center justify-between border-b border-white border-opacity-30 pb-2 mb-3 z-10 relative">
                <div class="flex items-center gap-2">
                    <div class="logo-mask">
                        <img src="{{ public_path('photos/logo-rdc.png') }}" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <p class="text-[8px] font-black uppercase text-white leading-tight">République Démocratique du Congo</p>
                        <p class="text-[6px] font-bold text-yellow-card uppercase tracking-tighter">Office National d'Identification de la Population</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="label">Numéro National (NN)</p>
                    <p class="value font-mono text-[11px] text-yellow-card animate-pulse">{{ $citizen->national_id }}</p>
                </div>
            </div>

            <div class="flex gap-4 z-10 relative">
                
                <div class="flex flex-col gap-1 items-center" style="width: 80px;">
                    <div class="w-20 h-24 bg-white bg-opacity-10 rounded-xl border-2 border-white border-opacity-40 overflow-hidden shadow-inner backdrop-blur-sm">
                        <img src="{{ public_path('storage/' . $citizen->photo) }}" class="w-full h-full object-cover">
                    </div>
                    <div class="text-center mt-1">
                        <span class="text-[5px] uppercase italic text-white opacity-40">Signature du Titulaire</span>
                        <p class="text-[8px] font-bold text-white leading-none">{{ $citizen->first_name }}</p>
                    </div>
                </div>

                <div class="flex-1 grid grid-cols-2 gap-x-3 gap-y-1">
                    <div class="col-span-2">
                        <p class="label">Noms</p>
                        <p class="value value-large truncate text-white leading-none">{{ $citizen->last_name }} {{ $citizen->middle_name }}</p>
                        <p class="value text-sm font-bold opacity-90 text-white">{{ $citizen->first_name }}</p>
                    </div>

                    <div><p class="label">Né(e) le</p><p class="value text-white">{{ $citizen->birth_date }}</p></div>
                    <div><p class="label">À</p><p class="value text-white truncate">{{ $citizen->birth_place }}</p></div>
                    
                    <div><p class="label">Père</p><p class="value text-[8px] font-bold text-white truncate">{{ $citizen->father_name }}</p></div>
                    <div><p class="label">Mère</p><p class="value text-[8px] font-bold text-white truncate">{{ $citizen->mother_name }}</p></div>

                    <div><p class="label">Province</p><p class="value text-white truncate">{{ $citizen->province }}</p></div>
                    <div><p class="label">Territoire</p><p class="value text-white truncate">{{ $citizen->territory }}</p></div>

                    <div class="col-span-2 mt-1">
                        <p class="label">Adresse Actuelle</p>
                        <p class="value text-[8px] font-bold text-white truncate">{{ $citizen->address }}</p>
                    </div>
                </div>

                <div class="flex flex-col items-center justify-between pb-1" style="width: 50px;">
                    <div class="text-center">
                        <p class="label text-yellow-card">Sexe</p>
                        <p class="value text-lg font-black text-white leading-none">{{ $citizen->gender }}</p>
                    </div>
                    
                    <div class="w-16 h-16 bg-white bg-opacity-10 p-1 rounded-lg border border-white border-opacity-30 backdrop-blur-md flex items-center justify-center">
                        <img src="{{ $qrBase64 }}" class="w-full h-full object-contain">
                    </div>
                </div>

            </div>

        </div>
    </div>

</body>
</html>