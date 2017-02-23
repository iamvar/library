<?php
$config = [
    'displayErrorDetails' => true, // set to false in production
    'addContentLengthHeader' => false, // Allow the web server to send the content-length header
    // Monolog settings
    'logger' => [
        'name' => 'library-app',
        'path' => __DIR__ . '/../logs/app.log',
        'level' => \Monolog\Logger::DEBUG,
    ],
];

$localConfig = require __DIR__ . '/config.local.php';

return [
    'settings' => array_merge($config, $localConfig)
];