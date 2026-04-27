@php
   
    if(Auth::user()->role == 'hote'){

         $id_hote=Auth::user()->id;
    }
       
    
    
@endphp
<x-app-layout>
    <div class=" flex items-center justify-center min-h-screen">
        @foreach ($HebergCours as $Heb)
        <form action="{{route('hebergement.update',$Heb->id)}}" method="post" class="space-y-4 w-full max-w-md" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="bg-white p-8 rounded-2xl shadow-lg">
                
                <!-- Logo -->
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('/assets/images/logo.png') }}" class="w-40 h-40 object-contain">
                </div>

                <p class="text-xl mb-6 text-center">Saisir les informations de votre hébergement</p>
        
                
           
                <!-- Informations Hébergement -->
                <div class="space-y-4">

                    <div>
                        <label class="block mb-1">Nom hébergement</label>
                        <input type="text" id="nom_Heb" name="nom_Heb" class="w-full border rounded-lg px-3 py-2" value="{{ $Heb->nomHeberg }}" required/>
                    </div>

                    <div>
                        <label class="block mb-1">Type hébergement</label>
                        <select id="type_Heb" name="type_Heb" class="w-full border rounded-lg px-3 py-2" value="{{ $Heb->typeHeberg }} required>
                            <option value="">-- Sélectionnez le type --</option>
                            <option value="Hotel">Hôtel</option>
                            <option value="Appartement">Appartement</option>
                            <option value="Maison">Maison</option>
                            <option value="Villa">Villa</option>
                            <option value="Chambre d'hôtes">Chambre d'hôtes</option>
                            <option value="Auberge">Auberge</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1">prix par nuit</label>
                        <input type="number" id="prix" name="prix" class="w-full border rounded-lg px-3 py-2" value="{{ $Heb->prix }}" required/>
                       

                    </div>


                    <div>
                        <label class="block mb-1">Adresse hébergement</label>
                        <div>
                            <label class="block mb-1">addresse</label>
                            <input type="text" id="addresee" name="addresee" class="w-full border rounded-lg px-3 py-2" value="{{ $Heb->addresse }}"/>
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

                      <!-- Nombre de chambres -->
    <div>
        <label class="block mb-1">Nombre de chambres</label>
        <input type="number" id="nb_chambres" name="nb_chambres" min="1" class="w-full border rounded-lg px-3 py-2" placeholder="Ex: 3" value="{{ $Heb->nombre_chambre }}" required/>
    </div>

    <!-- Nombre de lits 
    <div>
        <label class="block mb-1">Nombre de lits</label>
        <input type="number" id="nb_lits" name="nb_lits" min="1" class="w-full border rounded-lg px-3 py-2" placeholder="Ex: 5" value="{{ $Heb->nombre_lit }}"  disable required/>
    </div>
    -->
                <div>
                    <input type="text" id="id" name="id" class="hidden" value=" {{$id_hote}}"/>
                
                    
                </div>
                <div>
                    <label class="block mb-1">Images de l'hébergement</label>
                    <input type="file" name="images[]" multiple class="w-full border rounded-lg px-3 py-2" value="{{ $Heb->images }}" >
                </div>

                    <!-- Submit Button -->
                    <button type="submit" class="mt-6 w-full px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        modifier Hébergement
                    </button>

                  

                </div>
            </div>
        </form>
        @endforeach
    </div>
</x-app-layout>