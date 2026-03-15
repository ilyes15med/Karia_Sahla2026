<x-app-layout>

    <!-- ETAPE 1 -->
    <div id="etape1" class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
    
    <div class="flex justify-center mb-6">
    <img src="{{asset('/assets/images/logo.png')}}" class="w-40 h-40 object-contain">
    </div>
    
    <p class="text-2xl mb-6">Étape 1</p>
    
    <div class="space-y-4">
    
    <div>
    <label>Date d'arrivée</label>
    <input type="date" id="date_arrivee"
    class="w-full border rounded-lg px-3 py-2">
    </div>
    
    <div>
    <label>Date de départ</label>
    <input type="date" id="date_depart"
    class="w-full border rounded-lg px-3 py-2">
    </div>
    
    <div>
    <label>Adultes</label>
    <input type="number" id="adultes" value="1"
    class="w-full border rounded-lg px-3 py-2">
    </div>
    
    <button onclick="nextStep1()"
    class="w-full bg-blue-600 text-white p-2 rounded-lg">
    Suivant
    </button>
    
    </div>
    </div>
    </div>
    
    
    <!-- ETAPE 2 -->
    <div id="etape2" class="hidden bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
    
    <div class="flex justify-center mb-6">
    <img src="{{asset('/assets/images/logo.png')}}" class="w-40 h-40 object-contain">
    </div>
    
    <p class="text-2xl mb-6">Étape 2</p>
    
    <div class="space-y-4">
    
    <div>
    <label>Nom complet</label>
    <input type="text" id="name"
    class="w-full border rounded-lg px-3 py-2">
    </div>
    
    <div>
    <label>Identifiant carte nationale</label>
    <input type="text" id="cin"
    class="w-full border rounded-lg px-3 py-2">
    </div>
    
    <div>
    <label>Adresse</label>
    <input type="text" id="adresse"
    class="w-full border rounded-lg px-3 py-2">
    </div>
    
    <div class="flex gap-2">
    
    <button onclick="prevStep1()"
    class="w-full bg-red-600 text-white p-2 rounded-lg">
    Précédent
    </button>
    
    <button onclick="nextStep2()"
    class="w-full bg-blue-600 text-white p-2 rounded-lg">
    Suivant
    </button>
    
    </div>
    
    </div>
    </div>
    </div>
    
    
    <!-- ETAPE 3 -->
    <div id="etape3" class="hidden bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
    
    <div class="flex justify-center mb-6">
    <img src="{{asset('/assets/images/logo.png')}}" class="w-40 h-40 object-contain">
    </div>
    
    <p class="text-2xl mb-6">Confirmation</p>
    
    <div class="space-y-2">
    
    <p><b>Nom :</b> <span id="show_name"></span></p>
    
    <p><b>CIN :</b> <span id="show_cin"></span></p>
    
    <p><b>Adresse :</b> <span id="show_adresse"></span></p>
    
    <p><b>Date début :</b> <span id="show_date_arrivee"></span></p>
    
    <p><b>Date fin :</b> <span id="show_date_depart"></span></p>
    
    <p><b>Adultes :</b> <span id="show_adultes"></span></p>
    <p><b>prix total  :</b> <span id="prix"></span></p>
    
    </div>
    
    <div class="flex gap-2 mt-6">
    
    <button onclick="prevStep2()"
    class="w-full bg-red-600 text-white p-2 rounded-lg">
    Précédent
    </button>
    
    <button class="w-full bg-green-600 text-white p-2 rounded-lg">
    Payer
    </button>
    
    </div>
    
    </div>
    </div>
    
    </x-app-layout>
    
    
    <script>
    
    function nextStep1(){
    
    let date_arrivee = document.getElementById("date_arrivee").value
    let date_depart = document.getElementById("date_depart").value
    let adultes = document.getElementById("adultes").value
    
    localStorage.setItem("date_arrivee",date_arrivee)
    localStorage.setItem("date_depart",date_depart)
    localStorage.setItem("adultes",adultes)
    
    document.getElementById("etape1").classList.add("hidden")
    document.getElementById("etape2").classList.remove("hidden")
    
    }
    
    
    function nextStep2(){
    
    let name = document.getElementById("name").value
    let cin = document.getElementById("cin").value
    let adresse = document.getElementById("adresse").value
    
    localStorage.setItem("name",name)
    localStorage.setItem("cin",cin)
    localStorage.setItem("adresse",adresse)
    
    document.getElementById("etape2").classList.add("hidden")
    document.getElementById("etape3").classList.remove("hidden")
    
    showData()
    
    }
    
    
    function showData(){
    
    document.getElementById("show_name").innerText = localStorage.getItem("name")
    document.getElementById("show_cin").innerText = localStorage.getItem("cin")
    document.getElementById("show_adresse").innerText = localStorage.getItem("adresse")
    
    document.getElementById("show_date_arrivee").innerText = localStorage.getItem("date_arrivee")
    document.getElementById("show_date_depart").innerText = localStorage.getItem("date_depart")
    document.getElementById("show_adultes").innerText = localStorage.getItem("adultes")
    
    }
    
    
    function prevStep1(){
    
    document.getElementById("etape2").classList.add("hidden")
    document.getElementById("etape1").classList.remove("hidden")
    
    }
    
    
    function prevStep2(){
    
    document.getElementById("etape3").classList.add("hidden")
    document.getElementById("etape2").classList.remove("hidden")
    
    }
    
    </script>