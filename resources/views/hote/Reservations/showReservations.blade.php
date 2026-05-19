<x-app-layout>

    @if(session('succes'))
    <div id="message" class="bg-green-100 text-green-700 p-3 rounded-lg shadow-sm mb-4">
     <span>
       {{ session('succes')}}
     </span>
     <button onclick="document.getElementById('message').remove()" 
     class="pl-1 text-green-700 font-bold hover:text-red-500">
       <i class="fa-solid fa-trash"></i>
     </button> 
  
  
  
    </div>
  
  
   
  
  
@endif
<div class="flex min-h-screen">
    
        <!-- Sidebar -->
       
            @include('hote.aside.aside')
      
        <!-- Content -->
    <main class="flex-1 p-6 bg-gray-50">    
        <div class="max-w-6xl mx-auto py-10">
            <h2 class="text-2xl font-bold mb-6">Mes Réservations</h2>
            @if ($reservations->isEmpty())
            <span class="text-gray-800 p-2">
                aucun réservation

            </span>
                
            @else
                
         
    
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @foreach($reservations as $reservation)
                    <div class="bg-white shadow-lg rounded-2xl p-5 hover:shadow-xl transition">
    
                        <!-- Info -->
                        <h3 class="text-lg font-semibold mb-2">
                            Chambre: {{ $reservation->typeChambres }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            <i class="fa-regular fa-calendar"></i> Nom client: {{ $reservation->Rnom }}
                        </p>
    
                        <p class="text-sm text-gray-500">
                            <i class="fa-regular fa-calendar"></i> Du: {{ $reservation->Rdate_debut }}
                        </p>
    
                        <p class="text-sm text-gray-500">
                            <i class="fa-regular fa-calendar"></i> Au: {{ $reservation->Rdate_fin }}
                        </p>
    
                        <p class="mt-2 font-bold text-blue-600">
                            {{ $reservation->amount }} DA
                        </p>
    
                        <!-- Buttons -->
                        <div class="mt-4 flex justify-between">
    
                            <!-- Télécharger -->
                            <a href="/reservation/{{$reservation->Rid}}/ticket"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                Ticket
                            </a>
                           
                            
                    
                     
                          
                     
                          

    
                        </div>
    
                    </div>
               
                   
                @endforeach
    
            </div>
            @endif
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
        </div>
    </main>
</div>

        <script>
             function anuller_Reservation(idReservation) {
        document.getElementById('confirmModal').classList.remove('hidden');
        
        let url = "/client/reservation/"+idReservation+"/delete" ;
        document.getElementById('confirmBtn').href = url;
        }
        function closeModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }
    
        </script>
    
</x-app-layout>