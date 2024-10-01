<?php
require 'vendor/autoload.php'; // Assuming you use Composer for MongoDB PHP library

$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->selectDatabase('vulnerable_app');

?>
