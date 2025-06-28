<?php
require("../connection/connection.php");



$query = "ALTER TABLE users ADD COLUMN admin INT DEFAULT 0";


$execute = $conn->prepare($query);
$execute->execute();

