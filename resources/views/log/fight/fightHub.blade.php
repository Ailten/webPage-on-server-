@extends('log.fight.layoutLink')


<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Ailten-WebPage</title>
	    <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>
            const ACTION_OPTION = {
                'twitchOption': "{{ route('log.fight.twitchOption') }}"
            };
        </script>

    </head>

    <body class="fight-page">

        <div class="menu">

            <header>
                <input type="button" class="btn btn-create" value="< menu" id="btn-unfold-menu">
                <input type="button" class="btn btn-create" value="twitch" id="btn-fight-twitch-option">
            </header>

            <div id="menu-contend">

            </div>

        </div>

    </body>
</html>
