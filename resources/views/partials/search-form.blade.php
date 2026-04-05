    
<div class="p-5 bg-cyan-600">
    <p class="text-2xl font-bold text-center">Trouver votre hébergement</p>
 
    <div class="mt-4 bg-white p-4 rounded-xl shadow-md">
        <form action="/client/search" method="GET" class="flex flex-wrap items-end gap-4">
            <!-- Destination -->
            <div class="flex flex-col">
                <label for="destination" class="text-sm font-medium text-gray-700">Destination</label>
                <input type="text" id="destination" name="destination" placeholder="Où allez-vous ?" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
 
            <!-- Date arrivée -->
            <div class="flex flex-col">
                <label for="date_arrivee" class="text-sm font-medium text-gray-700">Date d'arrivée</label>
                <input type="date" id="date_arrivee" name="date_arrivee" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required/>
            </div>
 
            <!-- Date départ -->
            <div class="flex flex-col">
                <label for="date_depart" class="text-sm font-medium text-gray-700">Date de départ</label>
                <input type="date" id="date_depart" name="date_depart" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required/>
            </div>
 
            <!-- Voyageurs -->
            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700">Voyageurs</label>
                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="text-xs text-gray-600">Adultes</label>
                        <input type="number" name="adultes" min="1" value="1" class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="text-xs text-gray-600">Enfants</label>
                        <input type="number" name="enfants" min="0" value="0" class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="text-xs text-gray-600">Bébés</label>
                        <input type="number" name="bebes" min="0" value="0" class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>
 
            <div>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Recherche</button>
            </div>
        </form>
    </div>
</div>
<!--
<script>
    document.querySelector("form").addEventListener("submit", function(){
    
        let date_arrive = document.getElementById("date_arrivee").value;
        let date_depart = document.getElementById("date_depart").value;
    
        localStorage.setItem("date_debut", date_arrive);
        localStorage.setItem("date_fin", date_depart);
    
    });
</script>

-->