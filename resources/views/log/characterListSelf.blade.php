
@extends('generic.header')


@section('contend')

<h1 class="text-center title-page">Vos personnages</h1>

@php
$charactersLength = sizeof($characters);
$charactersEmptySlot = max(3 - $charactersLength, 0);
@endphp

@foreach($characters as $character)

    <div class="block-character">
        <div class="d-flex">
            <div class="flex-grow-1">
                <p>{{ $character->pseudo }}</p>
                <p>{{ $character->characterSpecie->name }} - lvl {{ $character->level }}</p>
            </div>
            <div class="character-selection-illu-container">
                <img src="{{ asset("img/class/{$character->characterSpecie->id}.png", ) }}">
            </div>
        </div>
        <div class="button-container">
            <input type="button" class="btn btn-create" value="placeholder" data-href="{{ route('log.character.listSelf') }}">
            <input type="button" class="btn btn-supr href-confirm" value="suprimer" data-href="{{ route("log.character.delete", ['id' => $character->id]) }}">
        </div>
    </div>

@endforeach
@for($i = 0; $i < $charactersEmptySlot; $i++)

    <div class="block-character">
        <p>[emplacement-vide] - lvl 1</p>
        <input type="button" class="btn btn-create" value="créer un personnage" data-href="{{ route('log.character.create') }}">
    </div>

@endfor

@endsection
