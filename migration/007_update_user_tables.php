<?php
require("../connection/connection.php");




    $query = "ALTER TABLE users MODIFY COLUMN government_id_image VARCHAR(255)";

$execute = $conn->prepare($query);
$execute->execute();

