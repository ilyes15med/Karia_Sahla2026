
<div class="p-1">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
<div class=" flex ">
<div>
<form  id="filterForm"  class="bg-white p-4 rounded-xl shadow-md space-y-6">

    <!-- Type d'hébergement -->
    <div>
        <h3 class="font-semibold mb-2">Type d’hébergement</h3>
        <select name="type" class="w-full border rounded-lg p-2">
            <option value="">Tous</option>
            <option value="hotel">Hôtel</option>
            <option value="appartement">Appartement</option>
            <option value="villa">Villa</option>
            <option value="maison">Maison</option>
            <option value="Auberge">Auberge</option>
        </select>
    </div>

    <!-- Prix -->
    <div>
        <h3 class="font-semibold mb-2">Prix</h3>
        <div class="flex gap-2">
            <input type="number" name="price" placeholder="prix" class="w-1/2 border rounded-lg p-2">
           
        </div>
    </div>

    <!-- Wilaya -->
    <div>
        <h3 class="font-semibold mb-2">Wilaya</h3>
        <select name="wilaya" class="w-full border rounded-lg p-2">
            <option value="">Toutes</option>
            <option>Adrar</option>
            <option>Chlef</option>
            <option>Laghouat</option>
            <option>Oum El Bouaghi</option>
            <option>Batna</option>
            <option>Béjaïa</option>
            <option>Biskra</option>
            <option>Béchar</option>
            <option>Blida</option>
            <option>Bouira</option>
            <option>Tamanrasset</option>
            <option>Tébessa</option>
            <option>Tlemcen</option>
            <option>Tiaret</option>
            <option>Tizi Ouzou</option>
            <option>Alger</option>
            <option>Djelfa</option>
            <option>Jijel</option>
            <option>Sétif</option>
            <option>Saïda</option>
            <option>Skikda</option>
            <option>Sidi Bel Abbès</option>
            <option>Annaba</option>
            <option>Guelma</option>
            <option>Constantine</option>
            <option>Médéa</option>
            <option>Mostaganem</option>
            <option>M'Sila</option>
            <option>Mascara</option>
            <option>Ouargla</option>
            <option>Oran</option>
            <option>El Bayadh</option>
            <option>Illizi</option>
            <option>Bordj Bou Arreridj</option>
            <option>Boumerdès</option>
            <option>El Tarf</option>
            <option>Tindouf</option>
            <option>Tissemsilt</option>
            <option>El Oued</option>
            <option>Khenchela</option>
            <option>Souk Ahras</option>
            <option>Tipaza</option>
            <option>Mila</option>
            <option>Aïn Defla</option>
            <option>Naâma</option>
            <option>Aïn Témouchent</option>
            <option>Ghardaïa</option>
            <option>Relizane</option>
        </select>
    </div>
    
     <div>
        <h3 class="font-semibold mb-2">Equipements</h3>
        <div class="space-y-2">
           
            <label class="flex items-center gap-2">
                    <input type="checkbox" name="equipement[]" class="rounded" value="wifi">
                    <span>wifi <i class="fa-wifi"></i> </span>
            </label>
                
            <label class="flex items-center gap-2">
                <input type="checkbox" name="equipement[]" class="rounded" value="parking">
                <span>parking <i class="fa-car"></i> </span>
            </label>
            <label class="flex items-center gap-2">
                <input type="checkbox" name="equipement[]" class="rounded" value="climatisation">
                <span>climatisation <i class="fa-snowflake"></i> </span>
            </label>
            <label class="flex items-center gap-2">
                <input type="checkbox" name="equipement[]" class="rounded" value="tv">
                <span>tv <i class="fa-tv"></i> </span>
            </label>
            <label class="flex items-center gap-2">
                <input type="checkbox" name="equipement[]" class="rounded" value="restaurant">
                <span>restaurant <i class="fa-utensils"></i> </span>
            </label>
            <label class="flex items-center gap-2">
                <input type="checkbox" name="equipement[]" class="rounded" value="piscine">
                <span>piscine <i class="fa-water-ladder"></i> </span>
            </label>
         
           
        </div>
       
    
    </div>
    <!-- Nombre d’étoiles -->
    <div>
        <h3 class="font-semibold mb-2">Nombre d’étoiles</h3>
        <div class="space-y-2">
            @for ($i = 1; $i <= 5; $i++)
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="stars[]" value="{{ $i }}" class="rounded">
                    <span>{{ $i }} étoile{{ $i > 1 ? 's' : '' }}</span>
                </label>
            @endfor
        </div>
    </div>

   

</form>  

</div>

