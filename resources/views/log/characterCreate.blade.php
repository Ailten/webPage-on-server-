
@extends('generic.header')


@section('contend')

<h1 class="text-center">Créez votre personnage !</h1>

<form method="POST" action="{{ route('log.create.character.validate') }}">

    <div class="input-line">
        <label for="pseudo">pseudo :</label>
        <input type="text" name="pseudo" id="pseudo">
    </div>

    <div class="input-line">
        <label for="class">class :</label>
        <select name="class" id="class">
            <option value="-1">---</option>
            <option value="0">Tank</option>
            <option value="1">Soigner</option>
            <option value="2">Chevalier</option>
        </select>
    </div>

    <div class="input-line">
        <input type="button" value="Annuler" data-href="{{ url()->previous() }}">
        <input type="submit" value="Créer le personnage">
    </div>

</form>

@endsection