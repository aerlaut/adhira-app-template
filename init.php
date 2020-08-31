<?php

require_once 'vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

// Read environment variable
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

// Enable $_SESSION
session_start();

// Get database object
require_once 'php/db.php';

// Import helpers
require_once 'php/helpers.php';
