<x-app-layout>

    <div class="flex min-h-screen bg-gray-100">

        <!-- Sidebar -->

        
        <aside class="w-64 bg-gray-900 text-white p-6">
            <h2 class="text-2xl font-bold mb-6">Agent Panel</h2>
    
            <ul class="space-y-4">
                <li><a href="#" class="hover:text-blue-400">Dashboard</a></li>
                <li><a href="#" class="hover:text-blue-400">Demandes à valider</a></li>
                <li><a href="#" class="hover:text-blue-400">Demandes validées</a></li>
                <li><a href="#" class="hover:text-blue-400">Demandes refusées</a></li>
            </ul>
        </aside>
    
        <!-- Main content -->
        <main class="flex-1 p-6">
    
            <!-- Cards -->
            <div class="grid grid-cols-4 gap-4 mb-6">
    
                <div class="bg-white p-4 rounded-xl shadow">
                    <p class="text-gray-500">En attente</p>
                    <p class="text-2xl font-bold">{{$nombre_Heb }}</p>
                </div>
    
                <div class="bg-white p-4 rounded-xl shadow">
                    <p class="text-gray-500">Validées</p>
                    <p class="text-2xl font-bold">30</p>
                </div>
    
                <div class="bg-white p-4 rounded-xl shadow">
                    <p class="text-gray-500">Refusées</p>
                    <p class="text-2xl font-bold">5</p>
                </div>
    
                <div class="bg-white p-4 rounded-xl shadow">
                    <p class="text-gray-500">Total</p>
                    <p class="text-2xl font-bold">47</p>
                </div>
    
            </div>
    
            <!-- Table -->
            <div class="bg-white rounded-xl shadow p-4">
    
                <h3 class="text-xl font-bold mb-4">Demandes à valider</h3>
    
                <table class="w-full text-left">
                    <thead>
                        
                        <a href="">
                            <tr class="border-b">
                            
                            <th class="px-4 py-2 border">Hébergement</th>
                            <th class="px-4 py-2 border">hote</th>
                            <th class="px-4 py-2 border">Type</th>
                            <th class="px-4 py-2 border">Description</th>
                            <th class="px-4 py-2 border">Service</th>
                            <th class="px-4 py-2 border">Nombre chambre</th>
                            <th class="px-4 py-2 border">Nombre lit</th>
                         
                            <th class="px-4 py-2 border text-center">Actions</th>
                            </tr>
                        </a>    
                    </thead>
    
                    <tbody>
                   
                    @foreach ($Hebergs as $Heberg )
                            
                      
                   
                        <tr class="border-b">
                            
                            <td class="p-2">{{$Heberg->nomHeberg}}</td>
                            <td class="p-2">{{$Heberg->hote_name}}</td>
                            <td class="p-2">{{$Heberg->typeHeberg}}</td>
                            <td class="p-2">{{$Heberg->Description}}</td>
                            
                            <td class="p-2">{{$Heberg->service}}</td>
                            <td class="p-2">{{$Heberg->nombre_chambre}}</td>
                            <td class="p-2">{{$Heberg->nombre_lit}}</td>
                            <td class="p-2 space-x-2">
                                <button class="bg-green-500 text-white px-3 py-1 rounded">Valider</button>
                                <button class="bg-red-500 text-white px-3 py-1 rounded">Refuser</button>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
    
            </div>
    
        </main>
    
    </div>
    
    
</x-app-layout>
  