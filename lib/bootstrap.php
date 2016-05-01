<?php


// 1. Autoload the SDK Package. This will include all the files and classes to your autoloader
$path =  dirname(__DIR__)  . "/lib/PayPal-PHP-SDK/autoload.php";

require_once($path);

// 2. Provide your Secret Key. Replace the given one with your app clientId, and Secret
// https://developer.paypal.com/webapps/developer/applications/myapps
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AS2q0IXMvGOxQILMfJn2PBFJhfp5X6PMEO421TqtQ_W4ruEcgvhGYGzqbCQr_0a7To9Yl-lHKVbMyXAU',
        'EGY6akJJ_tw-qQz1991mDWsNL-P7AWM70XIIZEEg0qoyDHo1B5k9N_ZiQcZx-fMGUN2UFysdFSit66kR'
    )
);

		