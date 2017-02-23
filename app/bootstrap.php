<?php

require __DIR__ . '/../vendor/autoload.php';
session_start();
// Instantiate the app
$config = require __DIR__ . '/config.php';
$app = new \Slim\App($config);
// Set up dependencies
require __DIR__ . '/dependencies.php';
// Register routes
require __DIR__ . '/routes.php';

return $app;