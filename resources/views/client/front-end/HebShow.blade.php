<x-app-layout>
    @include('partials.hébergement.showHeb',['heb'=>$heb,'chambres'=>$chambres,'reservations'=>$reservations,'client_id'=>$client_id])
</x-app-layout>