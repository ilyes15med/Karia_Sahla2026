<x-app-layout>

<div class="flex min-h-screen">
        
        <!-- Sidebar -->
       
            @include('admin.aside.aside')
      
        <!-- Content -->
<main class="flex-1 p-6 bg-gray-50"> 
<form method="POST" action="{{ route('register.Agent') }}">
    @csrf

    <!-- Name --> 
    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>
    <select name="role" id="role" class="border p-2 rounded mt-2 w-full" required>
        <option value="">-- Sélectionner --</option>
        
        @if(Auth::check() && Auth::user()->role=='admin')
         
        <option value="agent">agent</option>
             
        @endif
    </select>

         <!-- Email Address -->
    <div class="mt-4">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-input-label for="password" :value="__('Password')" />

        <x-text-input id="password" class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required autocomplete="new-password"/>

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->

    <div class="mt-4">
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                        type="password"
                        name="password_confirmation" required autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">
        
        <x-primary-button class="ms-4">
            {{ __('Register') }}
        </x-primary-button>
    </div>
</form>
</main>

</x-app-layout>
    