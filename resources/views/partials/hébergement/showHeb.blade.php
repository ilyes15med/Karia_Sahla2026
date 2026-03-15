
<div class="mt-12 max-w-6xl mx-auto p-5">

    <!-- Nom hébergement -->
    <div class="mb-4">
        <h1 class="text-2xl font-semibold text-gray-800">
            Nom hébergement
        </h1>

        <div class="flex items-center gap-2 text-gray-600 mt-1">
            <i class="fa-solid fa-star text-yellow-500"></i>
            <span>4.5</span>
            <span class="text-gray-400">•</span>
            <span>Tlemcen</span>
        </div>
    </div>

    <!-- Information hôte -->
    <div class="bg-slate-100 mb-4 p-4 ">
        <div class=" rounded-xl flex flex-wrap items-center justify-between gap-4">

            <span class="text-gray-700">
                Hébergé par <span class="font-semibold">Nom hôte</span>
            </span>
            @if(auth()->user()->role == 'client')   
                <a href="#" class="flex items-center gap-2 text-blue-600 hover:text-blue-800">
                    <i class="fa-solid fa-message"></i>
                    Chat
                </a>
    
                <a href="/client/reservation/Heb" class="px-4 py-2 rounded-lg bg-cyan-600 text-white hover:bg-cyan-700 transition">
                        Réserver
                </a>
            @endif
    
        </div>
        <div class="mb-4 space-y-4 text-gray-700">
            <i class="fa-solid fa-person"></i> 
            <span> 8 voyageur </span> 
            <span> 4 chambre </span> 
            <span> 8 lits </span> 

        </div>   


    </div>
    <!--A propos de ce logement -->
    <div class="text-gray-700 bg-slate-100 rounded-xl p-4">
       <span class="font-bold">A propos de ce logement </span>
       <br>
       <span class="p-4"> lorem 1231115656598989</span>
     

 
    </div>  
    <!--les photos -->
    <div class="mt-4 text-gray-700 bg-slate-100 rounded-xl p-4 flex flex-wrap gap-3">

        <span>
            <img src="{{asset('/assets/images/istockphoto-146765403-612x612.jpg')}}"
                 onclick="showImage(this.src)"
                 class="w-64 h-40 object-cover rounded-lg shadow cursor-pointer">
        </span>
    
        <span>
            <img src="{{asset('/assets/images/istockphoto-2176590755-1024x1024.jpg')}}"
                 onclick="showImage(this.src)"
                 class="w-64 h-40 object-cover rounded-lg shadow cursor-pointer">
        </span>
    
        <span>
            <img src="{{asset('/assets/images/valeriia-bugaiova-_pPHgeHz1uk-unsplash.jpg')}}"
                 onclick="showImage(this.src)"
                 class="w-64 h-40 object-cover rounded-lg shadow cursor-pointer">
        </span>
    
        <span>
            <img src="{{asset('/assets/images/valeriia-bugaiova-_pPHgeHz1uk-unsplash.jpg')}}"
                 onclick="showImage(this.src)"
                 class="w-64 h-40 object-cover rounded-lg shadow cursor-pointer">
        </span>
    
        <span>
            <img src="{{asset('/assets/images/valeriia-bugaiova-_pPHgeHz1uk-unsplash.jpg')}}"
                 onclick="showImage(this.src)"
                 class="w-64 h-40 object-cover rounded-lg shadow cursor-pointer">
        </span>
    
        <span>
            <img src="{{asset('/assets/images/valeriia-bugaiova-_pPHgeHz1uk-unsplash.jpg')}}"
                 onclick="showImage(this.src)"
                 class="w-64 h-40 object-cover rounded-lg shadow cursor-pointer">
        </span>
    
    </div>
    
    <!-- image popup -->
    <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
        <img id="modalImage" class="max-w-3xl rounded-lg">
    </div>

    <div class="mt-4 text-gray-700 bg-slate-100 rounded-xl p-4 flex flex-wrap gap-3">

        <span class="font-bold">équipement :</span>
        <div class="space-x-4">
         <span>  piscine <i class="fa-solid fa-person-swimming"></i></span>
         <span> parking <i class="fa-solid fa-square-parking"></i></span>
         <span>      wifi <i class="fa-solid fa-wifi"></i></span>
         

         
           
      

        </div>    
    </div>

    <div id="map" class="w-full h-96 mt-4 text-gray-700 bg-slate-100 rounded-xl p-4"></div>

<script>
function initMap() {

    const location = { lat: 34.8783, lng: -1.3150 };

    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 12,
        center: location,
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

<div class="mt-4 text-gray-700 bg-slate-100 rounded-xl p-4">

    <span class="font-bold text-lg">Avis</span>

    <div class="mt-3 flex items-start gap-3">

        <!-- photo profile -->
        <img src="{{asset('/assets/images/images.jpeg')}}"
             class="w-10 h-10 rounded-full object-cover">

        <!-- nom + evaluation -->
        <div>
            <div class="flex items-center gap-2">
                <span class="font-semibold">Nom user</span>

                <div class="flex text-yellow-500 text-sm">
                    <i class="fa-solid fa-star"></i> 4.5
                    
                </div>
            </div>

            <!-- commentaire -->
            <p class="text-gray-600 text-sm mt-1">
                Best logement, très propre et confortable.
            </p>
        </div>

    </div>

</div>  

</div>
