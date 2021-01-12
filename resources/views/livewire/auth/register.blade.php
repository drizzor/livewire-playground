<div>
    <div class="absolute -top-8 sm:mx-auto sm:w-full sm:max-w-md pr-16">
        <img class="m-auto w-auto h-16 mx-auto" src="{{ asset('img/logo.svg') }}" alt="App logo">
    </div>
    <h2 class="mt-5 mb-8 text-3xl font-extrabold text-center text-gray-600">
        S'inscrire
    </h2>

    <form wire:submit.prevent="register">
        <div>
            <label for="email" class="block text-sm font-medium leading-5 text-gray-700">
                Adresse Email
            </label>
            <div class="mt-1 rounded-md shadow-sm">
                <input wire:model="email" type="text" id="email"
                    class="block w-full px-3 py-2 placeholder-gray-400 border @error('email') border-red-600 @enderror border-gray-300 rounded-md appearance-none" />
            </div>
            @error('email')
                <div class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mt-6">
            <label for="password" class="block text-sm font-medium leading-5 text-gray-700">
                Mot de passe
            </label>
            <div class="mt-1 rounded-md shadow-sm">
                <input wire:model.lazy="password" type="password" id="password"
                    class="block w-full px-3 py-2 placeholder-gray-400 border @error('password') border-red-600 @enderror border-gray-300 rounded-md appearance-none">
            </div>
            @error('password')
                <div class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mt-6">
            <label for="passwordConfirmation" class="block text-sm font-medium leading-5 text-gray-700">
                Confirmer le mot de passe
            </label>
            <div class="mt-1 rounded-md shadow-sm">
                <input wire:model.lazy="passwordConfirmation" type="password" id="passwordConfirmation"
                    class="block w-full px-3 py-2 placeholder-gray-400 border @error('passwordConfirmation') border-red-600 @enderror border-gray-300 rounded-md appearance-none">
            </div>
            @error('passwordConfirmation')
                <div class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mt-6">
            <span class="block w-full rounded-md shadow-sm">
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-bold rounded-md text-white bg-indigo-600 hover:bg-indigo-5000">
                    S'enregistrer
                </button>
            </span>
        </div>

        <div class="mt-6">
            <p class="mt-2 text-center text-sm text-gray-600">
                <a href="{{ route('auth.login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Déjà inscrit?
                </a>
            </p>
        </div>

    </form>
</div>
