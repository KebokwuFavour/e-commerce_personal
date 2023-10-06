<?php

// Include the Composer autoloader
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Now you can access the environment variables as needed
$apiSecretKey = $_ENV["API_SECRET_KEY"];
$apiPublicKey = $_ENV["API_PUBLIC_KEY"];
