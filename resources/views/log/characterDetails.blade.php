
@extends('generic.header')


@section('contend')

<h1 class="text-center title-page">{{  $character->pseudo  }}</h1>

@php
$xpNeedForLvlUp = $character->xpNeedPerLevel?->xp_need ?? -1;
$percentXp = ($character->xp / $xpNeedForLvlUp) *100;
@endphp

<div>
    <p>lvl: {{ $character->level }}</p>
    <div class="progress-bar" title="{{ $character->xp }}/{{ $xpNeedForLvlUp }}">
        <div style="width: {{ $percentXp }}%;"></div>
    </div>
</div>

<div>
    <div>
        <img src="{{ asset("img/class/{$character->characterSpecie->id}.png") }}">
    </div>
    <div>
        @foreach ($inventoriesEquiped as $inventory)

            <div>

                @if(!is_string($inventory))
                    <img src="{{ asset("img/item/{$inventory->itemRef->item_category_id}.png") }}">
                @else
                    <p>{{  $inventory  }}</p>
                @endif

            </div>
        
        @endforeach
    </div>
</div>

<div>
    <!-- list/tableau stats -->
</div>

@endsection