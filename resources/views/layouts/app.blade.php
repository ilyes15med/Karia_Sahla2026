<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <script src="https://cdn.tailwindcss.com"></script>


        <!-- Fonts -->
            <link rel="preconnect" href="https://fonts.bunny.net">
            <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/js/echo.js'])
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
          
           
            notifBtn.addEventListener('click', () => {
                notifDropdown.classList.toggle('hidden');
        
                // تصفير العداد
                count = 0;
                notifCount.innerText = 0;
                notifCount.classList.add('hidden');
            });
             //role
             const role="{{ auth()->user()->role }}";
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



                    
                  
                    }
                 
                }
            });
        </script>
    </body>
</html>