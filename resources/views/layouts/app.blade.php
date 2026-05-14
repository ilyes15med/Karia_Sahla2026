<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href="./output.css" rel="stylesheet">
       


        <!-- Fonts -->
            <link rel="preconnect" href="https://fonts.bunny.net">
            <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/js/echo.js'])
    @livewireStyles
      
         
      
        

       @stack('styles')
       @stack('scripts')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

   
<script>
            
    let count = 0;
            
    const notifBtn = document.getElementById('notifBtn');
    const notifCount = document.getElementById('notifCount');
    const notifList = document.getElementById('notifList');
    const notifDropdown = document.getElementById('notifDropdown');
            
                // إضافة Notification
    function addNotificationAgent(message,hote_name,date_cree,nom_heb) {
                    count++;
            
                    // تحديث الرقم
                    notifCount.innerText = count;
                    notifCount.classList.remove('hidden');
            
                    // إضافة الرسالة
                    const li = document.createElement('li');
            
                    li.className = "p-2 bg-gray-100 rounded";
                    li.innerText = "hote "+hote_name+message+" hebergement "+nom_heb+" at "+date_cree;
            
                    notifList.prepend(li);
    }
    //reservation
    
    function receiveNotificationReservation(name_client,message,type){
    count++;
    
    // تحديث الرقم
    notifCount.innerText = count;
    notifCount.classList.remove('hidden');
    
    // إضافة الرسالة
    const li = document.createElement('li');
    
    li.className = "p-2 bg-gray-100 rounded";
    li.innerText = name_client+message+type;
    
    notifList.prepend(li);
    
    
    
    
    }
    //evaluation
    
    function receiveNotificationEvaluation(name_client,message,nomheb){
    count++;
    
    // تحديث الرقم
    notifCount.innerText = count;
    notifCount.classList.remove('hidden');
    
    // إضافة الرسالة
    const li = document.createElement('li');
    
    li.className = "p-2 bg-gray-100 rounded";
    li.innerText = `${name_client} ${message} ${nomheb}`;
    
    notifList.prepend(li);
    
    
    
    
    }
    
    function addNotificationHote(name_agent,message) {
        count++;
    
        // تحديث الرقم
        notifCount.innerText = count;
        notifCount.classList.remove('hidden');
    
        // إضافة الرسالة
        const li = document.createElement('li');
    
        li.className = "p-2 bg-gray-100 rounded";
        li.innerText = name_agent+message;
    
        notifList.prepend(li);
    }
    
            
               
                // عند الضغط على الأيقونة
              
                
                if(notifBtn){ 
                notifBtn.addEventListener('click', () => {
                    notifDropdown.classList.toggle('hidden');
            
                    // تصفير العداد
                    count = 0;
                    notifCount.innerText = 0;
                    notifCount.classList.add('hidden');
                });
                }
                 //role
                 const role = "{{ auth()->check() ? auth()->user()->role : '' }}";
               
                // Echo
                document.addEventListener('DOMContentLoaded', () => {
                    if (window.Echo) {
                        if(role==="agent"){
                            window.Echo.private('reqHeb')
                            .listen('.HebRequest', (e) => {
                                addNotificationAgent(e.message,e.hote_name,e.date_create,e.nom_Heb);
                            });
    
    
                        }
                        if(role==="hote"){
                            window.Echo.private('ReponseAHote')
                           .listen('.ReponseReqHote', (e) => {
                       
                            addNotificationHote(e.name_agent,e.message);
                            });
    
                            window.Echo.private('receiveReservation')
                           .listen('.receive_Reservation', (e) => {
                       
                            receiveNotificationReservation(e.clientname,e.message,e.chambre_type);
                            });
    
                            window.Echo.private('Rating')
                           .listen('.receive_evaluation', (e) => {
                       
                            receiveNotificationEvaluation(e.client_name,e.message,e.nom_heb);
                            });
    
    
    
    
                        
                      
                        }
                     
                    }
                });
            </script>
            
          
            <footer class="bg-zinc-900 text-white mt-10">
                @if(optional(auth()->user())->role !='agent' && optional(auth()->user())->role !='hote')

                <div class="max-w-7xl mx-auto px-6 py-10">
                   
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                       
            
                        <!-- Logo / Description -->
                        <div>
                            <h2 class="text-2xl font-bold text-emerald-400">
                                {{ config('app.name') }}
                            </h2>
            
                            <p class="mt-3 text-zinc-400 text-sm leading-6">
                                Plateforme de réservation d’hébergements permettant
                                aux clients de trouver facilement des chambres,
                                hôtels et hébergements touristiques.
                            </p>
                        </div>
            
                        <!-- Navigation -->
                        
                        <div>
                            <h3 class="text-lg font-semibold mb-4">
                                Navigation
                            </h3>
            
                            <ul class="space-y-2 text-zinc-400">
                                @if(optional(auth()->user())->role !='client')

            
                                <li>
                                    <a href="/" class="hover:text-white transition">
                                        Accueil
                                    </a>
                                </li>
            
                                <li>
                                    <a href="/hebergements" class="hover:text-white transition">
                                        Hébergements
                                    </a>
                                </li>

                                <li>
                                    <a href="/about-us" class="hover:text-white transition">
                                        about-us
                                    </a>
                                </li>
            
                                @else
                                <li>
                                    <a href="/client/espace" class="hover:text-white transition">
                                        Accueil
                                    </a>
                                </li>
            
                                <li>
                                    <a href="/client/hebergements" class="hover:text-white transition">
                                        Hébergements
                                    </a>
                                </li>

                                <li>
                                    <a href="/client/about-us" class="hover:text-white transition">
                                        about-us
                                    </a>
                                </li>

                                @endif
            
                            </ul>
                        </div>
                        
                        <!-- Contact -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">
                                Contact
                            </h3>
            
                            <ul class="space-y-3 text-zinc-400 text-sm">
            
                                <li>
                                    <i class="fa-solid fa-envelope mr-2"></i>
                                    support@reservation.com
                                </li>
            
                                <li>
                                    <i class="fa-solid fa-phone mr-2"></i>
                                    +213 000 00 00 00
                                </li>
            
                                <li>
                                    <i class="fa-solid fa-location-dot mr-2"></i>
                                    Tlemcen, Algérie
                                </li>
            
                            </ul>
                        </div>
            
                    </div>
                          
                    @endif
                
                   
            
                </div>
                <!-- Bottom -->
                    <div class="border-t border-zinc-700 mt-8 pt-5 text-center text-zinc-500 text-sm">
                        © {{ date('Y') }} {{ config('app.name') }}.
                    </div>
            </footer>
             
          
       
  @livewireScripts
    </body>
</html>
