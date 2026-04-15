<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-blue-700 text-white p-6 rounded-t-lg shadow-lg flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold uppercase">Plan National du Numérique - RDC</h1>
                    <p class="text-blue-200">Suivi du Projet 3 : Identification électronique</p>
                </div>
                <img src="/photos/logo-rdc.png" alt="RDC Logo" class="h-16">
            </div>

            <div class="bg-white overflow-hidden shadow-xl overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-300 text-sm">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th rowspan="2" class="border border-gray-300 p-3 w-1/6">Désignation des Projets</th>
                            <th rowspan="2" class="border border-gray-300 p-3 w-1/4">Objectifs</th>
                            <th rowspan="2" class="border border-gray-300 p-3">Indicateurs</th>
                            <th colspan="2" class="border border-gray-300 p-2">Valeur de référence</th>
                            <th colspan="2" class="border border-gray-300 p-2">Valeur cible</th>
                            <th rowspan="2" class="border border-gray-300 p-3">Priorité</th>
                        </tr>
                        <tr class="bg-blue-500">
                            <th class="border border-gray-300 p-2 text-xs uppercase text-center">Année</th>
                            <th class="border border-gray-300 p-2 text-xs uppercase text-center">Valeur</th>
                            <th class="border border-gray-300 p-2 text-xs uppercase text-center">Année</th>
                            <th class="border border-gray-300 p-2 text-xs uppercase text-center">Valeur</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 bg-gray-50">
                        <tr>
                            <td class="border border-gray-300 p-4 font-bold bg-white text-center">
                                Projet 3 : <br>
                                <span class="font-normal text-xs italic">Identification électronique de toute la population</span>
                            </td>
                            <td class="border border-gray-300 p-4 text-xs bg-white">
                                Instauration de l'identifiant numérique unique (État civil, Casier judiciaire, Passeport, Étudiant...)
                            </td>
                            <td class="border border-gray-300 p-4 text-center text-xs bg-white">
                                Fichiers mis en place ou numérisés
                            </td>
                            <td class="border border-gray-300 p-2 text-center bg-white italic">2019</td>
                            <td class="border border-gray-300 p-2 text-center bg-white font-bold">0</td>
                            <td class="border border-gray-300 p-2 text-center bg-white italic">2023</td>
                            <td class="border border-gray-300 p-2 text-xs bg-white">
                                Registre général en place, Casier judiciaire numérisé, Passeport local...
                            </td>
                            <td class="border border-gray-300 p-4 text-center font-bold text-blue-700 bg-white">P1</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('citizen.create') }}" class="bg-blue-800 hover:bg-blue-900 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Nouvel Enrôlement (ID Unique)
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
