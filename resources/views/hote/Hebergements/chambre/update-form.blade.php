<x-app-layout>

    <div id="updatechambreform" class=" flex items-center justify-center ">
        <form action="{{route('chambre.update',['idHeb'=>$heb->id,'idC'=>$chambre->id])  }}" method="post" class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-3xl max-h-[90vh] overflow-y-auto" enctype="multipart/form-data">
            @csrf
            @method('put')
    
           
    
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('/assets/images/logo.png') }}" class="w-40 h-40 object-contain">
            </div>
    
            <p class="text-xl mb-6 text-center font-semibold">modifier une chambre</p>

             <!-- Type de chambre -->
            <div>
                <label class="block mb-1">Type de chambre</label>
                <select name="type_chambre" class="w-full border rounded-lg px-3 py-2"  required>
                    <option value="">{{ $chambre->typeChambres }}</option>
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
                <input type="number" name="prix" class="w-full border rounded-lg px-3 py-2" min="0" value="{{ $chambre->prix }}" required/>
            </div>
    
            <div class="space-y-4">
                <!-- Nombre de la chambre -->
                <div>
                    <label class="block mb-1">Nombre des chambres</label>
                    <input type="text" name="nombre_chambre" class="w-full border rounded-lg px-3 py-2" value="{{ $chambre->nombre_chambre }}"  required/>
                </div>
    
                <!-- Nombre de lits -->
                <div>
                    <label class="block mb-1">Nombre de lits pour chaque chambre</label>
                    <input type="number" name="nombre_lit" class="w-full border rounded-lg px-3 py-2" min="1" value="{{ $chambre->nombre_lit }}"  required/>
                </div>
               
              
    
                   
    
                <!-- Description -->
                <div>
                    <label class="block mb-1">Description</label>
                    <textarea name="description" class="w-full border rounded-lg px-3 py-2" rows="3">{{$chambre->Description}}</textarea>
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
                    modifier la chambre
                </button>
            </div>
    
        </form>
    </div>
</x-app-layout>