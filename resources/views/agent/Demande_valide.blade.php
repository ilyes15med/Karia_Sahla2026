<x-app-layout>

    <div class="flex min-h-screen bg-gray-100">

        <!-- Sidebar -->

        
              
    @include('agent.sideBar')
    
        <!-- Main content -->
        <main class="flex-1 p-6">
    
            <!-- Cards -->
             @include('agent.inf')
    
            <!-- Table -->
            <div class="bg-white rounded-xl shadow p-4">
    
                <h3 class="text-xl font-bold mb-4">Demandes validées</h3>
    
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
                         
                            </tr>
                        </a>    
                    </thead>
    
                    <tbody>
                   
                    @foreach ($HebergValide as $Heberg )
                            
                      
                   
                        <tr class="border-b">
                            
                            <td class="p-2 text-red-600">
                                <a href="/agent/dashboard/Hebergs/{{$Heberg->id}}/show"> 
                                   
                                    {{$Heberg->nomHeberg}} 
                                </a>
                               
                            
                            </td>
                            <td class="p-2">{{$Heberg->hote_name}}</td>
                            <td class="p-2">{{$Heberg->typeHeberg}}</td>
                            <td class="p-2">{{$Heberg->Description}}</td>
                            
                            <td class="p-2">{{$Heberg->service}}</td>
                            <td class="p-2">{{$Heberg->nombre_chambre}}</td>
                            <td class="p-2">{{$Heberg->nombre_lit}}</td>
                          
                        </tr>
                    @endforeach
                    </tbody>
                </table>
    
            </div>
    
        </main>
    
    </div>
    
    
</x-app-layout>


<script>
    function openModal(id) {
    document.getElementById('confirmModal').classList.remove('hidden');
    
    let url = "/agent/dashboard/Hebergs/" + id + "/edit";
    document.getElementById('confirmBtn').href = url;
    }
    
    function closeModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }
    
 
</script>

    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    
    <div class="bg-white p-6 rounded-2xl shadow-lg w-80 text-center">
        
     
        <p class="mb-6"> Êtes-vous sûr de vouloir continuer ?</p>

        <div class="flex justify-center gap-4">
            <!-- Annuler -->
            <button onclick="closeModal()" class="bg-gray-300 px-4 py-2 rounded">
                Annuler
            </button>

            <!-- Confirmer -->
            <a id="confirmBtn" href="#" class="bg-green-500 text-white px-4 py-2 rounded">
                Confirmer
            </a>
        </div>

    </div>
</div>    
