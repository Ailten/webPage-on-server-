@extends('log.fight.layoutLink')


<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Ailten-WebPage</title>
	    <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>

    <body class="fight-page">

        <div class="menu">

            <header>
                <input type="button" class="btn btn-unfold-menu btn-create" value="< menu">
                <input type="button" class="btn" >
            </header>

            <div class="menu-contend">

            </div>

        </div>

    </body>
</html>
