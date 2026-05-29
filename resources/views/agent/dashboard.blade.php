@php
    if(Auth::user()->role == 'agent'){

         $id_agent=Auth::user()->id;
         $name_Agent=Auth::user()->name;
        
    }
       
    
    
@endphp
<x-app-layout>

    <div class="flex min-h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('agent.sideBar')
    
        <!-- Main content -->
        <main class="flex-1 p-6">
    
            <!-- Cards -->
             @include('agent.inf')
          <!--   <div id="notifications"></div>  -->
    
            <!-- Table -->
            <div class="bg-white rounded-xl shadow p-4">
    
                <h3 class="text-xl font-bold mb-4">Demandes à valider</h3>
    
                <table class="w-full text-left">
                    <thead>
                        
                        <a href="">
                            <tr class="border-b">
                            
                            <th class="px-4 p-2 border">Hébergement</th>
                            <th class="px-4 p-2 border">hote</th>
                            <th class="px-4 p-2 border">Type</th>
                            <th class="px-4 p-2 border">Description</th>
                            <th class="px-4 p-2 border">Service</th>
                          
                         
                            <th class="px-4 p-2 border text-center">Actions</th>
                            </tr>
                        </a>    
                    </thead>
    
                    <tbody>
                   
                    @foreach ($HebergCours as $Heberg )
                            
                      
                   
                        <tr class="border-b">
                            
                            <td class="p-2">{{$Heberg->nomHeberg}}</td>
                            <td class="p-2">{{$Heberg->hote_name}}</td>
                            <td class="p-2">{{$Heberg->typeHeberg}}</td>
                            <td class="p-2">
                                {{ \Illuminate\Support\Str::limit($Heberg->Description, 50, '...') }}
                            </td>
                           
                            
                            <td class="p-2">{{$Heberg->service}}</td>
                            
                            <td class="p-2 space-x-2">
                                <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded" onclick="afficherHeb({{ $Heberg->id }})">afficher</button>
                               
                                <button class="bg-green-500 text-white px-3 p-1 rounded" onclick="openModal({{ $Heberg->id }},'{{$name_Agent}}')">Valider</button>
                                <button class="bg-red-500 text-white px-3 p-1 rounded" onclick="refuser({{ $Heberg->id }},'{{$name_Agent}}')">Refuser</button>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
    
            </div>
            

<script>
               /*   document.addEventListener('DOMContentLoaded', function() {
                if(window.Echo){
                    console.log('Echo ready');
                   window.Echo.private('reqHeb')
                     .listen('.HebRequest', (e) => {
                       
                       console.log(e.message+'est demander par: '+e.hote_name+' at: '+e.date_create );
                });
            } else {

                  console.log('Echo not found');
            }
    

           });*/
/*           
document.addEventListener('DOMContentLoaded', function() {
window.Echo.private('reqHeb')
.listen('.HebRequest', (e) => {
    console.log(e.message+'est demander par: '+e.hote_name+' at: '+e.date_create+'hebergement' +e.nom_Heb);
    let notif = document.createElement('div');
    notif.className = "bg-blue-100 p-3 rounded mb-2 shadow";

    notif.innerHTML = `
        <strong>Nouvelle demande</strong><br>
        ${e.message} <br>
        Hôte: ${e.hote_name} <br>
        Date: ${e.date_create} <br>
        nome Heb :${e.nom_Heb}
    `;

    document.getElementById('notifications').prepend(notif);
});
});
*/
</script>
           
    
        </main>
    
    </div>
    
    
</x-app-layout>


<script>
    function openModal(id,Agent_name) {
    document.getElementById('confirmModal').classList.remove('hidden');
  
    let url = "/agent/"+Agent_name+"/dashboard/Hebergs/" + id + "/accept";
    document.getElementById('confirmBtn').href = url;
    }
    function refuser(id,Agent_name) {
    document.getElementById('confirmModal').classList.remove('hidden');
    
    let url = "/agent/"+Agent_name+"/dashboard/Hebergs/" + id + "/refuse";
    document.getElementById('confirmBtn').href = url;
    }
    
    function closeModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }
    function afficherHeb(id){
        document.getElementById('confirmModal').classList.remove('hidden');
  
        let url = "/agent/dashboard/Demandes/index/"+id;
        document.getElementById('confirmBtn').href = url;

    }
 
</script>


    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    
    <div class="bg-white p-6 rounded-2xl shadow-lg w-80 text-center">
        
     
        <p class="mb-6"> Êtes-vous sûr de vouloir continuer ?</p>

        <div class="flex justify-center gap-4">
            <!-- Annuler -->
            <button onclick="closeModal()" class="bg-gray-300 px-4 p-2 rounded">
                Annuler
            </button>

            <!-- Confirmer -->
            <a id="confirmBtn" href="#" class="bg-green-500 text-white px-4 p-2 rounded">
                Confirmer
            </a>
        </div>

    </div>
</div>    




