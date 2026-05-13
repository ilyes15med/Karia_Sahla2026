<x-app-layout>

  @include('partials.search-form')

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
                @include('invité.front-end.result-filter',['hebs'=>$hebs])
    
           

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
    
    fetch("/filter-hebergement?"+url).then(res => res.text())
          .then(data => {
              document.getElementById('results').innerHTML = data;
          });



   });




</script>