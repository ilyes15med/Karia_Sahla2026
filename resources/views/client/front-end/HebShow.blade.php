<x-app-layout>
    @include('partials.hébergement.showHeb',['heb'=>$heb,'chambres'=>$chambres,'reservations'=>$reservations,'client'=>$client,'evaluations'=>$evaluations])
</x-app-layout>