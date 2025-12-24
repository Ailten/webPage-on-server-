
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Ailten-WebPage</title>
	    <meta charset="utf-8">

	    <!-- js -->
	    <script src="{{ URL::asset('js/main.js') }}"></script>
    
	    <!-- css -->
        <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
	    <link href="{{ URL::asset('css/main.css') }}" rel="stylesheet">
	    <link href="{{ URL::asset('css/responcive.css') }}" rel="stylesheet">

	    <link href="{{ URL::asset('css/blackTheme.css') }}" rel="stylesheet">


    </head>

    <body>

        <header>

            <div class="d-flex justify-content-end">

                <!-- button twitch log. -->
                @if(False)

                    <input ype="button" class="btn btn-twitch" value="disconnect">

                @else

                    @php
                    $twitchAPI = new App\Utils\Twitch\TwitchAPI(env('TWITCH_CLIENT_ID'), env('TWITCH_CLIENT_SECRET'));
                    $twitchLoginUrl = $twitchAPI->getLoginUrl(env('TWITCH_REDIRECT_URL'))
                    @endphp
                    <input type="button" class="btn btn-twitch" value="Ce connecter avec Twitch" href="{{ $twitchLoginUrl }}">

                @endif

                <!-- if session log or not : print button log or disconnect OAuth -->
            </div>

            <menu>
                <ul>
                    @php
                    $links = [
                        [
                            'name' => 'acceuil', 
                            'view' => 'index'
                        ],
                        [
                            'name' => 'placeholder_xx', 
                            'view' => 'index'
                        ]
                    ];
                    @endphp
                    @foreach($links as $link)
                        <li class="btn" href="{{ route($link['view']) }}">{{ $link['name'] }}</li>
                    @endforeach

                    <!--
                    <li href="accueil">acceuil</li>
                    <li>placeholder-one</li>
                    <li>placeholder-two</li>
                    -->
                </ul>
            </menu>

        </header>

        <section class="border-page" id="border-page-left"></section>
        


        @yield('contend')



        <section class="border-page" id="border-page-right"></section>

        <footer>

            <p style="margin: 0;">made by: Ailten</p>

        </footer>

    </body>
</html>