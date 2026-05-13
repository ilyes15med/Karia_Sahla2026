<x-app-layout>

     
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

  <!-- CONTAINER -->
  <div class="max-w-7xl mx-auto px-4 py-6">
      <div class="flex gap-8">

          <!-- ASIDE -->
          <aside class="w-1/4 bg-white p-5 rounded-2xl shadow h-fit">
              @include('partials.hébergement.filter')
          </aside>

          <!-- MAIN -->
          <main class="w-3/4">
            <div id="results">
                @include('client.front-end.result-filter',['hebs'=>$hebs])
    
           

            </div>
          </main>

      </div>
  </div>

</x-app-layout>
<!--
<script>
  
  document.getElementByName('type').addEventListener('change', fetchData);
  document.etElementByName('price').addEventListener('change', fetchData);
  document.etElementByName('wilaya').addEventListener('change', fetchData);
  document.etElementByName('equipement').addEventListener('change', fetchData);
  document.etElementByName('stars').addEventListener('change', fetchData);
  
  
  
  
  
  function fetchData() {
     

    let type=document.getElementByName('type').value;
    let price=document.getElementByName('price').value;
    let wilaya=document.etElementByName('wilaya').value;
    let equipement=document.etElementByName('equipement').value;
    let stars=document.etElementByName('stars').value
  
      fetch(`/filter-heberg?type=${type}&price=${price}&wilaya=${wilaya}&equipement=${equipement}&stars=${stars}`)
          .then(res => res.text())
          .then(data => {
              document.getElementById('results').innerHTML = data;
          });
  }
</script>

-->

<script>
   document.getElementById('filterForm').addEventListener('change', function(){
    let formData=new FormData(this);
    
    let url=new URLSearchParams(formData).toString();
    
    fetch("/client/filter-heberg?"+url).then(res => res.text())
          .then(data => {
              document.getElementById('results').innerHTML = data;
          });



   });




</script>