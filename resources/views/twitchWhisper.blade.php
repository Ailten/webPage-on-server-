@extends('generic.header')


@section('contend')


<h1 class="text-center">Connection par chuchottement Twitch !</h1>

<details>
    <summary>Comment ca marche ?</summary>

    <p>
        Entrez votre pseudo Twitch.
    </p>
    <p>
        Envoyer le formulaire (cette action enverra un message-privé/chucottement) a ce pseudo sur Twitch.
        Ce message contiendra un code d'identification.
    </p>
    <p>
        Entrez le code d'identification que vous avez recu par message-privé.
        Et envoyez le second formulaire.
    </p>
    <p>
        Si tout est bon, vous serez alors connecté :D
    </p>

</details>

<form method="GET" action="{{ route('login.twitchWhisper.validate') }}">
    @csrf

    <div class="input-line">
        <label for="pseudo">pseudo Twitch :</label>
        <input type="text" name="pseudo" id="pseudo" pattern="[a-zA-Z0-9_-]{1,}">
        @error('pseudo')
            <p>{{ $message }}</p>
        @enderror
    </div>

    @if(session()->has('twitch_secret_code_whisper'))
        <div class="input-line">
            <label for="code">pseudo Twitch :</label>
            <input type="text" name="code" id="code" pattern="[0-9]{6}">
            @error('code')
                <p>{{ $message }}</p>
            @enderror
        </div>
    @endif

    <div class="input-line">
        <input type="button" value="Annuler" data-href="{{ url()->previous() }}">
        <input type="submit" value="Envoyer un code">
    </div>

</form>


@endsection