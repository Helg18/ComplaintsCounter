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

/*
email parrapariciobusiness@gmail.com
$clientId = 'AWgW8GwlJtftFOaE0NXHlaVrh135VB4z4alFHkjD0wHAZh7Pm6XWp_AudLVb9hbyOypF_icXY2gu5cV3';
			 
$clientSecret = 'EJr0UZrU0k-l69TAOP7G1RQX8hoBWMldd_E7X7L3djO927O7Vv_HaS2Fqd4p7kd6bSyP0cOiVYkm4AXg';
*/


//$clientId = 'Adi-HpErigSXR0SAeUkIQGasvnJPb-zSTtnqXufnXi42tPOCSBpo6AfwPWnUCDPStOPYZNavP1rTMHTV';
//$clientSecret = 'EHEgXbno96IU5PjM3IPdC8ikF0dpNcswvWlZLf6Y1R40ZuztB3je6mAG0chRFLkmLVIC-Ove4MTMKcGI';
		/*works
        $clientId =  'AYSq3RDGsmBLJE-otTkBtM-jBRd1TCQwFf9RGfwddNXWz0uFU9ztymylOhRS',
        $clientSecret = 'EGnHDxD_qRPdaLdZz8iCr8N7_MzF-YHPTkjs6NKYQvQSBngp4PTTVWkPZRbL'
         * 
         */
		