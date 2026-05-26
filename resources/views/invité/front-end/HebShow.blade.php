<x-app-layout>
    
    @include('partials.hébergement.showHeb',['heb'=>$heb,'chambres'=>$chambres,'reservations'=>$reservations,'evaluations'=>$evaluations,'EvalTotale'=>$EvalTotale,'pollitique_Annulation'=>$pollitique_Annulation])

</x-app-layout>

