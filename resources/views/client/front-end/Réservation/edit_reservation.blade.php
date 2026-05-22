<x-app-layout>

    @if(session('succes'))
      <div id="message" class="bg-green-100 text-green-700 p-3 rounded-lg shadow-sm mb-4">
       <span>{{ session('succes')}}</span>
       <button onclick="document.getElementById('message').remove()" 
       class="pl-1 text-green-700 font-bold hover:text-red-500">
         <i class="fa-solid fa-trash"></i>
       </button>
      </div>
    @endif
    
    <form method="post" action="/chargilypay/edit/{{$reservation->id}}">
    @csrf
    
    <!-- ========== PROGRESS BAR ========== -->
    <div class=" top-16 left-0 w-full z-40 bg-white shadow-sm px-6 py-4">
        <div class="flex items-center justify-between max-w-md mx-auto">
    
            <div class="flex flex-col items-center">
                <div id="circle1" class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-white bg-blue-500 transition-all duration-300">1</div>
                <span id="label1" class="text-xs mt-1 font-semibold text-blue-500">Dates</span>
            </div>
    
            <div class="flex-1 mx-2 h-1 rounded bg-gray-200">
                <div id="line1" class="h-1 rounded bg-blue-500 transition-all duration-500" style="width:0%"></div>
            </div>
    
            <div class="flex flex-col items-center">
                <div id="circle2" class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-gray-400 bg-gray-200 transition-all duration-300">2</div>
                <span id="label2" class="text-xs mt-1 font-semibold text-gray-400">Coordonnées</span>
            </div>
    
            <div class="flex-1 mx-2 h-1 rounded bg-gray-200">
                <div id="line2" class="h-1 rounded bg-blue-500 transition-all duration-500" style="width:0%"></div>
            </div>
    
            <div class="flex flex-col items-center">
                <div id="circle3" class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-gray-400 bg-gray-200 transition-all duration-300">3</div>
                <span id="label3" class="text-xs mt-1 font-semibold text-gray-400">Confirmation</span>
            </div>
    
        </div>
    </div>
   
    <!-- ========== END PROGRESS BAR ========== -->
    
    
    <!-- ========== ETAPE 1 ========== -->
    <div id="etape1" class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
    
    <div class="flex justify-center mb-6">
    <img src="{{asset('/assets/images/logo.png')}}" class="w-40 h-40 object-contain">
    </div>
    
    <p class="text-2xl mb-6">Étape 1</p>
    
    <div class="space-y-4">
    
    <div>
    @if(session('date_arrivee') && session('date_depart'))
        <label>Date d'arrivée</label>
        <input type="datetime-local" id="date_arrivee" name="date_arrivee" min="{{ now()->format('Y-m-d\TH:i') }}" value="{{ session('date_arrivee') }}" required
        class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
        <label>Date de départ</label>
        <input type="datetime-local" id="date_depart" name="date_depart" min="{{ now()->addDay()->format('Y-m-d\TH:i') }}"  value="{{ session('date_depart') }}" required
        class="w-full border rounded-lg px-3 py-2">
        </div>
    @else
    <label>Date d'arrivée</label>
    <input type="datetime-local" id="date_arrivee" name="date_arrivee" min="{{ now()->format('Y-m-d\TH:i') }}" value="{{ $reservation->date_debut }}" required
    class="w-full border rounded-lg px-3 py-2">
    </div>
    <div>
    <label>Date de départ</label>
    <input type="datetime-local" id="date_depart" name="date_depart" min="{{ now()->addDay()->format('Y-m-d\TH:i') }}"  value="{{ $reservation->date_fin }}" required
    class="w-full border rounded-lg px-3 py-2">
    </div>
    @endif
    
    <button type="button" onclick="nextStep1({{ $chambre->prix }}, {{ $chambre->nombre_lit }}, {{ $chambre->taxe }})"
    class="w-full bg-blue-600 text-white p-2 rounded-lg">
        Suivant
    </button>
    
    </div>
    </div>
    </div>
    
    
    <!-- ========== ETAPE 2 ========== -->
    <div id="etape2" class="hidden bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
    
    <div class="flex justify-center mb-6">
    <img src="{{asset('/assets/images/logo.png')}}" class="w-40 h-40 object-contain">
    </div>
    
    <p class="text-2xl mb-6">Étape 2</p>
    
    <div class="space-y-4">
        <p class="text-xl mb-6 text-red-600">les coordonnées</p>
    
    <div>
    <label>Nom complet</label>
    <input type="text" id="name" name="name" value="{{ $reservation->nom_complet }}"
    class="w-full border rounded-lg px-3 py-2" required>
    </div>
    
    <div>
    <label>Numéro de téléphone</label>
    <input type="text" id="numTel" name="numTel" value="{{ $reservation->NumTelephone }}"
    class="w-full border rounded-lg px-3 py-2" required>
    </div>
    
    <div>
    <label>Identifiant carte nationale</label>
    <input type="text" id="idCarteNationel" name="idCarteNationel" value="{{ $reservation->idCarteNational }}"
    class="w-full border rounded-lg px-3 py-2" required>
    </div>
    
    <div>
    <label>Adresse</label>
    <input type="text" id="adresse" name="adresse" value="{{ $reservation->addresse }}"
    class="w-full border rounded-lg px-3 py-2" required>
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
    
    
    <!-- ========== ETAPE 3 ========== -->
    <div id="etape3" class="hidden bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-2xl">
    
        <div class="flex justify-center mb-6">
            <img src="{{ asset('/assets/images/logo.png') }}" class="w-40 h-40 object-contain">
        </div>
    
        <p class="text-2xl font-bold mb-6 text-center">Confirmation</p>
    
        <div class="grid grid-cols-2 gap-6">
    
            <!-- Coordonnées -->
            <div class="bg-gray-50 p-4 rounded-xl space-y-3">
                <p class="text-lg font-semibold text-gray-700 border-b pb-2">
                    <i class="fa-solid fa-address-card mr-1"></i> Coordonnées
                </p>
                <p><b><i class="fa-solid fa-user mr-1"></i> Nom complet :</b> <span id="show_name"></span></p>
                <p><b><i class="fa-solid fa-id-card mr-1"></i> CIN :</b> <span id="show_cin"></span></p>
                <p><b><i class="fa-solid fa-location-dot mr-1"></i> Adresse :</b> <span id="show_adresse"></span></p>
                <p><b><i class="fa-solid fa-phone mr-1"></i> Téléphone :</b> <span id="show_numTel"></span></p>
            </div>
    
            <!-- Tarifs -->
            <div class="bg-gray-50 p-4 rounded-xl space-y-3">
                <p class="text-lg font-semibold text-gray-700 border-b pb-2">
                    <i class="fa-solid fa-receipt mr-1"></i> Tarifs
                </p>
                <p><b><i class="fa-solid fa-bed mr-1"></i> Chambre :</b> {{ $chambre->typeChambres }} {{ $chambre->nombre_lit }} <i class="fa-solid fa-person"></i></p>
                <p><b><i class="fa-solid fa-money-bill mr-1"></i> Prix / nuit :</b> {{ $chambre->prix }} DZD</p>
                <p><b><i class="fa-solid fa-percent mr-1"></i> Taxe :</b> {{ $chambre->taxe }} %</p>
                <p><b><i class="fa-solid fa-calendar-day mr-1"></i> Date début :</b> <span id="show_date_arrivee"></span></p>
                <p><b><i class="fa-solid fa-calendar-check mr-1"></i> Date fin :</b> <span id="show_date_depart"></span></p>
                <p><b><i class="fa-solid fa-moon mr-1"></i> Nuits :</b> <span id="nuit"></span></p>
    
                <!-- CODE PROMO -->
                <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <p class="font-semibold mb-2"><i class="fa-solid fa-tag mr-1"></i> Code promo</p>
                    <div class="flex gap-2">
                        <input type="text" id="input_code_promo" placeholder="Entrez votre code promo"
                            class="flex-1 border rounded-lg px-3 py-2 text-sm" />
                        <button type="button" onclick="appliquerCode('{{ $chambre->code_promo }}', {{ $chambre->pourcentage_codepromo }})"
                            class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                            Appliquer
                        </button>
                    </div>
                    <p id="msg_promo" class="mt-2 text-sm"></p>
                </div>
    
                <p class="text-lg font-bold text-green-600 border-t pt-2">
                    <b><i class="fa-solid fa-receipt mr-1"></i> Total :</b> <span id="prix_totale"></span> DZD
                </p>
    
                <p id="bloc_nouvelle_prix" class="hidden text-lg font-bold text-green-600 border-t pt-2">
                    <b><i class="fa-solid fa-tag mr-1"></i> Nouveau prix :</b> <span id="Nouvelle_prix"></span> DZD
                </p>
            </div>
    
            <!-- Conditions -->
            <div class="col-span-2 bg-gray-50 p-4 rounded-xl">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="checkbox" id="acceptConditions" class="mt-1 accent-blue-600" required>
                    <span>
                        J'accepte toutes
                        
                        concernant cet hébergement et ses chambres
                    </span>
                </label>
                <div id="conditionsBox" class="hidden mt-3 bg-white border rounded-lg p-3 text-sm text-gray-600">
                   
                </div>
            </div>
    
        </div>
    
        <input type="hidden" id="prix_total" name="prix_total" value=""/>
    
        <!-- Boutons paiement selon le type choisi par l'admin -->
        <div class="flex flex-col gap-3 mt-6">
    
            <button type="button" onclick="prevStep2()"
            class="w-full bg-red-600 text-white p-2 rounded-lg">
                <i class="fa-solid fa-arrow-left mr-1"></i> Précédent
            </button>
    
            @if($chargilypay->status == 'pending')
                <button type="submit" name="mode_paiement" value="a_larrivee"
                class="w-full bg-orange-500 text-white p-3 rounded-lg font-semibold">
                    <i class="fa-solid fa-money-bill-wave mr-1"></i> Payer à l'arrivée
                </button>
    
            @elseif($chargilypay->status  == 'paid')
                <button type="submit" name="mode_paiement" value="en_ligne"
                class="w-full bg-green-600 text-white p-3 rounded-lg font-semibold">
                    <i class="fa-solid fa-credit-card mr-1"></i> Payer en ligne
                </button>
    
          
            @endif
    
        </div>
    
    </div>
    </div>
    
    </form>
    
    </x-app-layout>
    
    
    <script>
    
    /* ========== PROGRESS BAR ========== */
    function updateProgress(step) {
        const circles = ['circle1','circle2','circle3'].map(id => document.getElementById(id));
        const labels  = ['label1','label2','label3'].map(id => document.getElementById(id));
    
        circles.forEach((c, i) => {
            if (i < step - 1) {
                c.className = "w-9 h-9 rounded-full flex items-center justify-center font-bold text-white bg-green-500 transition-all duration-300";
                c.innerHTML = '<i class="fa-solid fa-check"></i>';
                labels[i].className = "text-xs mt-1 font-semibold text-green-500";
            } else if (i === step - 1) {
                c.className = "w-9 h-9 rounded-full flex items-center justify-center font-bold text-white bg-blue-500 transition-all duration-300";
                c.innerHTML = i + 1;
                labels[i].className = "text-xs mt-1 font-semibold text-blue-500";
            } else {
                c.className = "w-9 h-9 rounded-full flex items-center justify-center font-bold text-gray-400 bg-gray-200 transition-all duration-300";
                c.innerHTML = i + 1;
                labels[i].className = "text-xs mt-1 font-semibold text-gray-400";
            }
        });
    
        document.getElementById('line1').style.width = step >= 2 ? '100%' : '0%';
        document.getElementById('line2').style.width = step >= 3 ? '100%' : '0%';
    }
    
    /* ========== ETAPES ========== */
    function nextStep1(prix_chambre, nombreP, Taxe) {
        event.preventDefault();
    
        let date_arrivee = document.getElementById("date_arrivee").value;
        let date_depart  = document.getElementById("date_depart").value;
    
        localStorage.setItem("date_arrivee", date_arrivee);
        localStorage.setItem("date_depart",  date_depart);
        localStorage.setItem("prix_chambre", prix_chambre);
        localStorage.setItem("nombre_persoone", nombreP);
        localStorage.setItem("taxe", Taxe);
    
        updateProgress(2);
        document.getElementById("etape1").classList.add("hidden");
        document.getElementById("etape2").classList.remove("hidden");
    }
    
    function nextStep2() {
        event.preventDefault();
    
        let name            = document.getElementById("name").value;
        let idCarteNationel = document.getElementById("idCarteNationel").value;
        let numTel          = document.getElementById("numTel").value;
        let adresse         = document.getElementById("adresse").value;
    
        localStorage.setItem("name", name);
        localStorage.setItem("idCarteNationel", idCarteNationel);
        localStorage.setItem("adresse", adresse);
        localStorage.setItem("numTel", numTel);
    
        let date_arrivee = new Date(localStorage.getItem("date_arrivee"));
        let date_depart  = new Date(localStorage.getItem("date_depart"));
        let diff  = date_depart - date_arrivee;
        let nuit  = diff / (1000 * 60 * 60 * 24);
        localStorage.setItem("nuit", nuit);
    
        let taxe         = localStorage.getItem("taxe");
        let prix_chambre = Number(localStorage.getItem("prix_chambre"));
        let prix_totale  = (nuit * prix_chambre) + ((nuit * prix_chambre) * (taxe / 100));
        localStorage.setItem("prix_totale", prix_totale);
    
        updateProgress(3);
        document.getElementById("etape2").classList.add("hidden");
        document.getElementById("etape3").classList.remove("hidden");
    
        showData();
    }
    
    function prevStep1() {
        event.preventDefault();
        updateProgress(1);
        document.getElementById("etape2").classList.add("hidden");
        document.getElementById("etape1").classList.remove("hidden");
    }
    
    function prevStep2() {
        event.preventDefault();
        updateProgress(2);
        document.getElementById("etape3").classList.add("hidden");
        document.getElementById("etape2").classList.remove("hidden");
    }
    
    /* ========== SHOW DATA ========== */
    function showData() {
        document.getElementById("show_name").innerText    = localStorage.getItem("name");
        document.getElementById("show_cin").innerText     = localStorage.getItem("idCarteNationel");
        document.getElementById("show_adresse").innerText = localStorage.getItem("adresse");
        document.getElementById("show_numTel").innerText  = localStorage.getItem("numTel");
    
        document.getElementById("show_date_arrivee").innerText = localStorage.getItem("date_arrivee");
        document.getElementById("show_date_depart").innerText  = localStorage.getItem("date_depart");
        document.getElementById("nuit").innerText        = localStorage.getItem("nuit");
        document.getElementById("prix_totale").innerText = localStorage.getItem("prix_totale");
        document.getElementById("prix_total").value      = localStorage.getItem("prix_totale");
        document.getElementById("Nouvelle_prix").innerText = localStorage.getItem("Nouvelle_prix") || '';
    }
    
    /* ========== CODE PROMO ========== */
    function appliquerCode(codepromo, pourcentageDiminue) {
        let input_code_promo = document.getElementById("input_code_promo").value;
    
        if (input_code_promo === codepromo) {
            document.getElementById("msg_promo").innerHTML = '<span class="text-green-600"><i class="fa-solid fa-circle-check mr-1"></i>Code promo appliqué !</span>';
    
            let prixTotal   = localStorage.getItem("prix_totale");
            let remise      = prixTotal * (pourcentageDiminue / 100);
            let nouveauPrix = prixTotal - remise;
    
            localStorage.setItem("Nouvelle_prix", nouveauPrix);
            document.getElementById("Nouvelle_prix").innerText = nouveauPrix;
            document.getElementById("prix_total").value = nouveauPrix;
            document.getElementById("bloc_nouvelle_prix").classList.remove("hidden");
    
        } else {
            document.getElementById("msg_promo").innerHTML = '<span class="text-red-500"><i class="fa-solid fa-circle-xmark mr-1"></i>Code promo invalide</span>';
            document.getElementById("bloc_nouvelle_prix").classList.add("hidden");
        }
    }
     /* ========== DATE VALIDATION ========== */
     const dateArrivee = document.getElementById('date_arrivee');
    const dateDepart  = document.getElementById('date_depart');
    
    function toLocalDateTimeString(date) {
        const yyyy = date.getFullYear();
        const MM   = String(date.getMonth() + 1).padStart(2, '0');
        const dd   = String(date.getDate()).padStart(2, '0');
        const hh   = String(date.getHours()).padStart(2, '0');
        const mm   = String(date.getMinutes()).padStart(2, '0');
        return `${yyyy}-${MM}-${dd}T${hh}:${mm}`;
    }
    
    dateArrivee.min = toLocalDateTimeString(new Date());
    
    dateArrivee.addEventListener('change', function() {
        if (!this.value) return;
        const arrivee = new Date(this.value);
        const depart  = new Date(arrivee);
        depart.setDate(depart.getDate() + 1);
        const departStr  = toLocalDateTimeString(depart);
        dateDepart.value = departStr;
        dateDepart.min   = departStr;
    });
    
    dateDepart.addEventListener('change', function() {
        if (!dateArrivee.value) return;
        const arrivee      = new Date(dateArrivee.value);
        const departChoisi = new Date(this.value);
        const departMin    = new Date(arrivee);
        departMin.setDate(departMin.getDate() + 1);
        departChoisi.setHours(arrivee.getHours());
        departChoisi.setMinutes(arrivee.getMinutes());
        if (departChoisi < departMin) {
            this.value = toLocalDateTimeString(departMin);
        } else {
            this.value = toLocalDateTimeString(departChoisi);
        }
    });
    
    /* ========== INIT ========== */
    updateProgress(1);
    
    </script>