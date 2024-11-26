<?php

# Load dotenv library;
require 'dotenv-php/vendor/autoload.php';

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

require 'clsMoodle.php';