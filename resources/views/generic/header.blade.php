@extends('generic.layoutLink')


<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Ailten-WebPage</title>
	    <meta charset="utf-8">

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
                    <!--
                    <input type="button" class="btn btn-twitch" value="Ce déconnecter" data-href="{{ route('logout') }}">
                    -->
                @endauth
                @guest

                    @php
                    $twitchAPI = new App\Utils\Twitch\TwitchAPI(env('TWITCH_CLIENT_ID'), env('TWITCH_CLIENT_SECRET'));
                    $twitchLoginUrl = $twitchAPI->getLoginUrl(env('TWITCH_REDIRECT_URL'))
                    @endphp
                    <input type="button" class="btn btn-twitch" value="Ce connecter avec Twitch" data-href="{{ $twitchLoginUrl }}">
                    
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
                            'view' => 'log.characters',
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
            <div class="pop-up-error">
                <!--<span class="btn-x">x</span>-->
                <input type="button" class="btn-x" value="x">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <section class="border-page" id="border-page-left"></section>
        

        <section id="center-page" class="flex-fill">
            @yield('contend')
        </section>


        <section class="border-page" id="border-page-right"></section>

        <footer>

            <p style="margin: 0;">made by: Ailten</p>

        </footer>

    </body>
</html>