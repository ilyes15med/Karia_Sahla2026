<div class="mb-6">
    <p class="text-2xl font-bold mb-1">
        {{ $count_heb }} hébergements disponible
    </p>
    <p class="text-gray-600">
        explorer notre sélection hébergement
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($hebs as $heb)
        <a href="/hebergement/{{$heb->id}}" 
           class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition">

            @php
                $image = json_decode($heb->images);
            @endphp      

            <img src="{{ asset('storage/'.$image[0]) }}" 
                 class="w-full h-56 object-cover">

            <div class="p-4 space-y-2">

                <p class="text-lg font-bold">
                    {{ $heb->nomHeberg }}
                </p> 

                <p class="text-sm text-gray-600">
                  
                </p> 

                <p class="text-sm">
                    {{ $heb->typeHeberg }}
                </p> 

                <p class="text-sm font-semibold">
                    {{ $heb->prix }} DZD / nuit
                </p> 

            </div>

        </a>  
    @endforeach           
</div>     
