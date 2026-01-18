@extends('generic.layoutLink')


<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Ailten-WebPage</title>
	    <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>

    <body>

        <header>

            <div class="d-flex justify-content-end">

                @auth

                    <p class="p-align-btn margin-right">{{ auth()->user()->twitch_pseudo }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="btn btn-twitch" value="Ce déconnecter">
                    </form>

                @endauth
                @guest

                    @php
                    $twitchAPI = new App\Utils\Twitch\TwitchAPI(env('TWITCH_CLIENT_ID'), env('TWITCH_CLIENT_SECRET'));
                    $twitchLoginUrl = $twitchAPI->getLoginUrl(env('TWITCH_REDIRECT_URL'))
                    @endphp
                    <input type="button" class="btn btn-twitch" value="Ce connecter avec Twitch" data-href="{{ $twitchLoginUrl }}">
                    <!--
                    <input type="button" class="btn btn-twitch" value="Ce connecter avec Twitch" data-href="{{ route('login.twitchWhisper') }}">
                    -->

                @endguest

            </div>

            <menu>
                <ul>
                    @php
                    $links = array_filter([
                        [
                            'name' => 'acceuil', 
                            'view' => 'index',
                            'isPrint' => true,
                        ],
                        [
                            'name' => 'personnages', 
                            'view' => 'log.character.listSelf',
                            'isPrint' => Auth::check(),
                        ],
                        [
                            'name' => 'inventaire', 
                            'view' => 'log.item.inventory',
                            'isPrint' => Auth::check(),
                        ]
                    ], fn($l) => $l['isPrint']);
                    @endphp
                    @foreach($links as $link)

                        <li class="btn btn-header" 
                            data-href="{{ route($link['view']) }}">
                            {{ $link['name'] }}
                        </li>

                    @endforeach

                </ul>
            </menu>

        </header>

        @if(session('error'))
            <div class="pop-up-error pop-up-container">
                <input type="button" class="btn-x" value="x">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <section class="border-page" id="border-page-left">
            <div class="border-image"></div>
        </section>
        

        <section id="center-page" class="flex-fill">
            @yield('contend')
        </section>


        <section class="border-page" id="border-page-right">
            <div class="border-image"></div>
        </section>

        <footer>

            <p style="margin: 0;">made by: Ailten</p>

        </footer>

    </body>
</html>