@extends('generic.layoutLink')
@extends('log.fight.layoutLink')


<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Ailten-WebPage</title>
	    <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>
            const ACTION_OPTION = {
                'navigationOption': "",
                'twitchOption': "{{ route('log.fight.twitchOption') }}",
                'characterOption': "",
                'nmobOption': ""
            };
        </script>

    </head>

    <body class="fight-page">

        <div class="menu">

            <header>
                <input type="button" class="btn btn-create" value="< menu" id="btn-unfold-menu">

                <input type="button" class="btn btn-create" value="navigation" id="btn-fight-navigation-option">
                <input type="button" class="btn btn-create" value="twitch" id="btn-fight-twitch-option">
                <input type="button" class="btn btn-create" value="personnages" id="btn-fight-character-option">
                <input type="button" class="btn btn-create" value="monstres" id="btn-fight-mob-option">
            </header>

            <div id="menu-contend">

            </div>

        </div>

    </body>
</html>
