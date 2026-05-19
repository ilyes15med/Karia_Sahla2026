
    
<x-app-layout>
@php
$icons=[
    'wifi' => 'fa-wifi',
    'parking' => 'fa-car',
    'climatisation' => 'fa-snowflake',
    'tv' => 'fa-tv',
    'restaurant' => 'fa-utensils',
    'piscine' => 'fa-water-ladder',
    'elevator'=>'fa-solid fa-elevator'


];
@endphp
<div class="flex min-h-screen">
    
    <!-- Sidebar -->
    @include('agent.sideBar')
   
     
  
    <!-- Content -->
<main class="flex-1 p-6 bg-gray-50">    
   
 
<div class="mt-12 max-w-6xl mx-auto p-5">
    
    <!-- Nom hébergement -->
    <div class="mb-4">
        <h1 class="text-2xl font-semibold text-gray-800">
           {{$heb->nomHeberg}}
        </h1>

        <div class="flex items-center gap-2 text-gray-600 mt-1"> 
            <span>{{$heb->typeHeberg}}</span>
            <i class="fa-solid fa-star text-yellow-500"></i>
            <span>0</span>
            <span class="text-gray-400">•</span>
            <span>  {{$heb->addresse}}</span>
        </div>
    </div>

    <!-- Information hôte -->
    <div class="bg-slate-100 mb-4 p-4 ">
        <div class=" rounded-xl flex  items-center justify-between gap-4">

            <span class="text-gray-700">
                Hébergé par 
                <span class="font-semibold">
                     {{$heb->hote_name}}
                </span>     

               
            <a href="/chat/user/{{$heb->hote_id}}" class="flex items-center gap-2 text-blue-600 hover:text-blue-800">
                <i class="fa-solid fa-message"></i>
                Chat
            </a>
           </span>
        </div>
        <!--Information sur le chambre-->
        <div class="mb-4 space-y-4 text-gray-700">
           
            @if ($heb->nombre_chambre==0 )
            <span>aucun chambre</span>
           
                
            @else
                
           
            <span> {{$heb->nombre_chambre}} chambre </span> 
           
            @endif
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

        
@php
$services = json_decode($heb->service, true);
        
            if (!is_array($services)) {
                $services = [];
            }
@endphp
            <!-- équipements -->
<div class="mt-4 bg-slate-100 rounded-xl p-4 flex flex-wrap gap-3">
<span class="font-bold">équipement :</span>

<div class="space-x-4">

    @forelse ($services as $service)

        <span class="mr-3">
            <i class="fa-solid {{ $icons[$service] ?? 'fa-circle' }}"></i>
            {{ $service }}
        </span>

    @empty

        <span class="mr-3">
            aucun service
        </span>

    @endforelse

</div>
</div>

 
   <!--map-->
    <div id="map" class="w-full h-96 mt-4 text-gray-700 bg-slate-100 rounded-xl p-4"></div>
  
    




</main>
</div>

<script>

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
