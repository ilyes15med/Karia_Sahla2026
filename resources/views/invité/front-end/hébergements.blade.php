<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>hébergements</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body >
  <div class="text-black  flex items-center justify-around fixed top-0 left-0 w-full bg-white shadow z-10">

    <div>
        <a href="/">
            <img src="{{asset('/assets/images/logo.png')}}" 
                 alt="logo"  
                 class="w-40 h-12 object-contain">
        </a>
    </div>
    
    <div class="space-x-4">
        <a href="/">Accueil</a>
        <a href="/Hebergements">hébergements</a>
        <a href="/about-us">A propos</a>
    </div>

    @if (Route::has('login'))
    <nav class="flex items-center justify-end gap-4">
        @auth
            <a
                href="{{ url('/dashboard') }}"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
            >
                Dashboard
            </a>
        @else
            <a
                href="{{ route('login') }}"
                 class="p-2 rounded-xl bg-cyan-600 text-white hover:bg-cyan-700"

                  >
                Log in
            </a>

            @if (Route::has('register'))
                <a
                    href="{{ route('register') }}"
                   
                    class="font-bold"

                   >   
                   Register
                </a>
            @endif
        @endauth
    </nav>
@endif

</div>

<div class="mt-12 p-5 flex ">
    <div>
       
        <div class="space-x-4 ">
            type :
            <a class="p-2  rounded-xl bg-slate-200 hover:bg-slate-400" href="">tous</a>
            <a class="p-2  rounded-xl bg-slate-200 hover:bg-slate-400" href="">villa</a>
            <a class="p-2  rounded-xl bg-slate-200 hover:bg-slate-400" href="">appartement</a>
            <a class="p-2  rounded-xl bg-slate-200 hover:bg-slate-400" href="">dortoire</a>
            <a class="p-2  rounded-xl bg-slate-200 hover:bg-slate-400" href="">hotel</a>
         
         
        </div>
        <div class="my-3">
            <p class="text-2xl font-bold "> 1 hébergements disponible</p>
            <p class="text-xl "> explorer notre sélection hébergement</p>
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                  <a href="/Hebergement" class="bg-white rounded-2xl shadow-md overflow-hidden ">
                        <div class="space-y-0.5">
                                      
                            <img src="{{asset('/assets/images/istockphoto-146765403-612x612.jpg')}}" alt="heb"  class="w-96 h-64 object-cover rounded-lg shadow">
                                     
                                       
                                                <p class="p-1 text-xl text-black line-clamp-3 font-bold">
                                                  nom hébegement
                                                 
                                                </p> 
                                                <p class="p-1 text-xl text-black line-clamp-3 ">
                                                  type hébergement    
                                                   
                                                </p> 
                                                <p class="p-1 text-sm text-black line-clamp-3 text-bold">
                                                    prix DZD par nuit  <i class="fa-solid fa-star"></i> 4.5
                                                 
                                                </p> 
                                           
                                     
                                          

                                                
                               
                                               
                                               
                                    
                                     
                          </div>

                  </a>           
           
            </div>     
        
        </div>    
    </div>
  
</div>  
</body>
</html>  
  
