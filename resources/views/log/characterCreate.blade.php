
@extends('generic.header')


@section('contend')

<h1 class="text-center title-page">Créez votre personnage !</h1>

<form method="POST" action="{{ route('log.create.character.validate') }}">
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
        <label for="class" class="p-align-btn">class :</label>
        <div class="input-error-container">
            <select name="class" id="class">
                <option value="0">---</option>
                <option value="1">Mercenaire</option>
                <option value="2">Tank</option>
                <option value="3">Soigneur</option>
            </select>
            @error('class')
                <p class="input-error">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="input-line submit-line d-flex justify-content-center">
        <input type="button" value="Annuler" data-href="{{ url()->previous() }}" class="btn btn-create">
        <input type="submit" value="Créer le personnage" class="btn btn-create">
    </div>

</form>

@endsection