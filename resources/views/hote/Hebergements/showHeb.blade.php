
    
<x-app-layout>
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
    
    <!-- Sidebar -->
   
@include('hote.aside.aside')
  
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
            @if(auth()->user()->role == 'client')   
                <a href="#" class="flex items-center gap-2 text-blue-600 hover:text-blue-800">
                    <i class="fa-solid fa-message"></i>
                    Chat
                </a>
    
               
            @endif
    
        </div>
        <!--Information sur le chambre-->
        <div class="max-w-4xl mx-auto mt-6">
    
            <h2 class="text-xl font-semibold mb-4">chambres</h2>
        
            <div class="overflow-x-auto bg-white shadow rounded-xl">
                <table class="min-w-full text-sm text-left">
                    
                    <!-- Header -->
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-3">Type de chambre</th>
                            <th class="px-4 py-3">Quantité</th>
                            <th class="px-4 py-3">Prix (DA)</th>
                            <th class="px-4 py-3 text-center"></th>
                        </tr>
                    </thead>
        
                    <!-- Body -->
                <tbody class="divide-y">
                        
                   @foreach ($chambres as $chambre)
                       
                  
                        <tr class="hover:bg-gray-50">
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
                                           <button onclick="getElementById('chambreShow').classList.remove('hidden')" class="text-gray-700">plus détails </button>
                                            
                                        </span>
                                        <div id="chambreShow" class="hidden fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-50">
                                            <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-3xl max-h-[90vh] overflow-y-auto" enctype="multipart/form-data">
                                                
                                        
                                                <!-- زر إغلاق -->
                                                <button type="button" onclick="document.getElementById('chambreShow').classList.add('hidden')"
                                                        class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl font-bold">
                                                    ✖
                                                </button>
                                             
                                
                                                <div id="modalContent">
                                                    <span>{{$chambre->nombre_lit}}</span>
                                                    <span>{{$chambre->nombre_chambre}}</span>
                                                </div>

                                            <div>
                                                @foreach (json_decode($chambre->images_chambres) as $image )
                                                <img 
                                                src="{{ asset('storage/'.$image) }}"
                                                onclick="showImage(this.src)"
                                                class="w-10 h-10 object-cover rounded-lg shadow cursor-pointer"
                                            >
                                                @endforeach



                                            </div>
                                            <div class=" space-x-4">
                                            @php
                                                $services=json_decode($chambre->services) ;
                                            @endphp


           
                                                @if (!empty($services))
                                                
                                            
                                                @foreach ($services as $service )
                                                
                                                <span class="mr-3">
                                                    <i class="fa-solid {{ $icons[$service] }}"></i>
                                                    {{ $service }}
                                                </span>
                                             
                        
                                                    
                                 
                                                  
                                                    
                                                @endforeach
                                            @endif     
                                            </div>
                                                
                                            
                                        
                                            </div>
                                        </div>
                                       
                                    </div>
                                   

                                </div>
                                
                            </td>
                            <td class="px-4 py-3">
                                {{ $chambre->nombre_chambre }}
                            </td>
                           
                            <td class="px-4 py-3">{{$chambre->prix}}</td>
                            <td class="px-4 py-3 text-center flex justify-center gap-3">
        
                                <!-- Edit -->
                                <button onclick="update({{ $heb->id }},{{ $chambre->id }})"  class="text-blue-600 hover:text-blue-800">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
        
                                <!-- Delete -->
                                <button onclick="supprimer({{ $heb->id }},{{ $chambre->id }})" class="text-red-600 hover:text-red-800">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
        
                            </td>
                        </tr>
                    @endforeach
        
                      
        
                </tbody>
                </table>
            </div>
        </div>
        
       
      
      
<div class="mb-4 space-y-4 text-gray-700">
<!--icon add chambre-->
<button onclick="addchambre()" 
   class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
    <!-- Icon + Texte -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M12 4v16m8-8H4"/>
    </svg>
    Ajouter une chambre
</button>

            
            
            <span> {{$heb->nombre_chambre}} chambre </span> 
           

        </div>   


    </div>
    <!--A propos de ce logement (description) -->
    <div class="text-gray-700 bg-slate-100 rounded-xl p-4">
       <span class="font-bold">A propos de ce logement </span>
       <br>
       <span class="p-4"> {{$heb->Description}}</span>
     

 
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
                    <select id="typeSelect" name="type_chambre" class="w-full border rounded-lg px-3 py-2" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="Simple">Simple</option>
                        <option value="Double">Double</option>
                        <option value="Triple">Triple </option>
                        <option value="Suite">Suite</option>
                        <option value="familiale">familiale</option>
                        <option value="Delux">Delux</option>
                        <option value="studio">Studio</option>
                        <option value="autre">Autre...</option>


                    </select>
                    <input type="text" id="autreType" name="type_custom"
                    placeholder="Entrer un nouveau type"
                    class="border rounded-lg px-3 py-2 hidden">

                    <script>
                        const select = document.getElementById('typeSelect');
                        const input = document.getElementById('autreType');
                    
                        select.addEventListener('change', function () {
                            if (this.value === 'autre') {
                                input.classList.remove('hidden');
                            } else {
                                input.classList.add('hidden');
                                input.value = '';
                            }
                        });
                    </script>

                </div>
                  <!-- Prix -->
                  <div>
                    <label class="block mb-1">Prix par nuit</label>
                    <input type="number" name="prix" class="w-full border rounded-lg px-3 py-2" min="0" placeholder="prix dzd" required/>
                </div>
        
                <div class="space-y-4">
                    <!-- Nombre de la chambre -->
                    <div>
                        <label class="block mb-1">Nombre des chambres</label>
                        <input type="text" name="nombre_chambre" class="w-full border rounded-lg px-3 py-2" placeholder="Nombre totale de chambre dans l'hébergement " required/>
                    </div>
        
                    <!-- Nombre de lits -->
                    <div>
                        <label class="block mb-1">Nombre de lits </label>
                        <input type="number" name="nombre_lit" class="w-full border rounded-lg px-3 py-2" placeholder="Nombre de lits pour chaque chambre" min="1" required/>
                    </div>
                    <!-- taxe -->
                    <div>
                        <label class="block mb-1">taxe</label>
                        <input type="number" name="taxe" class="w-full border rounded-lg px-3 py-2" min="0" max="100" placeholder="ex: 0% est aucun taxe " required/>
                    </div>
                     <!-- Annulation -->
                     <div>
                        <div>
                            <label class="block mb-1">annulation</label>
                            <input type="number" name="annulation" class="w-full border rounded-lg px-3 py-2"  min="0" max="100" placeholder="ex: 100% est frais annulation "  required/>
                        </div>
                       
                    
                    </div>

                     <!-- obligerpayée? -->
                    <div>
                        <label class="block mb-1">payée</label>
                        <select name="payment">
                        <option value="pending">Paiement à l'arrivée </option>
                        <option value="paid ">payment</option>
                        </select>
                    </div>
                    <!--code promo-->

                    <div>
                        <div>
                            <label class="block mb-1">code promo</label>
                            <input type="text" name="code_Promo" class="w-full border rounded-lg px-3 py-2"   />
                        </div>
                       
                    
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
                        <input type="file" name="images[]" multiple class="w-full" accept="image/*" required/>
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
            @if(Auth()->user()->id==$evaluation->id_client)
            
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
   

</main>
</div>

<script>
    function addchambre(){

        document.getElementById("addchambreform").classList.remove("hidden");
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
    function supprimer(idHeb,idChmbre){
        document.getElementById('confirmModal').classList.remove('hidden');
       
  
        let url = "/hote/MonHebergement/"+idHeb+"/chambre/"+idChmbre+"/delete";
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




</x-app-layout>
