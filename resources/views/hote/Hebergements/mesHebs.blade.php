
<x-app-layout>

    <div class="flex min-h-screen bg-gray-100">

        <!-- Sidebar -->
         
        @include('hote.aside.aside')
        
   
       
    
        <!-- Main content -->
        <main class="flex-1 p-4">
    
          
    
            <!-- Table -->
            <div class="bg-white rounded-xl shadow p-4">
            
    
                <h3 class="text-xl font-bold mb-4">mes hébergements</h3>
    
                <table class="p-1 w-full text-center">
                    <thead>
                        
                      
                            <tr class="border-b">
                            
                            <th class="px-4 py-2 border">Hébergement</th>
                            <th class="px-4 py-2 border">hote</th>
                            <th class="px-4 py-2 border">Type</th>
                         
                            <th class="px-4 py-2 border">Service</th>
                            <th class="px-4 py-2 border">Nombre chambre</th>
                           
                         
                            <th class="px-4 py-2 border text-center"></th>
                            </tr>
                        
                    </thead>
    
                    <tbody>

                    @foreach ($Heb_valide as $Heberg )
                            
                      
                   
                        <tr class="border-b">
                       
                            
                            <td class="p-2 text-red">
                                <a href="/hote/MonHebergement/{{$Heberg->id}}" > 
                                    {{$Heberg->nomHeberg}}
                                </a>
                            </td>
                         
                            <td class="p-2">{{$Heberg->hote_name}}</td>
                            <td class="p-2">{{$Heberg->typeHeberg}}</td>
                            
                            
                            <td class="p-2">{{$Heberg->service}}</td>
                            <td class="p-2">{{$Heberg->nombre_chambre}}</td>
                            
                            <td class="">
                                <!-- Statistique -->
    <button 
        onclick="statistique({{ $Heberg->id }})"
        class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg transition duration-200">
        <i class="fa-solid fa-chart-line"></i>
        <span>Statistique</span>
    </button>

    <!-- Modifier -->
    <button 
        onclick="openModal({{ $Heberg->id }})"
        class="flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg transition duration-200">
        <i class="fa-solid fa-pen-to-square"></i>
        <span>Modifier</span>
    </button>

    <!-- Supprimer -->
    <button 
        onclick="supprimerHeb({{ $Heberg->id }})"
        class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg transition duration-200">
        <i class="fa-solid fa-trash"></i>
        <span>Supprimer</span>
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
    
    function statistique(id){

        document.getElementById('confirmModal').classList.remove('hidden');
        
        let url = "/hote/heb/"+id+"/statistique";
        document.getElementById('confirmBtn').href = url;

    }
    
 
</script>
