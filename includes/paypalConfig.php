<?php
require_once("Paypal-PHP-SDK/autoload.php");

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'YOUR_PAYPAL_CLIENT_ID',
        'YOUR_PAYPAL_CLIENT_SECRET'
    )
);
?>