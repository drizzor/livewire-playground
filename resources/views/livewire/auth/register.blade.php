<form wire:submit.prevent="register">

    <div>
        <label for="email">Email</label>
        <input wire:model="email" type="text" id="email" name="email">
    </div>

    <div>
        <label for="password">Mot de passe</label>
        <input wire:model="password" type="password" id="password" name="password">
    </div>

    <div>
        <label for="passwordConfirmation">Confrimer mot de passe</label>
        <input wire:model="passwordConfirmation" type="password" id="passwordConfirmation" name="passwordConfirmation">
    </div>

    <div>
        <input type="submit" value="S'enregistrer">
    </div>

</form>