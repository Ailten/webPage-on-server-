
@extends('generic.header')


@section('contend')

<h1 class="text-center title-page">Créez votre personnage !</h1>

<form method="POST" action="{{ route('log.character.createValidate') }}">
    @csrf

    <div class="input-line d-flex justify-content-center">
        <label for="pseudo" class="p-align-btn">pseudo :</label>
        <div class="input-error-container">
            <input type="text" name="pseudo" id="pseudo">
            @error('pseudo')
                <p class="input-error">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="input-line d-flex justify-content-center">
        <div class="single-line-input">
            <label for="character_specie_id" class="p-align-btn">class :</label>
            @error('character_specie_id')
                <p class="input-error p-align-btn">{{ $message }}</p>
            @enderror
            <div class="character-specie-selection-container">
                @foreach(DB::table('character_species')->get() as $characterSpecie)
                    <div class="character-specie-selection radio-container">
                        <input type="radio" name="character_specie_id" value="{{ $characterSpecie->id }}" class="hidde">
                        <img src="{{ asset("img/class/$characterSpecie->id.png") }}">
                        <p>{{ $characterSpecie->name }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="input-line submit-line d-flex justify-content-center">
        <input type="button" value="Annuler" data-href="{{ route('log.character.listSelf') }}" class="btn btn-create">
        <input type="submit" value="Créer le personnage" class="btn btn-create">
    </div>

</form>

@endsection