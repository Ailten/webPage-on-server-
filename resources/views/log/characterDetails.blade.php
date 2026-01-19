
@extends('generic.header')


@section('contend')

<h1 class="text-center title-page">{{  $character->pseudo  }}</h1>

@php
$percentXp = ($character->xp / $xpNeedForLvlUp) *100;
@endphp

<div>
    <p>lvl: {{ $character->level }}</p>
    <div class="progress-bar" title="{{ $character->xp }}/100">
        <div style="width: {{ $percentXp }}%;"></div>
    </div>
</div>

<div>
    <div>
        <img src="{{ asset("img/class/{$character->characterSpecie->id}.png", ) }}">
    </div>
    <div>
        <!-- items equiped -->
    </div>
</div>

<div>
    <!-- list/tableau stats -->
</div>

@endsection