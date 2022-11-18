<?php

$server = 'localhost:3307';
$username = 'DEMO'
$password = 'password';
$database = 'PC2';

try {
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
  die('Connection Failed: ' . $e->getMessage());
}

?>
