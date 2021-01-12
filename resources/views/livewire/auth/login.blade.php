<div>
    <div class="absolute -top-8 sm:mx-auto sm:w-full sm:max-w-md pr-16">
        <img class="m-auto w-auto h-16 mx-auto" src="{{ asset('img/logo.svg') }}" alt="App logo">
    </div>
    <h2 class="mt-5 mb-8 text-3xl font-extrabold text-center text-gray-600">
        Se Connecter
    </h2>

    <form wire:submit.prevent="login">
        <div>
            <label for="email" class="block text-sm font-medium leading-5 text-gray-700">
                Adresse Email
            </label>
            <div class="mt-1 rounded-md shadow-sm">
                <input wire:model="email" id="email" type="email" required autofocus
                    class="@error('email') border-red-500 @enderror appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
            </div>
            @error('email') <div class="mt-1 text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        <div class="mt-6">
            <label for="password" class="block text-sm font-medium leading-5 text-gray-700">
                Mot de passe
            </label>
            <div class="mt-1 rounded-md shadow-sm">
                <input wire:model.lazy="password" id="password" type="password" required
                    class="@error('password') border-red-500 @enderror appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
            </div>
            @error('password') <div class="mt-1 text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        <div class="mt-6">
            <span class="block w-full rounded-md shadow-sm">
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-bold rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                    Se connecter
                </button>
            </span>
        </div>
    </form>

    <div class="mt-6">
        <p class="mt-2 text-center text-sm leading-5 text-gray-600 max-w">
            <a href="{{ route('auth.register') }}"
                class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                Pas inscrit?
            </a>
        </p>
    </div>
</div>
