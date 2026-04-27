
<x-app-layout>

    <div class="flex min-h-screen bg-gray-100">

        <!-- Sidebar -->
         
        @include('hote.aside.aside')

      
        
        


        
   
       
    
        <!-- Main content -->
        <main class="flex-1 p-4">
            <div class="p-1 m-1 flex">
                <p class="p-1 text-xl">{{$hebergement->nomHeberg}}</p>


            </div>
            <div class="grid grid-cols-4 gap-4 mb-6">
                @foreach ( $Reservation_par_jour as  $RType )
                <div class="bg-white p-4 rounded-xl shadow">
                    <p class="text-gray-500">Réservation de chambre {{ $RType->type }} aujourd'huit</p>
                    <p class="text-2xl font-bold">{{ $RType->total}}</p>
                </div>
                    
               
          
                    
                @endforeach
        
                
            
                <div class="bg-white p-4 rounded-xl shadow">
                    <p class="text-gray-500">Revenue aujord'huit</p>
                    <p class="text-2xl font-bold">{{$todayRevenue}}</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow">
                    <p class="text-gray-500">chambre avaible  </p>
                    <p class="text-2xl font-bold">{{$hebergement->nombre_chambre}}</p>
                </div>
            
              
             
            
            
            </div>

            <!--Line chart-->

            <div>
                <canvas id="myChart"></canvas>


            </div>

            <div>
                <canvas id="myChart2"></canvas>


            </div>
    
          
    
          
    
        </main>
    
    </div>
    
    
</x-app-layout>


<script>

const ctx = document.getElementById('myChart');
const ctx2 = document.getElementById('myChart2');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Réservations',
            data: @json($data),
            borderWidth: 2,
            tension: 0.4
        }]
    },
    options :{
        scales:{
            x:{
                title: {
                    display: true,
                    text: 'Les jours'
                }

            },
            y:{
                beginAtZero:true,
                ticks:{
                    stepSize: 1, 
                    precision: 0
                },
                title: {
                    display: true,
                    text: 'nombre de réservation'
                }
               

            }
        }


    }
});

new Chart(ctx2, {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Revenue',
            data: @json($dataRevenue),
            borderWidth: 2,
            tension: 0.4
        }]
    },
    options :{
        scales:{
            x:{
                title: {
                    display: true,
                    text: 'Les jours'
                }

            },
            y:{
                beginAtZero:true,
                ticks:{
                    stepSize: 1, 
                    precision: 0
                },
                title: {
                    display: true,
                    text: 'revenue'
                }
               

            }
        }


    }
});
</script>