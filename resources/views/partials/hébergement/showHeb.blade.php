
    

@php
    $icons=[
        'wifi' => 'fa-wifi',
        'parking' => 'fa-car',
        'climatisation' => 'fa-snowflake',
        'tv' => 'fa-tv',
        'restaurant' => 'fa-utensils',
        'piscine' => 'fa-water-ladder',
        'elevator'=>'fa-elevator'
    
    
    ];
@endphp
    <div class="flex min-h-screen">
        
      
      
        <!-- Content -->
    <main class="flex-1 p-6 bg-gray-50">    
       
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
      
       
    
    <div class="mt-12 max-w-6xl mx-auto p-5">
        
        <!-- Nom hébergement -->
        <div class="mb-4">
            <h1 class="text-2xl font-semibold text-gray-800">
               {{$heb->nomHeberg}}
            </h1>
    
            <div class="flex items-center gap-2 text-gray-600 mt-1">
                <i class="fa-solid fa-star text-yellow-500"></i>
                @if($EvalTotale==null || $EvalTotale == 0)

                <span>0</span>
                <span class="text-gray-400">•</span>
                <span>  {{$heb->addresse}}</span>
                @else
                <span>{{ (int) $EvalTotale }}</span>
                <span class="text-gray-400">•</span>
                <span>  {{$heb->addresse}}</span>
                @endif
            </div>
        </div>
    
        <!-- Information hôte -->
        <div class="bg-slate-100 mb-4 p-4 ">
            <div class=" rounded-xl flex flex-wrap items-center justify-between gap-4">
    
                <span class="text-gray-700">
                    Hébergé par <span class="font-semibold"> {{$heb->hote_name}}</span>
                </span>
                @if(optional(auth()->user())->role != 'hote' && optional(auth()->user())->role != 'agent')  
                    <a href="/chat/user/{{$heb->hote_id}}" class="flex items-center gap-2 text-blue-600 hover:text-blue-800">
                        <i class="fa-solid fa-message"></i>
                        Chat
                    </a>
        
                
                @endif
        
            </div>
            <!--Information sur le chambre-->
            <div class="max-w-4xl mx-auto mt-6">
        
               
            
                <div class="overflow-x-auto bg-white shadow rounded-xl">
                    <table class="min-w-full text-sm text-left">
                        
                        <!-- Header -->
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                
                               
                                <th class="px-4 py-3"></th>
                                
                                <th class="px-4 py-3">Prix (DA)</th>
                                <th class="px-4 py-3">Quantité totale </th>
                                
                                <th class="px-4 py-3 text-center"></th>
                                <th class="px-4 py-3 text-center"></th>

                            </tr>
                        </thead>
            
                        <!-- Body -->
                    <tbody class="divide-y">
                            
                       @foreach ($chambres as $chambre)
                       
                            
                   
                           
                      
                            <tr class="hover:bg-gray-50">
                                @if($chambre->typeChambres=="Hotel" || $chambre->typeChambres=="Auberge")
                                <td class="px-4 py-3">
                                    <div>
                                        @php
                                         $image = json_decode($chambre->images_chambres);
     
                                        @endphp  
                                        <div class="rounded-ld">
                                         
                                            <img src="{{asset('storage/'.$image[0])}}" alt="heb"  class="w-10 h-10 object-cover rounded-lg shadow">
                                            
                                            <span class="text-red-600">  
                                                {{ $chambre->typeChambres }}
                                                
                                            </span>
                                            <br>
                                            <span >  
                                               <button onclick="detailChambre()" class="text-gray-700">plus détails </button>
                                                
                                            </span>
                                           
                                        </div>
                                       
    
                                    </div>
                                    
                                </td>
                                @else
                                <td class="px-4 py-3">

                                   
                                
                                        {{-- contenu appartement --}}
                                        <span>{{ $chambre->typeChambres }}</span>
                                
                                    
                                
                                </td>
                                @endif
                                <td class="px-4 py-3">{{$chambre->prix}}</td>
                                @if ($chambre->Quantite!=0)
                                    <td class="px-4 py-3">
                                        {{ $chambre->Quantite }}
                                   
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($pollitique_Annulation->type_anullation=="gratuit")
                                        <div class="p-1 m-1 bg-green-600 text-center">
                                            anullation est gratuit
        
                                        </div>
                                            
                                        @else
                                        <div class="p-1 m-1 text-white bg-red-600 text-center">
                                            anullation n'est pas  gratuit
        
                                        </div>
                                            
                                        @endif 
                                    </td>
                                
                               
                                <td class="px-4 py-3 text-center flex justify-center gap-3">
                                    

                                    @if(optional(auth()->user())->role != 'hote' && optional(auth()->user())->role != 'agent')
                                    <a class="p-1 bg-green-700 text-white m-1 rounded-lg shadow-sm " href="/client/reservation/Heb/{{ $heb->id }}/chambre/{{$chambre->id}}">
                                        réserver
                                    </a>
                                 
                                  

                                    @endif


            
                                </td>
                                @else 
                                <td > 
                                    <span class="p-1 bg-green-700 text-white m-1">
                                    tous les chambres sont complet
                                    </span>
                                </td>
                                @endif
                            </tr>
                            
                                
                           
                                
                           
                        @endforeach
            
                          
            
                    </tbody>
                    </table>
                </div>
            </div>
            
           
          
          
<div class="mb-4 space-y-4 text-gray-700">
                <!--icon add chambre-->
     @if(optional(auth()->user())->role == 'hote')              
    <button onclick="addchambre()" 
       class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
        <!-- Icon + Texte -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M12 4v16m8-8H4"/>
        </svg>
        Ajouter une chambre
    </button>
    @endif
    
                
                
                <span> {{$heb->nombre_chambre}} chambre </span> <br>
               
             
    
</div>   
    
    
        </div>
        <!--A propos de ce logement (description) -->
        <div class="mb-4 text-gray-700 bg-slate-100 rounded-xl p-4">
           <span class="font-bold">A propos de ce logement </span>
           <br>
           <span class="p-4"> {{$heb->Description}}</span>
         
    
     
        </div>  

        <div class="mb-4 text-gray-700 bg-slate-100 rounded-xl p-4">
            <span class="font-bold">politique de l'hébergement </span>
            <br>
            <span class="p-4"> {{$heb->politiqueHeb}}</span>
          
     
      
         </div> 

         <div class="mb-4 text-gray-700 bg-red-200 rounded-xl p-4">
            <span class="font-bold">politique annulation de réservation </span>
            <br>
            @if ($pollitique_Annulation->type_anullation=="gratuite")
                <span class="p-4">
                    politique {{$pollitique_Annulation->type_anullation}} :Annulation est gratuit
            
                </span>
            @elseif ($pollitique_Annulation->type_anullation=="flexible")
            <span class="p-4">
                politique {{$pollitique_Annulation->type_anullation}} : annulation gratuit jusqu’à {{$pollitique_Annulation->nombre_jour}} jour ,après {{$pollitique_Annulation->nombre_jour}} jour remboursement partiel de taxe,mais le hôte peut recuperer les nuits
        
            </span>

            @elseif ($pollitique_Annulation->type_anullation=="strict")
            <span class="p-4">
                politique {{$pollitique_Annulation->type_anullation}} :Annulation n'est pas gratuit ,le client récupere {{$pollitique_Annulation->pourcentage_recuperation}}% avant {{$pollitique_Annulation->nombre_jour}} jours ,mais après {{$pollitique_Annulation->nombre_jour}} jours  impossible récupéré
        
            </span>

            @endif
            
          
     
      
         </div> 
        <!--les photos -->
        <div class="mt-4 text-gray-700 bg-slate-100 rounded-xl p-4 flex flex-wrap gap-3">
       
            @foreach (json_decode($heb->images) as $img)
            <img 
                src="{{ asset('storage/'.$img) }}"
                onclick="showImage(this.src)"
                class="w-64 h-40 object-cover rounded-lg shadow cursor-pointer"
            >
            @endforeach
        
          
            
        
           
        
        </div>
        
        <!-- image popup -->
        <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
            <img id="modalImage" class="max-w-3xl rounded-lg">
        </div>
    
        <div class="mt-4 text-gray-700 bg-slate-100 rounded-xl p-4 flex flex-wrap gap-3">
    
            <span class="font-bold">équipement :</span>
            <div class="space-x-4">
                @foreach (json_decode($heb->service) as $service)
                            <span class="mr-3">
                                <i class="fa-solid {{ $icons[$service] }}"></i>
                                {{ $service }}
                            </span>
                           
    
                                
                @endforeach
            
    
             
               
          
    
            </div>    
        </div>
       <!--map-->
        <div id="map" class="w-full h-96 mt-4 text-gray-700 bg-slate-100 rounded-xl p-4"></div>
         <!--Avis-->

   
    
        <div class="mt-4 text-gray-700 bg-slate-100 rounded-xl p-4">
    
            <span class="font-bold text-lg">Avis</span>
        @if($evaluations->isEmpty())  
           <div> 
           <span class="p-1 text-gray-500">aucun avis </span>
           </div> 
        @else
        @foreach ($evaluations as $evaluation )
        <div class="mt-3 flex items-start gap-3">
        
            <!-- photo profile -->
            <img src="{{asset('/assets/images/images.jpeg')}}"
                 class="w-10 h-10 rounded-full object-cover">
    
            <!-- nom + evaluation -->
            <div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold"> {{$evaluation->nomclient}}</span>
    
                    <div class="flex text-yellow-500 text-sm">
                        <i class="fa-solid fa-star"></i> {{$evaluation->nombre_etoile}}
                        
                    </div>
                    @if(optional(Auth()->user())->id==$evaluation->id_client)
                    
                    <div class="relative inline-block text-left">

                        <!-- زر 3 نقاط -->
                        <button onclick="toggleMenu(this)" 
                                class="p-2 rounded-full hover:bg-gray-200">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                    
                        <!-- Menu -->
                        <div class="hidden absolute right-0 mt-2 w-40 bg-white border rounded-xl shadow-lg z-50">
                            
                            <!-- Modifier -->
                            <a href="{{ route('update_rating.show',[$heb->id,$evaluation->Evaluation_id]) }}" 
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center gap-2">
                                <i class="fa-solid fa-pen text-blue-500"></i>
                                Modifier
                            </a>
                    
                            <!-- Supprimer -->
                            <a href="{{route('rating.delete',[$heb->id,$evaluation->Evaluation_id])}}" 
                                    class="w-full text-left px-4 py-2 hover:bg-red-100 flex items-center gap-2 text-red-600">
                                <i class="fa-solid fa-trash"></i>
                                Supprimer
                            </a>
                    
                        </div>
                    </div>
                    @endif
                  
                </div>
    
                <!-- commentaire -->
                <p class="text-gray-600 text-sm mt-1">
                    {{$evaluation->commentaire}}
                </p>
            </div>
    
        </div>
            
        @endforeach
        @endif
           
@if( optional($reservations)->canEvalue==1)
   

<div class="mt-4 text-gray-700 bg-slate-100 rounded-xl p-4">

  

    <form action="{{ route('rating.added',$heb->id) }}" method="post" class="mt-3">
        @csrf

        <input type="hidden" name="client_id" value="{{ $client->id }}" >
       

        <!-- Rating -->
        <div class="flex flex-row-reverse justify-end gap-1 text-2xl">

        @for($i = 5; $i >= 1; $i--)
        <input type="radio" name="nombre_starts" id="star{{ $i }}" value="{{ $i }}" class="hidden peer" required>

        <label for="star{{ $i }}"
               class="cursor-pointer text-gray-300 peer-checked:text-yellow-500 hover:text-yellow-400">
            ★
        </label>
        @endfor

        </div>
        

        <!-- Commentaire -->
        <textarea name="commentaire"
                  class="w-full mt-3 p-2 border rounded-lg"
                  placeholder="Votre avis..."
                  required></textarea>

        <button class="mt-3 bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Envoyer
        </button>
    </form>

</div>



@else

<div class="mt-4 text-gray-500">
    Vous ne pouvez pas évaluer pour le moment.
</div>




@endif
          
            <div id="addchambreform" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <form action="{{route('chambre.added',$heb->id)}} " method="post" class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-3xl max-h-[90vh] overflow-y-auto" enctype="multipart/form-data">
                    @csrf
            
                    <!-- زر إغلاق -->
                    <button type="button" onclick="document.getElementById('addchambreform').classList.add('hidden')"
                            class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl font-bold">
                        ✖
                    </button>
            
                    <!-- Logo -->
                    <div class="flex justify-center mb-6">
                        <img src="{{ asset('/assets/images/logo.png') }}" class="w-40 h-40 object-contain">
                    </div>
            
                    <p class="text-xl mb-6 text-center font-semibold">Ajouter une chambre</p>
    
                     <!-- Type de chambre -->
                     <div>
                        <label class="block mb-1">Type de chambre</label>
                        <select name="type_chambre" class="w-full border rounded-lg px-3 py-2" required>
                            <option value="">-- Sélectionner --</option>
                            <option value="Simple">Simple</option>
                            <option value="Double">Double</option>
                            <option value="Suite">Suite</option>
                            <option value="familiale">familiale</option>
                            <option value="Delux">Delux</option>
    
                        </select>
                    </div>
                      <!-- Prix -->
                      <div>
                        <label class="block mb-1">Prix</label>
                        <input type="number" name="prix" class="w-full border rounded-lg px-3 py-2" min="0" required/>
                    </div>
            
                    <div class="space-y-4">
                        <!-- Nombre de la chambre -->
                        <div>
                            <label class="block mb-1">Nombre des chambres</label>
                            <input type="text" name="nombre_chambre" class="w-full border rounded-lg px-3 py-2" required/>
                        </div>
            
                        <!-- Nombre de lits -->
                        <div>
                            <label class="block mb-1">Nombre de lits pour chaque chambre</label>
                            <input type="number" name="nombre_lit" class="w-full border rounded-lg px-3 py-2" min="1" required/>
                        </div>
            
                       
            
                      
                   
                             <!-- Services -->
                             <p class="text-lg mt-4">Sélectionnez les services :</p>
                             <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-2">
                     
                                 <label class="flex items-center gap-2  p-3 rounded-lg cursor-pointer ">
                                     <input type="checkbox" name="services[]" value="wifi" class="form-checkbox h-5 w-5 text-blue-500">
                                     <i class="fa-solid fa-wifi text-blue-500"></i>
                                     <span>Wi-Fi</span>
                                 </label>
         
                                 <label class="flex items-center gap-2  p-3 rounded-lg cursor-pointer ">
                                     <input type="checkbox" name="services[]" value="parking" class="form-checkbox h-5 w-5 text-blue-500">
                                     <i class="fa-solid fa-car text-blue-500"></i>
                                     <span>Parking</span>
                                 </label>
         
                                 <label class="flex items-center gap-2  p-3 rounded-lg cursor-pointer ">
                                     <input type="checkbox" name="services[]" value="climatisation" class="form-checkbox h-5 w-5 text-blue-500">
                                     <i class="fa-solid fa-snowflake text-blue-500"></i>
                                     <span>Climatisation</span>
                                 </label>
         
                                 <label class="flex items-center gap-2  p-3 rounded-lg cursor-pointer ">
                                     <input type="checkbox" name="services[]" value="tv" class="form-checkbox h-5 w-5 text-blue-500">
                                     <i class="fa-solid fa-tv text-blue-500"></i>
                                     <span>Télévision</span>
                                 </label>
         
                                 <label class="flex items-center gap-2  p-3 rounded-lg cursor-pointer ">
                                     <input type="checkbox" name="services[]" value="restaurant" class="form-checkbox h-5 w-5 text-blue-500">
                                     <i class="fa-solid fa-utensils text-blue-500"></i>
                                     <span>Restaurant</span>
                                 </label>
         
                                 <label class="flex items-center gap-2  p-3 rounded-lg cursor-pointer ">
                                     <input type="checkbox" name="services[]" value="piscine" class="form-checkbox h-5 w-5 text-blue-500">
                                     <i class="fa-solid fa-water-ladder text-blue-500"></i>
                                     <span>Piscine</span>
                                 </label>
    
                                 <label class="flex items-center gap-2  p-3 rounded-lg cursor-pointer ">
                                    <input type="checkbox" name="services[]" value="elevator" class="form-checkbox h-5 w-5 text-blue-500">
                                    <i class="fa-solid fa-elevator"></i>
                                    <span>acenseur</span>
                                </label>
         
                             </div>
            
                        <!-- Description -->
                        <div>
                            <label class="block mb-1">Description</label>
                            <textarea name="description" class="w-full border rounded-lg px-3 py-2" rows="3"></textarea>
                        </div>
            
                        <!-- Images -->
                        <div>
                            <label class="block mb-1">Images</label>
                            <input type="file" name="images[]" multiple class="w-full" accept="image/*"/>
                        </div>
                    </div>
            
                    <!-- Submit -->
                    <div class="mt-6">
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                            Ajouter la chambre
                        </button>
                    </div>
            
                </form>
            </div>
           
    
    
            <div id="chambreShow" class="hidden fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-3xl max-h-[90vh] overflow-y-auto" enctype="multipart/form-data">
                    
            
                    <!-- زر إغلاق -->
                    <button type="button" onclick="document.getElementById('chambreShow').classList.add('hidden')"
                            class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl font-bold">
                        ✖
                    </button>
                     
                    @foreach ($chambres as $chambre)

                    <label class="block mb-1">chambre {{$chambre->typeChambres}}</label>
                        
                   
            
                
                     <div>
                      
                        <div class="">
                            {{ $chambre->nombre_lit }} <i class="fa-solid fa-bed"></i> <br>
                            {{ $chambre->nombre_chambre }} chambres <br>
    
    
                        </div>
                        <div class="">
                            @php
                            $images=json_decode($chambre->images_chambres);
                                
                            @endphp
                        @if(is_array($images))
                           @foreach ($images as $image )
                           
                           <div>
                            <img 
                            src="{{ asset('storage/'.$image) }}"
                            onclick="showImage(this.src)"
                            class="w-10 h-10 object-cover rounded-lg shadow cursor-pointer" >
                            
                           </div>
                               
                           @endforeach
                        @endif
    
    
                        </div>
                       
                    </div>
                    @endforeach
                    
                
            
                </div>
            </div>
             <!-- image popup -->
        <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
            <img id="modalImage" class="max-w-3xl rounded-lg">
        </div>
    
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
      
        
    
    
    
    
    </main>
    </div>
    
    <script>
        function addchambre(){
    
            document.getElementById("addchambreform").classList.remove("hidden");
        }
        function detailChambre(){
           
            document.getElementById("chambreShow").classList.remove("hidden");
    
    
    
        }
        function showImage(src){
            document.getElementById("modalImage").src = src;
            document.getElementById("imageModal").classList.remove("hidden");
           
    
        }
        function update(idHeb,idChmbre){
    
           
            document.getElementById('confirmModal').classList.remove('hidden');
      
            let url = "/hote/MonHebergement/"+idHeb+"/chambre/"+idChmbre+"/edit";
            document.getElementById('confirmBtn').href = url;
        
        }
        function closeModal(){
            document.getElementById('confirmModal').classList.add('hidden');
        }
    
    function initMap() {
    
        const location = { lat: {{$heb->latitude}}, lng: {{$heb->longitude}} };
    
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 12,
            center: location,
            zoomControl:true
        });
    
        const marker = new google.maps.Marker({
            position: location,
            map: map,
        });
    
    }
   
function toggleMenu(button){
    let menu = button.nextElementSibling;
    menu.classList.toggle('hidden');
}


document.addEventListener('click', function(e){
    document.querySelectorAll('.relative .absolute').forEach(menu => {
        if(!menu.previousElementSibling.contains(e.target)){
            menu.classList.add('hidden');
        }
    });
});

   

    </script>
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUqMturwFCGYIXu0AY0Fnb9ovtjcr-5KM&callback=initMap" async defer></script>
    
    
        
        <script>
        function showImage(src){
            document.getElementById("modalImage").src = src;
            document.getElementById("imageModal").classList.remove("hidden");
           
    
        }
        
        document.getElementById("imageModal").onclick = function(){
            this.classList.add("hidden");
        }
     
        </script>
    <!--Evaluation -->
    
    </div>
    
    
    
    
    