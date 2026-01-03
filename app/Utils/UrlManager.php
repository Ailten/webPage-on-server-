<?php

class UrlManager {

    // cast a string url for replace ip server by localhost.
    public static function castLocalHost($url){
        return str_replace(
            env("IP_SERVER"), 
            "localhost:8000", 
            $url
        );
    }

}