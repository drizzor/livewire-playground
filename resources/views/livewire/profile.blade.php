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
                <x-input.rich-text wire:model.defer="about" id="about" rows="3" />
            </x-input.group>
            
            <x-input.group label="Photo" for="photo" :error="$errors->first('newAvatar')">
                <x-input.file-upload wire:model="newAvatar" id="photo">
                    <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                        @if ($newAvatar)
                            <img src="{{ $newAvatar->temporaryUrl() }}" alt="Profile photo">
                        @else 
                            <img src="{{ auth()->user()->avatarUrl() }}" alt="Profile photo">
                        @endif        
                    </span> 
                </x-input.file-upload>
            </x-input.group>

            <x-input.group label="Multiple Upload" for="photos" :error="$errors->first('newAvatars.*')">
                <x-input.file-upload wire:model="newAvatars" id="photos" multiple>

                    {{-- <x-slot name="showingImages">
                        @foreach ($newAvatars as $avatar)
                            <img src="{{ $avatar->temporaryUrl() }}" alt="image preview" class="w-40 h-40">
                        @endforeach
                    </x-slot> --}}
                </x-input.file-upload>
            </x-input.group>

            <x-input.group label="Drag & Drop" for="filepondUp" :error="$errors->first('newAvatars')">
                <x-input.filepond wire:model="newAvatars" multiple />
            </x-input.group> 
        </div>

        <div class="mt-8 border-t border-gray-200 pt-5">
            <div class="space-x-3 flex justify-end items-center">

                <x-inline-notification />

                <span class="inline-flex rounded-md shadow-sm">
                    <button type="button"
                        class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out"
                        wire:click="resetData"
                    >
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
