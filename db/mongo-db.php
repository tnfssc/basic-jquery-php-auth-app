<?php

require_once __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;

$client = new Client('mongodb://127.0.0.1:27017');
$db = $client->test;
