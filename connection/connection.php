<?php

$host = 'localhost';
$db_name = 'cinemasmart_db';
$user = 'root';
$pass = '';


$conn= new mysqli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require_once(__DIR__ . '/../models/model.php');
Model::setConnection($conn);

