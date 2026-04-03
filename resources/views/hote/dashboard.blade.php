
    <x-app-layout>
     
       

        <div class="flex min-h-screen bg-gray-100">
    
            <!-- Sidebar -->
             
            @include('hote.aside.aside')
            
       
           
        
            <!-- Main content -->
            <main class="flex-1 p-4">
        
              
        
                <!-- Table -->
                <div class="bg-white rounded-xl shadow p-4">
                    <a href="/hote/dashboard/Heb" class="m-0.5 bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                        Demande l'ajoute
                    </a>
        
                    <h3 class="text-xl font-bold mb-4">Demande</h3>
        
                    <table class="w-full text-left">
                        <thead>
                            
                            <a href="">
                                <tr class="border-b">
                                
                                <th class="px-4 py-2 border">Hébergement</th>
                                <th class="px-4 py-2 border">hote</th>
                                <th class="px-4 py-2 border">Type</th>
                             
                                <th class="px-4 py-2 border">Services</th>
                               
                             
                                <th class="px-4 py-2 border text-center">Actions</th>
                                </tr>
                            </a>    
                        </thead>
        
                        <tbody>

                        @foreach ($HebergCours as $Heberg )
                                
                          
                       
                            <tr class="border-b">
                                
                                <td class="p-2">{{$Heberg->nomHeberg}}</td>
                                <td class="p-2">{{$Heberg->hote_name}}</td>
                                <td class="p-2">{{$Heberg->typeHeberg}}</td>
                                
                                
                                <td class="p-2">{{$Heberg->service}}</td>
                                
                                <td class="px-4 py-2 border space-x-2">
                                    <button onclick="afficherHeb({{ $Heberg->id }})" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                        Afficher
                                    </button>
            
                                    <button onclick="openModal({{ $Heberg->id }})" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                        Modifier
                                    </button>
            
                                    <button onclick="supprimerHeb({{ $Heberg->id }})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                       
                   
                        </tbody>
                    </table>
        
                </div>
        
            </main>
        
        </div>
  
        
        
    </x-app-layout>

    
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
    
    <script>
        function openModal(id) {
        document.getElementById('confirmModal').classList.remove('hidden');
        
        let url = "/hote/Hebergement/" + id + "/edit";
        document.getElementById('confirmBtn').href = url;
        }
    
        
        function closeModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }
        function supprimerHeb(id){
            document.getElementById('confirmModal').classList.remove('hidden');
        
            let url = "/hote/Hebergement/"+id+"/delete";
            document.getElementById('confirmBtn').href = url;

      

        }
        function afficherHeb(id){

            document.getElementById('confirmModal').classList.remove('hidden');
            let url = "/hote/Hebergement/"+id;
            document.getElementById('confirmBtn').href = url;

        }
        
     
    </script>
    