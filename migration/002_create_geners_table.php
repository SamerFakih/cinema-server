<?php
require('../connection/connection.php');

$query = "CREATE TABLE geners ( id INT AUTO_INCREMENT PRIMARY KEY,
                                name VARCHAR(100) NOT NULL UNIQUE)";

$execute = $conn->prepare($query);
$execute->execute();
