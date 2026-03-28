
  

<div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="mt-4 p-5 flex ">
            <div>
               <!--
                <div class="space-x-4 ">
                    type :
                    <a class="p-2  rounded-xl bg-slate-200 hover:bg-slate-400" href="">tous</a>
                    <a class="p-2  rounded-xl bg-slate-200 hover:bg-slate-400" href="">villa</a>
                    <a class="p-2  rounded-xl bg-slate-200 hover:bg-slate-400" href="">appartement</a>
                    <a class="p-2  rounded-xl bg-slate-200 hover:bg-slate-400" href="">dortoire</a>
                    <a class="p-2  rounded-xl bg-slate-200 hover:bg-slate-400" href="">hotel</a>
                 
                 
                </div>
              -->

                <div class="my-3 ">
                    <p class="text-2xl font-bold "> {{ $count_heb }} hébergements disponible</p>
                    <p class="text-xl "> explorer notre sélection hébergement</p>
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                      @foreach ($hebs as $heb)
                          <a href="/client/Hebergement/{{$heb->id}}" class="bg-white rounded-2xl shadow-md overflow-hidden ">
                                <div class="space-y-0.5">
                                @php
                                  $image= json_decode($heb->images)   
                                @endphp      
                                    <img src="{{asset('storage/'.$image[0])}}" alt="heb"  class="w-96 h-64 object-cover rounded-lg shadow">
                                             
                                               
                                                        <p class="p-1 text-xl text-black line-clamp-3 font-bold">
                                                          {{ $heb->nomHeberg }}
                                                          
                                                         
                                                        </p> 
                                                        <p class="p-1 text-sm text-black line-clamp-3 font-bold">
                                                          {{ $heb->addresse }}
                                                          
                                                         
                                                        </p> 
                                                        <p class="p-1 text-xl text-black line-clamp-3 ">
                                                          {{ $heb->typeHeberg }}  
                                                           
                                                        </p> 
                                                        <p class="p-1 text-sm text-black line-clamp-3 text-bold">
                                                            prix  {{ $heb->prix }} DZD par nuit   <i class="fa-solid fa-star"></i> 0
                                                         
                                                        </p> 
                                                   
                                             
                                                  
        
                                                        
                                       
                                                       
                                                       
                                            
                                             
                                  </div>
        
                          </a>  
                          @endforeach           
                   
                    </div>     
                
                </div>    
            </div>
          
          </div>
        </div>
    </div>
</div>

