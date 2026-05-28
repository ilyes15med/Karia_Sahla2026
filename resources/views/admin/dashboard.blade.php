<x-app-layout>
    
    
        <div class="flex min-h-screen">
        
            <!-- Sidebar -->
           
                @include('admin.aside.aside')
          
            <!-- Content -->
            <main class="flex-1 p-6 bg-gray-50"> 
                
                @if(session('succes'))
                <div id="message" class="bg-green-100 text-green-700 p-3 rounded-lg shadow-sm mb-4">
                 <span>
                   {{ session('succes')}}
                 </span>
                 <button onclick="document.getElementById('message').remove()" 
                 class="pl-1 text-green-700 font-bold hover:text-red-500">
                   <i class="fa-solid fa-trash"></i>
                 </button> 
              
              
              
                </div>
              
                @endif
                <div class="grid grid-cols-4 gap-4 mb-6">
    
                    <div class="bg-white p-4 rounded-xl shadow">
                        <p class="text-gray-500">nombre totale des clients</p>
                        <p class="text-2xl font-bold">{{$clients }}</p>
                    </div>
                
                    <div class="bg-white p-4 rounded-xl shadow">
                        <p class="text-gray-500">nombre totale des hotes</p>
                        <p class="text-2xl font-bold">{{$hote }}</p>
                    </div>

                    <div class="bg-white p-4 rounded-xl shadow">
                        <p class="text-gray-500">nombre totale des agents</p>
                        <p class="text-2xl font-bold">{{$agents }}</p>
                    </div>
                
                    <div class="bg-white p-4 rounded-xl shadow">
                        <p class="text-gray-500">nombre totale des réservations</p>
                        <p class="text-2xl font-bold">{{$reservation }}</p>
                    </div>

                    <div class="bg-white p-4 rounded-xl shadow">
                        <p class="text-gray-500">nombre totale des hébergements</p>
                        <p class="text-2xl font-bold">{{$hebs }}</p>
                    </div>
                 
                
                
                </div>
        
        
               
        
            </main>
        
        </div>
        
      
</x-app-layout>