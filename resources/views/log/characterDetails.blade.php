
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

<div class="d-flex mt-4">
    <div>
        <div class="character-details-illu-container">
            <img src="{{ asset("img/class/{$character->characterSpecie->id}.png") }}">
        </div>
        <!-- can add a div heer-->
    </div>
    <div class="item-equiped-container">
        @foreach ($inventoriesEquiped as $inventory)

            <div class="item-container">

                @if(!is_string($inventory))
                    <img src="{{ asset("img/item/{$inventory->itemRef->item_category_id}.png") }}">
                @else
                    <p>{{  $inventory  }}</p>
                @endif

            </div>
        
        @endforeach
    </div>
    <div class="stat-container flex-grow-1">
        
        <table>
            <thead>
                <tr>
                    <th>stat</th>
                    <th>value</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($character->stat->StatTypeValue as $statTypeValue)
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach

            </tbody>
            <tfoot>
                <th></th>
                <td></td>
            </tfoot>
        </table>

    </div>
</div>

@endsection