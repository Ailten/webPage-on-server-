
@extends('generic.header')


@section('contend')

@php
$charactersLength = sizeof($characters);
$charactersEmptySlot = max(3 - $charactersLength, 0);
@endphp

@foreach($character as $characters)

    <div>
        <p>{{ $character->pseudo }} - lvl {{ $character->level }}</p>
        <!--
        <p>{{ $character->is_active }}</p>
        <p>{{ $character->xp }}</p>
        -->
    </div>

@endforeach
@if($charactersEmptySlot != 0)
    @foreach($i as range(0, $charactersEmptySlot))

        <div>
            <p>no-name - lvl 1</p>
            <input type="button" value="créer un personnage">
        </div>

    @endforeach
@endif

@endsection
