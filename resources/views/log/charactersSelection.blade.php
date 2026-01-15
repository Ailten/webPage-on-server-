
@extends('generic.header')


@section('contend')

<h1 class="text-center title-page">Vos personnages</h1>

@php
$charactersLength = sizeof($characters);
$charactersEmptySlot = max(3 - $charactersLength, 0);
@endphp

@foreach($characters as $character)

    <div class="block-character">
        <p>{{ $character->pseudo }} - lvl {{ $character->level }}</p>
        <!--
        <p>{{ $character->is_active }}</p>
        <p>{{ $character->xp }}</p>
        -->
    </div>

@endforeach
@for($i = 0; $i < $charactersEmptySlot; $i++)

    <div class="block-character">
        <p>[emplacement-vide] - lvl 1</p>
        <input type="button" class="btn btn-create" value="créer un personnage" data-href="{{ route('log.create.character') }}">
    </div>

@endfor

@endsection
