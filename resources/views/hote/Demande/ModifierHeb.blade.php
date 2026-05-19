@php
   
    if(Auth::user()->role == 'hote'){

         $id_hote=Auth::user()->id;
    }
       
    
    
@endphp
<x-app-layout>
    <div class=" flex items-center justify-center min-h-screen">
      
        <form action="{{route('hebergement.update',$Heb->id)}}" method="post" class="space-y-4 w-full max-w-md" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="bg-white p-8 rounded-2xl shadow-lg">
                
                <!-- Logo -->
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('/assets/images/logo.png') }}" class="w-40 h-40 object-contain">
                </div>

                <p class="text-xl mb-6 text-center">modifier les informations de votre hébergement</p>
        
                
           
                <!-- Informations Hébergement -->
                <div class="space-y-4">

                    <div>
                        <label class="block mb-1">Nom hébergement</label>
                        <input type="text" id="nom_Heb" name="nom_Heb" class="w-full border rounded-lg px-3 py-2" value="{{ $Heb->nomHeberg }}" required/>
                    </div>

                    <div>
                        <label class="block mb-1">Type hébergement</label>
                        <select id="type_Heb" name="type_Heb" class="w-full border rounded-lg px-3 py-2" value="{{ $Heb->typeHeberg }}" required>
                            <option value="">-- Sélectionnez le type --</option>
                            <option value="Hotel">Hôtel</option>
                            <option value="Appartement">Appartement</option>
                            <option value="Maison">Maison</option>
                            <option value="Villa">Villa</option>
                            <option value="Chambre_hotes">Chambre d'hôtes</option>
                            <option value="Auberge">Auberge</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1">prix par nuit</label>
                        <input type="number" id="prix" name="prix" class="w-full border rounded-lg px-3 py-2" value="{{ $Heb->prix }}" required/>
                       

                    </div>
               

                    <div>
                       <!-- Wilaya -->
<div class="mb-3">
    <label class="block mb-1">Wilaya</label>
    <select id="wilaya" name="wilaya"  class="w-full border rounded-lg px-3 py-2">
        <option value="">-- Choisir Wilaya --</option>
    </select>
</div>

<!-- Commune -->
<div>
    <label class="block mb-1">Commune</label>
    <select id="commune" name="commune" class="w-full border rounded-lg px-3 py-2">
        <option value="">-- Choisir Commune --</option>
    </select>
</div>
                      

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1">Latitude</label>
                            <input type="text" id="Latitude" name="Latitude" class="w-full border rounded-lg px-3 py-2" value="{{ $Heb->latitude }}"  required/>
                        </div>
                        <div>
                            <label class="block mb-1">Longitude</label>
                            <input type="text" id="Longitude" name="Longitude" class="w-full border rounded-lg px-3 py-2" value="{{ $Heb->longitude }}" required/>
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

                    </div>

                    <div>
                        <label class="block mb-1">Description de l'hébergement</label>
                        <textarea id="description" name="description" rows="4" class="w-full border rounded-lg px-3 py-2" required>{{$Heb->Description}}</textarea>
                    </div>

            
                <div>
                    <input type="text" id="id" name="id" class="hidden" value=" {{$id_hote}}"/>
                
                    
                </div>
                <div>
                    <label class="block mb-1">Images de l'hébergement</label>
                    <input type="file" name="images[]" multiple class="w-full border rounded-lg px-3 py-2" value="{{ $Heb->images }}" required >
                </div>

                    <!-- Submit Button -->
                    <button type="submit" class="mt-6 w-full px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        modifier Hébergement
                    </button>

                  

                </div>
            </div>
        </form>
    
    </div>

    <script>
        let wilayas = [];
        let communes = [];
        
        Promise.all([
            fetch('/wilayas_commune/Wilaya_Of_Algeria.json').then(res => res.json()),
            fetch('/wilayas_commune/Commune_Of_Algeria.json').then(res => res.json())
        ]).then(([wilayaData, communeData]) => {
        
            wilayas = wilayaData;
            communes = communeData;
        
            const wilayaSelect = document.getElementById('wilaya');
            const communeSelect = document.getElementById('commune');
        
            // remplir wilayas
            wilayas.forEach(w => {
                let option = document.createElement('option');
                option.value = w.name; 
                option.textContent = w.name;
                wilayaSelect.appendChild(option);
            });
        
            // change communes
            wilayaSelect.addEventListener('change', function () {
                const selectedWilaya = this.value;
        
                communeSelect.innerHTML = '<option value="">-- Choisir Commune --</option>';
        
                const filtered = communes.filter(c => c.wilaya_id == wilayas.find(w => w.name === selectedWilaya).id);
        
                filtered.forEach(c => {
                    let option = document.createElement('option');
                    option.value = c.name;
                    option.textContent = c.name;
                    communeSelect.appendChild(option);
                });
            });
        
        });
/*
        document.getElementById("type_Heb").addEventListener('change',function(){

            let block= document.getElementById("chambre_lit_block");
            
            if (this.value === 'Appartement' || this.value === 'Maison' || this.value === 'Villa' || this.value === 'Chambre_hotes') {
                block.classList.remove('hidden');
            } else {
                block.classList.add('hidden');
            }
        });
*/
        </script>
</x-app-layout>