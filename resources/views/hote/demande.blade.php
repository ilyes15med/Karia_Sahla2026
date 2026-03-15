<x-app-layout>
    <div class=" flex items-center justify-center min-h-screen">
        <form action="" method="POST" class="space-y-4 w-full max-w-md">
            @csrf

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
                        <input type="text" id="nom_Heb" name="nom_Heb" class="w-full border rounded-lg px-3 py-2"/>
                    </div>

                    <div>
                        <label class="block mb-1">Type hébergement</label>
                        <select id="type_Heb" name="type_Heb" class="w-full border rounded-lg px-3 py-2">
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
                        <label class="block mb-1">Adresse hébergement</label>
                      

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1">Latitude</label>
                            <input type="text" id="Latitude" name="Latitude" class="w-full border rounded-lg px-3 py-2"/>
                        </div>
                        <div>
                            <label class="block mb-1">Longitude</label>
                            <input type="text" id="Longitude" name="Longitude" class="w-full border rounded-lg px-3 py-2"/>
                        </div>
                    </div>

                    <!-- Services -->
                    <p class="text-lg mt-4">Sélectionnez les services :</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-2">
            
                        <label class="flex items-center gap-2  p-3 rounded-lg cursor-pointer ">
                            <input type="checkbox" name="wifi" value="wifi" class="form-checkbox h-5 w-5 text-blue-500">
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
                        <textarea id="description" name="description" rows="4" class="w-full border rounded-lg px-3 py-2" ></textarea>
                    </div>

                      <!-- Nombre de chambres -->
    <div>
        <label class="block mb-1">Nombre de chambres</label>
        <input type="number" id="nb_chambres" name="nb_chambres" min="1" class="w-full border rounded-lg px-3 py-2" placeholder="Ex: 3"/>
    </div>

    <!-- Nombre de lits -->
    <div>
        <label class="block mb-1">Nombre de lits</label>
        <input type="number" id="nb_lits" name="nb_lits" min="1" class="w-full border rounded-lg px-3 py-2" placeholder="Ex: 5"/>
    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="mt-6 w-full px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Ajouter Hébergement
                    </button>

                  

                </div>
            </div>
        </form>
    </div>
</x-app-layout>