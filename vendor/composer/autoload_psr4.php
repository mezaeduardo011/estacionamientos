<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Psr\\Log\\' => array($vendorDir . '/psr/log/Psr/Log'),
    'Psr\\Http\\Message\\' => array($vendorDir . '/psr/http-message/src'),
    'PHPMailer\\PHPMailer\\' => array($vendorDir . '/phpmailer/phpmailer/src'),
    'Monolog\\' => array($vendorDir . '/monolog/monolog/src/Monolog'),
    'League\\Plates\\' => array($vendorDir . '/league/plates/src'),
    'League\\OAuth2\\Client\\' => array($vendorDir . '/league/oauth2-client/src', $vendorDir . '/league/oauth2-google/src'),
    'JPH\\' => array($baseDir . '/lib'),
    'GuzzleHttp\\Psr7\\' => array($vendorDir . '/guzzlehttp/psr7/src'),
    'GuzzleHttp\\Promise\\' => array($vendorDir . '/guzzlehttp/promises/src'),
    'GuzzleHttp\\' => array($vendorDir . '/guzzlehttp/guzzle/src'),
    'APP\\' => array($baseDir . '/src'),
);
