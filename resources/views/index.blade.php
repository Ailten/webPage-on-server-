@extends('generic.header')


@section('contend')

<h1 class="text-center title-index">
    Bienvenue sur {{ env('WEBSITE_NAME') }} !
</h1>

<p>
    connectez vous avec twitch
    @guest
    (avec le bouton en haut a droite)
    @endguest
    @auth
    (vous l'etes déja)
    @endauth
    .
</p>

<p>
    créez votre premier personnage dans le menu "personnages".
</p>

<p>
    rejoignez des combat dans le chat de streamer, gagnez des niveaux et des équipement rare.
</p>

<p>
    amusez vous bien :)
</p>

@endsection
