<div>

    <h1 class="text-2xl font-semibold text-gray-900">Profile</h1>

    <form wire:submit.prevent="save">
        <div class="mt-6 sm:mt-5 space-y-6">
            <x-input.group label="Pseudo" for="username" :error="$errors->first('username')">
                <x-input.text wire:model="username" id="username" leading-add-on="hello.com/" />
            </x-input.group>

            <x-input.group label="Date de naissance" for="birthday" :error="$errors->first('birthday')">
                <x-input.date  wire:model="birthday" id="birthday" placeholder="DD/MM/YYYY" /> 
            </x-input.group>

            <x-input.group label="A Propos" for="about" :error="$errors->first('about')" help-text="Quelque chose à ton propos.">
                <x-input.textarea wire:model="about" id="about" rows="3" />
            </x-input.group>
            
            <x-input.group label="Photo" for="photo">
                <div class="flex items-center">
                    <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </span>

                    <span class="ml-5 rounded-md shadow-sm">
                        <button type="button"
                            class="py-2 px-3 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                            Changer
                        </button>
                    </span>
                </div>
            </x-input.group>
        </div>

        <div class="mt-8 border-t border-gray-200 pt-5">
            <div class="space-x-3 flex justify-end items-center">

                <x-inline-notification />

                <span class="inline-flex rounded-md shadow-sm">
                    <button type="button"
                        class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                        Annuler
                    </button>
                </span>

                <span class="inline-flex rounded-md shadow-sm">
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Sauver
                    </button>
                </span>

            </div>
        </div>
    </form>
</div>
