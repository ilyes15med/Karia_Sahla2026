<x-app-layout>

<div class=" mt-4 text-gray-700 bg-slate-100 rounded-xl p-4">

  

    <form action="{{ route('update.rating',[$heb->id,$evaluation->id]) }}" method="post" class="mt-3">
        @csrf
        @method('put')

      
       

        <!-- Rating -->
        <div class="flex flex-row-reverse justify-end gap-1 text-2xl">

        @for($i = 5; $i >= 1; $i--)
        <input type="radio" name="nombre_starts" id="star{{ $i }}" value="{{$i}}" class="hidden peer" required>

        <label for="star{{ $i }}"
               class="cursor-pointer text-gray-300 peer-checked:text-yellow-500 hover:text-yellow-400">
            ★
        </label>
        @endfor

        </div>
        

        <!-- Commentaire -->
        <textarea name="commentaire"
                  class="w-full mt-3 p-2 border rounded-lg"
                  placeholder="Votre avis..."
                  required>{{$evaluation->commentaire}}</textarea>

        <button class="mt-3 bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Envoyer
        </button>
    </form>

</div>

</x-app-layout>