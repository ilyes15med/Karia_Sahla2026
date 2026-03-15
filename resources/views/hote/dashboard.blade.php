<x-app-layout>

    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Liste des Hébergements</h2>
    
        <div class="overflow-x-auto">
            <a href="/hote/dashboard/Demande" class="m-0.5 bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                Demande l'ajoute
            </a>
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
                
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">Hébergement</th>
                        <th class="px-4 py-2 border">Type</th>
                        <th class="px-4 py-2 border">Description</th>
                        <th class="px-4 py-2 border">Service</th>
                        <th class="px-4 py-2 border">Nombre chambre</th>
                        <th class="px-4 py-2 border">Nombre lit</th>
                        <th class="px-4 py-2 border">Images</th>
                        <th class="px-4 py-2 border text-center">Actions</th>
                    </tr>
                </thead>
    
                <tbody class="text-center">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">Hotel El Andalus</td>
                        <td class="px-4 py-2 border">Hotel</td>
                        <td class="px-4 py-2 border">Hôtel confortable au centre</td>
                        <td class="px-4 py-2 border">WiFi, Parking</td>
                        <td class="px-4 py-2 border">20</td>
                        <td class="px-4 py-2 border">40</td>
    
                        <!-- Images -->
                        <td class="px-4 py-2 border">
                            <div class="flex justify-center gap-2">
                                <img src="/images/hotel1.jpg" class="w-14 h-14 object-cover rounded">
                                <img src="/images/hotel2.jpg" class="w-14 h-14 object-cover rounded">
                                <img src="/images/hotel3.jpg" class="w-14 h-14 object-cover rounded">
                            </div>
                        </td>
    
                        <td class="px-4 py-2 border space-x-2">
                            <a href="/hote/dashboard/showHeb" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                Afficher
                            </a>
    
                            <a href="" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                Modifier
                            </a>
    
                            <a href="" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                Supprimer
                            </a>
                        </td>
                    </tr>
                </tbody>
    
            </table>
        </div>
    </div>
    
    </x-app-layout>