<?php
include('../vendor/autoload.php');

//setup client
$QubeInApiClient = new QubeInClient('PUBLIC','SECRET');

//todo cache connection
$QubeInApiClient->setAccessToken();

dd( $QubeInApiClient->get('datafeeds') );
