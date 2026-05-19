<x-app-layout>
  <!-- route("Reservation.store",$chambre->id)-->
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
<form method="post" action="{{route("chargilypay.redirect",$chambre->id)}}" >   
@csrf   
    <!-- ETAPE 1 -->
    <div id="etape1" class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
    
    <div class="flex justify-center mb-6">
    <img src="{{asset('/assets/images/logo.png')}}" class="w-40 h-40 object-contain">
    </div>
    
    <p class="text-2xl mb-6">Étape 1</p>
    
    <div class="space-y-4">

    
    <div>
@if( session('date_arrivee') && session('date_depart'))
    <label>Date d'arrivée</label>
    <input type="datetime-local" id="date_arrivee" name="date_arrivee"   min="{{ now()->format('Y-m-d\TH:i') }}" value="{{ session('date_arrivee')  }}" required
    class="w-full border rounded-lg px-3 py-2">
    </div>
    
    <div>
    <label>Date de départ</label>
    <input type="datetime-local" id="date_depart" name="date_depart" value="{{ session('date_depart') }}"
    class="w-full border rounded-lg px-3 py-2" min="{{ now()->addDay()->format('Y-m-d\TH:i') }}"  required>
    </div>
@else 
<label>Date d'arrivée</label>
<input type="datetime-local" id="date_arrivee"  name="date_arrivee" 
class="w-full border rounded-lg px-3 py-2"  min="{{ now()->format('Y-m-d\TH:i') }}"  required>
</div>

<div>
<label>Date de départ</label>
<input type="datetime-local" id="date_depart" name="date_depart"
class="w-full border rounded-lg px-3 py-2" min="{{ now()->addDay()->format('Y-m-d\TH:i') }}" required>
</div>
@endif  
    
        
        
    
    <button type="button" onclick="nextStep1({{ $chambre->prix }},{{ $chambre->nombre_lit }})"
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
        <p class="text-xl mb-6 text-red-600"> les coordonnées </p>
    
    <div>
    <label>Nom complet</label>
    <input type="text" id="name" name="name"
    class="w-full border rounded-lg px-3 py-2" required>
    </div>
    <div>
        <label>Numéro de téléphone</label>
        <input type="text" id="numTel" name="numTel"
        class="w-full border rounded-lg px-3 py-2" required>
        </div>
    
    <div>
    <label>Identifiant carte nationale</label>
    <input type="text" id="idCarteNationel" name="idCarteNationel"
    class="w-full border rounded-lg px-3 py-2" required>
    </div>
    
    <div>
    <label>Adresse</label>
    <input type="text" id="adresse" name="adresse"
    class="w-full border rounded-lg px-3 py-2" required >
    </div>
    
    <div class="flex gap-2">
    
    <button type="button" onclick="prevStep1()"
    class="w-full bg-red-600 text-white p-2 rounded-lg">
    Précédent
    </button>
    
    <button type="button" onclick="nextStep2()"
    class="w-full bg-blue-600 text-white p-2 rounded-lg">
    Suivant
    </button>
    
    </div>
    
    </div>
    </div>
    </div>
    
    
   <!-- ETAPE 3 -->
<div id="etape3" class="hidden bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-2xl">

        <div class="flex justify-center mb-6">
            <img src="{{ asset('/assets/images/logo.png') }}" class="w-40 h-40 object-contain">
        </div>

        <p class="text-2xl font-bold mb-6 text-center">Confirmation</p>

        <div class="grid grid-cols-2 gap-6">

            <!-- Colonne gauche : Coordonnées -->
            <div class="bg-gray-50 p-4 rounded-xl space-y-3">
                <p class="text-lg font-semibold text-gray-700 border-b pb-2">📋 Coordonnées</p>
                <p><b>Nom complet :</b> <span id="show_name"></span></p>
                <p><b>CIN :</b> <span id="show_cin"></span></p>
                <p><b>Adresse :</b> <span id="show_adresse"></span></p>
                <p><b>Téléphone :</b> <span id="show_numTel"></span></p>
            </div>

            <!-- Colonne droite : Tarifs -->
            <div class="bg-gray-50 p-4 rounded-xl space-y-3">
                <p class="text-lg font-semibold text-gray-700 border-b pb-2">💰 Tarifs</p>
                <p><b>Chambre :</b> {{ $chambre->typeChambres }} {{ $chambre->nombre_lit }} <i class="fa-solid fa-person"></i></p>
                <p><b>Prix / nuit :</b> {{ $chambre->prix }} DZD</p>
                <p><b>Taxe :</b>  %</p>

                <p><b>Date début :</b> <span id="show_date_arrivee"></span></p>
                <p><b>Date fin :</b> <span id="show_date_depart"></span></p>
                <p><b>Nuits :</b> <span id="nuit"></span></p>
                <p class="text-lg font-bold text-green-600 border-t pt-2">
                    <b>Total :</b> <span id="prix_totale"></span> DZD
                </p>
            </div>

        </div>

        <input type="hidden" id="prix_total" name="prix_total" value=""/>

        <div class="flex gap-2 mt-6">
            <!-- tes boutons ici -->
    <div class="flex gap-2 mt-6">
    
    <button type="button" onclick="prevStep2()"
    class="w-full bg-red-600 text-white p-2 rounded-lg">    
    Précédent
    </button>

    <button type="submit" class="w-full bg-green-600 text-white p-2 rounded-lg">
    Payer
    </button>
    
    </div>
        </div>

    </div>
</div>
    
    <
    
    </div>
    </div>
</form>
    
    </x-app-layout>
    
    
    <script>
     /*      let date_debut= localStorage.getItem("date_debut")
        let date_fin= localStorage.getItem("date_fin")
       if(date_debut && date_fin ){
        document.getElementById("date_arrivee").value= date_debut
        document.getElementById("date_depart").value= date_fin
    
    
    
    
       }
    
   */
    function nextStep1(prix_chambre,nombreP){
        event.preventDefault();
  

    
    let date_arrivee = document.getElementById("date_arrivee").value
    let date_depart = document.getElementById("date_depart").value
  
    
    localStorage.setItem("date_arrivee",date_arrivee)
    localStorage.setItem("date_depart",date_depart)
    //stocker le prix de chambre et nombre personne == nombre de lit
    localStorage.setItem("prix_chambre",prix_chambre)
    ///mais le nombre de personne la yahom car le chambre double je connue 2 lit donc == 2 personnes et connue meme leprix
    localStorage.setItem("nombre_persoone",nombreP)

     
 
   

  
    
    document.getElementById("etape1").classList.add("hidden")
    document.getElementById("etape2").classList.remove("hidden")
    
    }
    
    
    function nextStep2(){
        event.preventDefault();
    let name = document.getElementById("name").value
    let idCarteNationel = document.getElementById("idCarteNationel").value
    let numTel = document.getElementById("numTel").value
    let adresse = document.getElementById("adresse").value
    
    localStorage.setItem("name",name)
    localStorage.setItem("idCarteNationel",idCarteNationel)
    localStorage.setItem("adresse",adresse)
    localStorage.setItem("numTel",numTel)

    //nombre nuit:
    let date_arrivee=new Date(localStorage.getItem("date_arrivee"))
    let date_depart=new Date(localStorage.getItem("date_depart"))
    let diff=date_depart-date_arrivee
    let nuit=diff/ (1000 * 60 * 60 * 24)
    localStorage.setItem("nuit",nuit)

    //prix totale
    let prix_chambre=Number(localStorage.getItem("prix_chambre"))
    let prix_totale=nuit*prix_chambre

    localStorage.setItem("prix_totale",prix_totale)



    
    document.getElementById("etape2").classList.add("hidden")
    document.getElementById("etape3").classList.remove("hidden")
    
    showData()
    
    }
    
    
    function showData(){
    
    document.getElementById("show_name").innerText = localStorage.getItem("name")
    document.getElementById("show_cin").innerText = localStorage.getItem("idCarteNationel")
    document.getElementById("show_adresse").innerText = localStorage.getItem("adresse")
    document.getElementById("show_numTel").innerText = localStorage.getItem("numTel")
    
    
    document.getElementById("show_date_arrivee").innerText = localStorage.getItem("date_arrivee")
    document.getElementById("show_date_depart").innerText = localStorage.getItem("date_depart")
    document.getElementById("nuit").innerText= localStorage.getItem("nuit")
    document.getElementById("prix_totale").innerText= localStorage.getItem("prix_totale")
    document.getElementById("prix_total").value= localStorage.getItem("prix_totale")
    
    //document.getElementById("show_adultes").innerText = localStorage.getItem("adultes")
   // document.getElementById("show_enfants").innerText = localStorage.getItem("Enfants")
   // document.getElementById("show_bibies").innerText = localStorage.getItem("bibies")
    
    }
    
    
    function prevStep1(){
    event.preventDefault();
    document.getElementById("etape2").classList.add("hidden")
    document.getElementById("etape1").classList.remove("hidden")
    
    }
    
    
    function prevStep2(){
    event.preventDefault();
    document.getElementById("etape3").classList.add("hidden")
    document.getElementById("etape2").classList.remove("hidden")
    
    }

   
    const dateArrivee = document.getElementById('date_arrivee');
    const dateDepart  = document.getElementById('date_depart');

    // ✅ Fonction pour formater sans conversion UTC
    function toLocalDateTimeString(date) {
        const yyyy = date.getFullYear();
        const MM   = String(date.getMonth() + 1).padStart(2, '0');
        const dd   = String(date.getDate()).padStart(2, '0');
        const hh   = String(date.getHours()).padStart(2, '0');
        const mm   = String(date.getMinutes()).padStart(2, '0');
        return `${yyyy}-${MM}-${dd}T${hh}:${mm}`;
    }

    // Au chargement
    dateArrivee.min = toLocalDateTimeString(new Date());

    dateArrivee.addEventListener('change', function() {
        if (!this.value) return;

        const arrivee = new Date(this.value);

        // ✅ +1 jour même heure locale
        const depart = new Date(arrivee);
        depart.setDate(depart.getDate() + 1);

        const departStr = toLocalDateTimeString(depart);

        // ✅ Toujours réinitialiser date fin
        dateDepart.value = departStr;
        dateDepart.min   = departStr;
    });

    dateDepart.addEventListener('change', function() {
        if (!dateArrivee.value) return;

        const arrivee      = new Date(dateArrivee.value);
        const departChoisi = new Date(this.value);
        const departMin    = new Date(arrivee);
        departMin.setDate(departMin.getDate() + 1);

        // ✅ Forcer même heure locale que l'arrivée
        departChoisi.setHours(arrivee.getHours());
        departChoisi.setMinutes(arrivee.getMinutes());

        if (departChoisi < departMin) {
            this.value = toLocalDateTimeString(departMin);
        } else {
            this.value = toLocalDateTimeString(departChoisi);
        }
    });



    </script>