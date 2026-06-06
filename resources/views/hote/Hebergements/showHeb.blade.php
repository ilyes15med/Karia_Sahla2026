<x-app-layout>
    @php
    $icons = [
        'wifi'             => 'fa-wifi',
        'parking_gratuit'  => 'fa-square-parking',
        'parking_payant'   => 'fa-square-parking',
        'climatisation'    => 'fa-snowflake',
        'chauffage'        => 'fa-fire',
        'cuisiniere'       => 'fa-kitchen-set',
        'tv'               => 'fa-tv',
        'salle_bain'       => 'fa-bath',
        'douche'           => 'fa-shower',
        'restaurant'       => 'fa-utensils',
        'piscine'          => 'fa-person-swimming',
        'salle_sport'      => 'fa-dumbbell',
        'petit_dejeuner'   => 'fa-mug-hot',
        'blanchisserie'    => 'fa-shirt',
        'securite'         => 'fa-shield-halved',
        'ascenseur'        => 'fa-elevator',
        'animaux'          => 'fa-paw',
        'plage'            => 'fa-umbrella-beach',
        'event'            => 'fa-calendar-days',
    ];
    @endphp

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        @include('hote.aside.aside')

        <!-- Content -->
        <main class="flex-1 p-6 bg-gray-50">

            @if(session('succes'))
            <div id="message" class="bg-green-100 text-green-700 p-3 rounded-lg shadow-sm mb-4">
                <span>{{ session('succes') }}</span>
                <button onclick="document.getElementById('message').remove()"
                    class="pl-1 text-green-700 font-bold hover:text-red-500">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
            @endif

            <div class="mt-12 max-w-6xl mx-auto p-5">

                <!-- Nom hébergement -->
                <div class="mb-4">
                    <h1 class="text-2xl font-semibold text-gray-800">
                        {{ $heb->nomHeberg }}
                    </h1>
                    <div class="flex items-center gap-2 text-gray-600 mt-1">
                        <i class="fa-solid fa-star text-yellow-500"></i>
                        @if($EvalTotale == null || $EvalTotale == 0)
                            <span>0</span>
                        @else
                            <span>{{ (int) $EvalTotale }}</span>
                        @endif
                        <span class="text-gray-400">•</span>
                        <span>{{ $heb->addresse }}</span>
                    </div>
                </div>

                <!-- Information hôte -->
                <div class="bg-slate-100 mb-4 p-4 rounded-xl">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <span class="text-gray-700">
                            Hébergé par <span class="font-semibold">{{ $heb->hote_name }}</span>
                        </span>
                        @if(auth()->user()->role == 'client')
                            <a href="#" class="flex items-center gap-2 text-blue-600 hover:text-blue-800">
                                <i class="fa-solid fa-message"></i>
                                Chat
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Tableau des chambres -->
                <div class="max-w-4xl mx-auto mt-6">
                    <div class="overflow-x-auto bg-white shadow rounded-xl">
                        <table class="min-w-full text-sm text-left">

                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-3"></th>
                                    <th class="px-4 py-3">Quantité disponible</th>
                                    <th class="px-4 py-3">Prix (DA)</th>
                                    <th class="px-4 py-3 text-center">Annulation</th>
                                    @if($heb->typeHeberg == 'Auberge' || $heb->typeHeberg == 'Hotel')
                                        <th class="px-4 py-3 text-center">Actions</th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody class="divide-y">

                                @foreach ($chambres as $chambre)

                                <tr class="hover:bg-gray-50">

                                    {{-- Colonne chambre --}}
                                    <td class="px-4 py-3">

                                        @if($heb->typeHeberg == 'Hotel' || $heb->typeHeberg == 'Auberge')

                                            @php
                                                $images = json_decode($chambre->images_chambres, true);
                                            @endphp

                                            <div class="flex items-center gap-3">

                                                @if(!empty($images))
                                                    <img
                                                        src="{{ asset('storage/' . $images[0]) }}"
                                                        alt="chambre"
                                                        class="w-12 h-12 object-cover rounded-lg shadow"
                                                    >
                                                @endif

                                                <div>
                                                    <span class="text-red-600 font-semibold">
                                                        {{ $chambre->typeChambres }}
                                                    </span>
                                                    <br>
                                                    <button
                                                        type="button"
                                                        onclick="openChambreModal({{ $chambre->id }})"
                                                        class="text-gray-700 hover:text-blue-600 text-sm"
                                                    >
                                                        plus détails
                                                    </button>
                                                </div>

                                            </div>

                                            {{-- Modal détails chambre --}}
                                            <div
                                                id="chambreShow{{ $chambre->id }}"
                                                class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                                            >
                                                <div class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-3xl relative max-h-[90vh] overflow-y-auto">

                                                    <button
                                                        type="button"
                                                        onclick="closeChambreModal({{ $chambre->id }})"
                                                        class="absolute top-3 right-3 text-2xl text-gray-500 hover:text-red-600"
                                                    >
                                                        ✖
                                                    </button>

                                                    <h2 class="text-xl font-bold mb-4">Détails de la chambre</h2>

                                                    <div class="space-y-2 text-gray-700">
                                                        <p><strong>Type :</strong> {{ $chambre->typeChambres }}</p>
                                                        <p><strong>Nombre de lits :</strong> {{ $chambre->nombre_lit }}</p>
                                                        <p><strong>Nombre de chambres :</strong> {{ $chambre->nombre_chambre }}</p>
                                                        <p><strong>Prix :</strong> {{ $chambre->prix }} DA</p>
                                                        @if($chambre->Description)
                                                            <p><strong>Description :</strong> {{ $chambre->Description }}</p>
                                                        @endif
                                                    </div>

                                                    <div class="flex flex-wrap gap-3 mt-5">
                                                        @if(!empty($images))
                                                            @foreach ($images as $image)
                                                                <img
                                                                    src="{{ asset('storage/' . $image) }}"
                                                                    onclick="showImage(this.src)"
                                                                    class="w-32 h-24 object-cover rounded-lg shadow cursor-pointer"
                                                                >
                                                            @endforeach
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>

                                        @else
                                            {{-- Appartement --}}
                                            <span>{{ $chambre->typeChambres }}</span>
                                        @endif

                                    </td>

                                    {{-- Quantité --}}
                                    <td class="px-4 py-3">{{ $chambre->Quantite }}</td>

                                    {{-- Prix --}}
                                    <td class="px-4 py-3">{{ $chambre->prix }}</td>

                                    {{-- Annulation --}}
                                    <td class="px-4 py-3">
                                        @if($pollitique_Annulation->type_anullation == 'gratuit')
                                            <div class="p-1 m-1 bg-green-600 text-white text-center rounded">
                                                annulation est gratuite
                                            </div>
                                        @else
                                            <div class="p-1 m-1 text-white bg-red-600 text-center rounded">
                                                annulation n'est pas gratuite
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    @if($heb->typeHeberg == 'Auberge' || $heb->typeHeberg == 'Hotel')
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-3">
                                            <button
                                                onclick="update({{ $heb->id }}, {{ $chambre->id }})"
                                                class="text-blue-600 hover:text-blue-800"
                                            >
                                                <i class="fa-solid fa-pen"></i>
                                            </button>
                                            <button
                                                onclick="supprimer({{ $heb->id }}, {{ $chambre->id }})"
                                                class="text-red-600 hover:text-red-800"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                    @endif

                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Bouton ajouter chambre -->
                @if($heb->typeHeberg == 'Auberge' || $heb->typeHeberg == 'Hotel')
                <div class="mb-4 mt-4">
                    <button onclick="addchambre()"
                        class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        Ajouter une chambre
                    </button>
                </div>
                @endif

                <div class="mb-4 text-gray-700">
                    <span>{{ $heb->nombre_chambre }} chambre</span>
                </div>

                <!-- Description -->
                <div class="text-gray-700 bg-slate-100 rounded-xl p-4 mb-4">
                    <span class="font-bold">A propos de ce logement</span>
                    <br>
                    <span class="p-4">{{ $heb->Description }}</span>
                </div>

                <!-- Politique hébergement -->
                <div class="mb-4 text-gray-700 bg-slate-100 rounded-xl p-4">
                    <span class="font-bold">Politique de l'hébergement</span>
                    <br>
                    <span class="p-4">{{ $heb->politiqueHeb }}</span>
                </div>

                <!-- Politique annulation -->
                <div class="mb-4 text-gray-700 bg-red-200 rounded-xl p-4">
                    <span class="font-bold">Politique annulation de réservation</span>
                    <br>
                    @if($pollitique_Annulation->type_anullation == 'gratuite')
                        <span class="p-4">
                            Politique {{ $pollitique_Annulation->type_anullation }} : Annulation est gratuit
                        </span>
                    @elseif($pollitique_Annulation->type_anullation == 'flexible')
                        <span class="p-4">
                            Politique {{ $pollitique_Annulation->type_anullation }} :
                            Annulation gratuit jusqu'à {{ $pollitique_Annulation->nombre_jour }} jour,
                            après {{ $pollitique_Annulation->nombre_jour }} jour remboursement partiel de taxe,
                            mais le hôte peut récupérer les nuits
                        </span>
                    @elseif($pollitique_Annulation->type_anullation == 'strict')
                        <span class="p-4">
                            Politique {{ $pollitique_Annulation->type_anullation }} :
                            Annulation n'est pas gratuit, le client récupère {{ $pollitique_Annulation->pourcentage_recuperation }}%
                            avant {{ $pollitique_Annulation->nombre_jour }} jours,
                            mais après {{ $pollitique_Annulation->nombre_jour }} jours impossible récupérer
                        </span>
                    @endif
                </div>

                <!-- Photos -->
                <div class="mt-4 text-gray-700 bg-slate-100 rounded-xl p-4 flex flex-wrap gap-3">
                    @foreach(json_decode($heb->images) as $img)
                        <img
                            src="{{ asset('storage/' . $img) }}"
                            onclick="showImage(this.src)"
                            class="w-64 h-40 object-cover rounded-lg shadow cursor-pointer"
                        >
                    @endforeach
                </div>

                <!-- Équipements -->
                @php
                    $services = json_decode($heb->service, true);
                    if (!is_array($services)) {
                        $services = [];
                    }
                @endphp
                <div class="mt-4 text-gray-700 bg-slate-100 rounded-xl p-4 flex flex-wrap gap-3">
                    <span class="font-bold">Équipements :</span>
                    <div class="space-x-4">
                        @forelse($services as $service)
                            <span class="mr-3">
                                <i class="fa-solid {{ $icons[$service] ?? 'fa-circle' }}"></i>
                                {{ $service }}
                            </span>
                        @empty
                            <span class="mr-3">Aucun service</span>
                        @endforelse
                    </div>
                </div>

                <!-- Map -->
                <div id="map" class="w-full h-96 mt-4 text-gray-700 bg-slate-100 rounded-xl"></div>

                <!-- Avis -->
                <div class="mt-4 text-gray-700 bg-slate-100 rounded-xl p-4">
                    <span class="font-bold text-lg">Avis</span>

                    @if($evaluations->isEmpty())
                        <div>
                            <span class="p-1 text-gray-500">Aucun avis</span>
                        </div>
                    @else
                        @foreach($evaluations as $evaluation)
                        <div class="mt-3 flex items-start gap-3">

                            <img src="{{ asset('/assets/images/photo_profile.jpg') }}"
                                class="w-10 h-10 rounded-full object-cover">

                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold">{{ $evaluation->nomclient }}</span>
                                    <div class="flex text-yellow-500 text-sm">
                                        <i class="fa-solid fa-star"></i> {{ $evaluation->nombre_etoile }}
                                    </div>

                                    @if(Auth()->user()->id == $evaluation->id_client)
                                    <div class="relative inline-block text-left">
                                        <button onclick="toggleMenu(this)"
                                            class="p-2 rounded-full hover:bg-gray-200">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="hidden absolute right-0 mt-2 w-40 bg-white border rounded-xl shadow-lg z-50">
                                            <a href="{{ route('update_rating.show', [$heb->id, $evaluation->Evaluation_id]) }}"
                                                class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center gap-2">
                                                <i class="fa-solid fa-pen text-blue-500"></i>
                                                Modifier
                                            </a>
                                            <a href="{{ route('rating.delete', [$heb->id, $evaluation->Evaluation_id]) }}"
                                                class="w-full text-left px-4 py-2 hover:bg-red-100 flex items-center gap-2 text-red-600">
                                                <i class="fa-solid fa-trash"></i>
                                                Supprimer
                                            </a>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                                <p class="text-gray-600 text-sm mt-1">{{ $evaluation->commentaire }}</p>
                            </div>

                        </div>
                        @endforeach
                    @endif
                </div>

            </div><!-- fin max-w-6xl -->

        </main>
    </div>

    <!-- ===== MODALS ===== -->

    <!-- Image popup -->
    <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50"
         onclick="this.classList.add('hidden')">
        <img id="modalImage" class="max-w-3xl rounded-lg">
    </div>

    <!-- Modal confirmation -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-2xl shadow-lg w-80 text-center">
            <p class="mb-6">Êtes-vous sûr de vouloir continuer ?</p>
            <div class="flex justify-center gap-4">
                <button onclick="closeModal()" class="bg-gray-300 px-4 py-2 rounded">
                    Annuler
                </button>
                <a id="confirmBtn" href="#" class="bg-green-500 text-white px-4 py-2 rounded">
                    Confirmer
                </a>
            </div>
        </div>
    </div>

    <!-- Modal ajouter chambre -->
    <div id="addchambreform" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <form action="{{ route('chambre.added', $heb->id) }}" method="post"
              class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-3xl max-h-[90vh] overflow-y-auto relative"
              enctype="multipart/form-data">
            @csrf

            <button type="button"
                    onclick="document.getElementById('addchambreform').classList.add('hidden')"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl font-bold">
                ✖
            </button>

            <div class="flex justify-center mb-6">
                <img src="{{ asset('/assets/images/logo.png') }}" class="w-40 h-40 object-contain">
            </div>

            <p class="text-xl mb-6 text-center font-semibold">Ajouter une chambre</p>

            <div class="space-y-4">

                <!-- Type de chambre -->
                <div>
                    <label class="block mb-1">Type de chambre</label>
                    <select id="typeSelect" name="type_chambre" class="w-full border rounded-lg px-3 py-2" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="Simple">Simple</option>
                        <option value="Double">Double</option>
                        <option value="Triple">Triple</option>
                        <option value="Suite">Suite</option>
                        <option value="familiale">Familiale</option>
                        <option value="Delux">Delux</option>
                        <option value="studio">Studio</option>
                        <option value="autre">Autre...</option>
                    </select>
                    <input type="text" id="autreType" name="type_custom"
                           placeholder="Entrer un nouveau type"
                           class="border rounded-lg px-3 py-2 mt-2 w-full hidden">
                </div>

                <!-- Prix -->
                <div>
                    <label class="block mb-1">Prix par nuit</label>
                    <input type="number" name="prix" class="w-full border rounded-lg px-3 py-2"
                           min="0" placeholder="Prix en DZD" required />
                </div>

                <!-- Nombre de chambres -->
                <div>
                    <label class="block mb-1">Nombre des chambres</label>
                    <input type="text" name="nombre_chambre" class="w-full border rounded-lg px-3 py-2"
                           placeholder="Nombre total de chambres" required />
                </div>

                <!-- Nombre de lits -->
                <div>
                    <label class="block mb-1">Nombre de lits</label>
                    <input type="number" name="nombre_lit" class="w-full border rounded-lg px-3 py-2"
                           placeholder="Nombre de lits par chambre" min="1" required />
                </div>

               
                <!-- Description -->
                <div>
                    <label class="block mb-1">Description</label>
                    <textarea name="description" class="w-full border rounded-lg px-3 py-2" rows="3"></textarea>
                </div>

                <!-- Images -->
                <div>
                    <label class="block mb-1">Images</label>
                    <input type="file" name="images[]" multiple class="w-full" accept="image/*" required />
                </div>

            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                    Ajouter la chambre
                </button>
            </div>

        </form>
    </div>

    <!-- ===== SCRIPTS ===== -->
    <script>
        // Ouvrir/fermer modal chambre
        function openChambreModal(id) {
            document.getElementById('chambreShow' + id).classList.remove('hidden');
        }
        function closeChambreModal(id) {
            document.getElementById('chambreShow' + id).classList.add('hidden');
        }

        // Ouvrir formulaire ajout chambre
        function addchambre() {
            document.getElementById('addchambreform').classList.remove('hidden');
        }

        // Afficher image en plein écran
        function showImage(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        // Modal confirmation (update / supprimer)
        function update(idHeb, idChambre) {
            document.getElementById('confirmModal').classList.remove('hidden');
            let url = '/hote/MonHebergement/' + idHeb + '/chambre/' + idChambre + '/edit';
            document.getElementById('confirmBtn').href = url;
        }
        function supprimer(idHeb, idChambre) {
            document.getElementById('confirmModal').classList.remove('hidden');
            let url = '/hote/MonHebergement/' + idHeb + '/chambre/' + idChambre + '/delete';
            document.getElementById('confirmBtn').href = url;
        }
        function closeModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }

        // Menu 3 points (avis)
        function toggleMenu(btn) {
            const menu = btn.nextElementSibling;
            menu.classList.toggle('hidden');
        }

        // Type chambre "Autre"
        const typeSelect = document.getElementById('typeSelect');
        const autreInput = document.getElementById('autreType');
        if (typeSelect) {
            typeSelect.addEventListener('change', function () {
                if (this.value === 'autre') {
                    autreInput.classList.remove('hidden');
                } else {
                    autreInput.classList.add('hidden');
                    autreInput.value = '';
                }
            });
        }

        // Google Maps
        function initMap() {
            const location = { lat: {{ $heb->latitude }}, lng: {{ $heb->longitude }} };
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: location,
                zoomControl: true
            });
            new google.maps.Marker({
                position: location,
                map: map,
            });
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUqMturwFCGYIXu0AY0Fnb9ovtjcr-5KM&callback=initMap"
            async defer></script>

</x-app-layout>