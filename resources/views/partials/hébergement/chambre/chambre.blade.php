<div class="hidden flex items-center justify-center min-h-screen bg-gray-100">
    <form action="{{ route('chambre.store') }}" method="POST" class="space-y-4 w-full max-w-md" enctype="multipart/form-data">
        @csrf

        <div class="bg-white p-8 rounded-2xl shadow-lg">
            
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('/assets/images/logo.png') }}" class="w-40 h-40 object-contain">
            </div>

            <p class="text-xl mb-6 text-center font-semibold">Ajouter une chambre</p>

            <!-- Informations chambre -->
            <div class="space-y-4">

                <!-- Nom de la chambre -->
                <div>
                    <label class="block mb-1">Nom de la chambre</label>
                    <input type="text" id="nom_chambre" name="nom_chambre" class="w-full border rounded-lg px-3 py-2" required/>
                </div>

                <!-- Nombre de lits -->
                <div>
                    <label class="block mb-1">Nombre de lits</label>
                    <input type="number" id="nombre_lit" name="nombre_lit" class="w-full border rounded-lg px-3 py-2" min="1" required/>
                </div>

                <!-- Type de chambre -->
                <div>
                    <label class="block mb-1">Type de chambre</label>
                    <select name="type_chambre" id="type_chambre" class="w-full border rounded-lg px-3 py-2" required>
                        <option value="">-- Sélectionner le type --</option>
                        <option value="Simple">Simple</option>
                        <option value="Double">Double</option>
                        <option value="Suite">Suite</option>
                    </select>
                </div>

                <!-- Prix -->
                <div>
                    <label class="block mb-1">Prix (DA)</label>
                    <input type="number" name="prix" class="w-full border rounded-lg px-3 py-2" min="0" required/>
                </div>

                <!-- Services -->
                <div>
                    <label class="block mb-1">Services (wifi, clim, parking…)</label>
                    <input type="text" name="service" placeholder="Séparez par des virgules" class="w-full border rounded-lg px-3 py-2"/>
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
        </div>
    </form>
</div>