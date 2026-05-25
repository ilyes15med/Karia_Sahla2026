@php
    $id_hote = null;

    if (Auth::check() && Auth::user()->role == 'hote') {
        $id_hote = Auth::user()->id;
    }
@endphp

<x-app-layout>
   

<div class="flex items-center justify-center min-h-screen bg-gray-100 py-10">

    <form action="{{ route('hebergement.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="w-full max-w-4xl">

        @csrf

        <!-- ================= PROGRESS BAR ================= -->
        <div class="bg-white shadow rounded-2xl p-6 mb-6">

            <div class="flex items-center justify-between">

                <!-- STEP 1 -->
                <div class="flex flex-col items-center">
                    <div id="circle1"
                        class="w-10 h-10 rounded-full flex items-center justify-center bg-blue-500 text-white font-bold">
                        1
                    </div>

                    <span class="text-sm mt-2 text-blue-500 font-semibold">
                        Informations
                    </span>
                </div>

                <div class="flex-1 h-1 bg-gray-200 mx-2 rounded">
                    <div id="line1" class="h-1 bg-blue-500 rounded w-0 transition-all duration-300"></div>
                </div>

                <!-- STEP 2 -->
                <div class="flex flex-col items-center">
                    <div id="circle2"
                        class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-200 text-gray-500 font-bold">
                        2
                    </div>

                    <span class="text-sm mt-2 text-gray-500 font-semibold">
                        Adresse
                    </span>
                </div>

                <div class="flex-1 h-1 bg-gray-200 mx-2 rounded">
                    <div id="line2" class="h-1 bg-blue-500 rounded w-0 transition-all duration-300"></div>
                </div>

                <!-- STEP 3 -->
                <div class="flex flex-col items-center">
                    <div id="circle3"
                        class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-200 text-gray-500 font-bold">
                        3
                    </div>

                    <span class="text-sm mt-2 text-gray-500 font-semibold">
                        Paiement & Annulation
                    </span>
                </div>

            </div>

        </div>

        <!-- ================= ETAPE 1 ================= -->
        <div id="etape1" class="bg-white p-8 rounded-2xl shadow-lg">

            <div class="flex justify-center mb-6">
                <img src="{{ asset('/assets/images/logo.png') }}"
                     class="w-32 h-32 object-contain">
            </div>

            <h2 class="text-2xl text-center font-bold mb-6">
                Ajouter un hébergement
            </h2>

            <div class="space-y-4">

                <!-- Nom -->
                <div>
                    <label class="block mb-1 font-medium">
                        Nom hébergement
                    </label>

                    <input type="text"
                           name="nom_Heb"
                           class="w-full border rounded-lg px-3 py-2"
                           required>
                </div>

                <!-- Type -->
                <div>
                    <label class="block mb-1 font-medium">
                        Type hébergement
                    </label>

                    <select id="type_Heb"
                            name="type_Heb"
                            class="w-full border rounded-lg px-3 py-2"
                            required>

                        <option value="">-- Sélectionnez --</option>
                        <option value="Hotel">Hôtel</option>
                        <option value="Auberge">Auberge</option>
                        <option value="Appartement">Appartement</option>
                        <option value="Maison">Maison</option>
                        <option value="Villa">Villa</option>
                        <option value="Chambre_hotes">Chambre d'hôtes</option>

                    </select>
                </div>

                <!-- Prix -->
                <div>
                    <label class="block mb-1 font-medium">
                        Prix par nuit
                    </label>

                    <input type="number"
                           name="prix"
                           class="w-full border rounded-lg px-3 py-2"
                           required>
                </div>

                <!-- Chambres &lits -->
                <div id="chambre_lit_block" class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block mb-1">
                            Nombre des chambres
                        </label>

                        <input type="number"
                               name="Nmbr_chambres"
                               class="w-full border rounded-lg px-3 py-2">
                    </div>

                    <div>
                        <label class="block mb-1">
                            Nombre des lits
                        </label>

                        <input type="number"
                               name="Nmbr_lits"
                               class="w-full border rounded-lg px-3 py-2">
                    </div>

                </div>


                <script>

                    const typeHeb = document.getElementById('type_Heb');
                    const chambreBlock = document.getElementById('chambre_lit_block');
                
                    function toggleChambreBlock() {
                
                        if (
                            typeHeb.value === "Auberge" ||
                            typeHeb.value === "Hotel" 
                        ) {
                
                            chambreBlock.classList.add('hidden');
                
                        } else {
                
                            chambreBlock.classList.remove('hidden');
                        }
                    }
                
                    // عند تغيير النوع
                    typeHeb.addEventListener('change', toggleChambreBlock);
                
                    // عند تحميل الصفحة
                    toggleChambreBlock();
                
                </script>

               

                <!-- Description -->
                <div>
                    <label class="block mb-1">
                        Description
                    </label>

                    <textarea name="description"
                              rows="4"
                              class="w-full border rounded-lg px-3 py-2"
                              required></textarea>
                </div>

                <!-- Images -->
                <div>
                    <label class="block mb-1">
                        Images
                    </label>

                    <input type="file"
                           name="images[]"
                           multiple
                           class="w-full border rounded-lg px-3 py-2" required>
                </div>

                <!-- Conditions -->
                <div>
                    <label class="block mb-1">
                        Conditions
                    </label>

                    <textarea name="condition"
                              rows="4"
                              class="w-full border rounded-lg px-3 py-2"></textarea>
                </div>

                <!-- Services -->
                <h2 class="text-2xl font-bold mb-6 text-center">
                    Services
                </h2>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="services[]" value="wifi">
                        WiFi
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="services[]" value="parking">
                        Parking
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="services[]" value="tv">
                        TV
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="services[]" value="piscine">
                        Piscine
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="services[]" value="restaurant">
                        Restaurant
                    </label>

                </div>

                <button type="button"
                        onclick="nextStep1()"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">
                    Suivant
                </button>

            </div>

        </div>

        <!-- ================= ETAPE 2 ================= -->
        <div id="etape2"
             class="hidden bg-white p-8 rounded-2xl shadow-lg">

            <h2 class="text-2xl font-bold mb-6 text-center">
                Adresse Hébergement
            </h2>

            <div class="space-y-4">

                <!-- Wilaya -->
                <div>
                    <label class="block mb-1">
                        Wilaya
                    </label>

                    <select id="wilaya"
                            name="wilaya"
                            class="w-full border rounded-lg px-3 py-2">

                        <option value="">-- Choisir Wilaya --</option>

                    </select>
                </div>

                <!-- Commune -->
                <div>
                    <label class="block mb-1">
                        Commune
                    </label>

                    <select id="commune"
                            name="commune"
                            class="w-full border rounded-lg px-3 py-2">

                        <option value="">-- Choisir Commune --</option>

                    </select>
                </div>

                <!-- Coordonnées -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block mb-1">
                            Latitude
                        </label>

                        <input type="text"
                               name="Latitude"
                               class="w-full border rounded-lg px-3 py-2"
                               required>
                    </div>

                    <div>
                        <label class="block mb-1">
                            Longitude
                        </label>

                        <input type="text"
                               name="Longitude"
                               class="w-full border rounded-lg px-3 py-2"
                               required>
                    </div>

                </div>

                <div class="flex gap-4">

                    <button type="button"
                            onclick="prevStep1()"
                            class="w-full bg-red-500 text-white py-3 rounded-lg">
                        Précédent
                    </button>

                    <button type="button"
                            onclick="nextStep2()"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg">
                        Suivant
                    </button>

                </div>

            </div>

        </div>

        <!-- ================= ETAPE 3 ================= -->
        <div id="etape3"
             class="hidden bg-white p-8 rounded-2xl shadow-lg">

            <h2 class="text-2xl font-bold mb-6 text-center">
                Paiement & Annulation
            </h2>

            <!-- Paiement -->
            <div class="mb-4">
                <label class="block mb-1">
                    Méthode de paiement
                </label>

                <select name="payment"
                        id="payment"
                        class="w-full border rounded-lg px-3 py-2">

                    <option value="pending">
                        Paiement à l'arrivée
                    </option>

                    <option value="online">
                        Paiement en ligne
                    </option>

                    <option value="choisir">
                        Choisir la méthode de paiement
                    </option>

                </select>
            </div>

            <!-- Taxe -->
            <div class="mb-4">
                <label class="block mb-1">
                    Taxe de séjour
                </label>

                <input type="number"
                       name="taxe"
                       class="w-full border rounded-lg px-3 py-2"
                       min="0"
                       placeholder="Montant par personne et par nuit" required>
            </div>

            <!-- Annulation -->
            <div>

                <label class="block mb-3 font-semibold text-lg">
                    Règlement d’annulation
                </label>

                <!-- Type -->
                <div class="mb-4">
                    <label class="block mb-1">
                        Type d’annulation
                    </label>

                    <select name="type_annulation"
                            id="type_annulation"
                            class="w-full border rounded-lg px-3 py-2">

                        <option value="gratuite">
                            Annulation gratuite
                        </option>

                        <option value="flexible">
                            Annulation flexible
                        </option>

                        <option value="strict">
                            Annulation stricte
                        </option>

                    </select>
                </div>

                <!-- Nombre jours -->
                <div id="jours_wrapper" class="mb-4 hidden">
                    <label class="block mb-1">
                        Nombre de jours avant arrivée
                    </label>

                    <input type="number"
                           name="nb_jours_annulation"
                           class="w-full border rounded-lg px-3 py-2"
                           min="0"
                           placeholder="Ex : 7">
                </div>

                <!-- Pourcentage -->
                <div id="pourcentage_wrapper_annulation" class="mb-4 hidden">
                    <label class="block mb-1">
                        Pourcentage remboursement
                    </label>

                    <input type="number"
                           name="pourcentage_remboursement"
                           class="w-full border rounded-lg px-3 py-2"
                           min="0"
                           max="100"
                           placeholder="Ex : 50">
                </div>

            </div>

            <!-- Code promo -->
            <div class="mt-6">

                <label class="block mb-1">
                    Code promo
                </label>

                <input type="text"
                       name="code_Promo"
                       id="code_Promo"
                       class="w-full border rounded-lg px-3 py-2">

            </div>

            <!-- Pourcentage code promo -->
            <div id="promo_wrapper" class="hidden mt-4">

                <label class="block mb-1">
                    Pourcentage code promo
                </label>

                <input type="number"
                       name="Pourcentage_code_Promo"
                       id="Pourcentage_code_Promo"
                       class="w-full border rounded-lg px-3 py-2"
                       min="0"
                       max="100">

            </div>

            <input type="hidden" name="id_hote" value="{{ $id_hote }}">

            <div class="flex gap-4 mt-6">

                <button type="button"
                        onclick="prevStep2()"
                        class="w-full bg-red-500 text-white py-3 rounded-lg">
                    Précédent
                </button>

                <button type="submit"
                        class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700">
                    Ajouter Hébergement
                </button>

            </div>

        </div>

    </form>

</div>

<!-- ================= SCRIPT ================= -->
<script>

    // ================= STEP =================

    function nextStep1() {

        document.getElementById('etape1').classList.add('hidden');
        document.getElementById('etape2').classList.remove('hidden');

        document.getElementById('circle2').classList.remove('bg-gray-200','text-gray-500');
        document.getElementById('circle2').classList.add('bg-blue-500','text-white');

        document.getElementById('line1').style.width = '100%';
    }

    function prevStep1() {

        document.getElementById('etape2').classList.add('hidden');
        document.getElementById('etape1').classList.remove('hidden');

        document.getElementById('circle2').classList.add('bg-gray-200','text-gray-500');
        document.getElementById('circle2').classList.remove('bg-blue-500','text-white');

        document.getElementById('line1').style.width = '0%';
    }

    function nextStep2() {

        document.getElementById('etape2').classList.add('hidden');
        document.getElementById('etape3').classList.remove('hidden');

        document.getElementById('circle3').classList.remove('bg-gray-200','text-gray-500');
        document.getElementById('circle3').classList.add('bg-blue-500','text-white');

        document.getElementById('line2').style.width = '100%';
    }

    function prevStep2() {

        document.getElementById('etape3').classList.add('hidden');
        document.getElementById('etape2').classList.remove('hidden');

        document.getElementById('circle3').classList.add('bg-gray-200','text-gray-500');
        document.getElementById('circle3').classList.remove('bg-blue-500','text-white');

        document.getElementById('line2').style.width = '0%';
    }

    // ================= ANNULATION =================

    const payment = document.getElementById('payment');
    const typeAnnulation = document.getElementById('type_annulation');

    const joursWrapper = document.getElementById('jours_wrapper');
    const pourcentageWrapperAnnulation = document.getElementById('pourcentage_wrapper_annulation');

    function verifierPaiement() {

        typeAnnulation.innerHTML = `
            <option value="gratuite">
                Annulation gratuite
            </option>

            <option value="flexible">
                Annulation flexible
            </option>

            <option value="strict">
                Annulation stricte
            </option>
        `;

        if (payment.value === 'pending') {

            typeAnnulation.innerHTML = `
                <option value="gratuite">
                    Annulation gratuite
                </option>
            `;
        }

        verifierAnnulation();
    }

    function verifierAnnulation() {

        const value = typeAnnulation.value;

        if (value === 'strict') {

            joursWrapper.classList.remove('hidden');
            pourcentageWrapperAnnulation.classList.remove('hidden');

        }

        else if (value === 'flexible') {

            joursWrapper.classList.remove('hidden');
            pourcentageWrapperAnnulation.classList.add('hidden');

        }

        else {

            joursWrapper.classList.add('hidden');
            pourcentageWrapperAnnulation.classList.add('hidden');
        }
    }

    payment.addEventListener('change', verifierPaiement);
    typeAnnulation.addEventListener('change', verifierAnnulation);

    verifierPaiement();

    // ================= CODE PROMO =================

    const codePromo = document.getElementById("code_Promo");
    const promoWrapper = document.getElementById("promo_wrapper");
    const promoPourcentage = document.getElementById("Pourcentage_code_Promo");

    codePromo.addEventListener('input', function () {

        if (codePromo.value.trim() !== '') {

            promoWrapper.classList.remove('hidden');

        } else {

            promoWrapper.classList.add('hidden');
            promoPourcentage.value = '';
        }
    });

    // ================= WILAYA / COMMUNE =================

    let wilayas = [];
    let communes = [];

    Promise.all([
        fetch('/wilayas_commune/Wilaya_Of_Algeria.json').then(res => res.json()),
        fetch('/wilayas_commune/Commune_Of_Algeria.json').then(res => res.json())
    ])

    .then(([wilayaData, communeData]) => {

        wilayas = wilayaData;
        communes = communeData;

        const wilayaSelect = document.getElementById('wilaya');
        const communeSelect = document.getElementById('commune');

        wilayas.forEach(w => {

            let option = document.createElement('option');

            option.value = w.name;
            option.textContent = w.name;

            wilayaSelect.appendChild(option);
        });

        wilayaSelect.addEventListener('change', function () {

            communeSelect.innerHTML =
                '<option value="">-- Choisir Commune --</option>';

            const selectedWilaya = wilayas.find(
                w => w.name === this.value
            );

            if (!selectedWilaya) return;

            const filtered = communes.filter(
                c => c.wilaya_id == selectedWilaya.id
            );

            filtered.forEach(c => {

                let option = document.createElement('option');

                option.value = c.name;
                option.textContent = c.name;

                communeSelect.appendChild(option);
            });

        });

    });

</script>

</x-app-layout>