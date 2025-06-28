<?php
require('../connection/connection.php');

$query = "CREATE TABLE users (id INT AUTO_INCREMENT PRIMARY KEY,
                                name VARCHAR(100) NOT NULL ,
                                email VARCHAR(100) NOT NULL UNIQUE,
                                mobile INT NOT NULL UNIQUE,
                                password VARCHAR(255) NOT NULL,
                                dob DATE NOT NULL,
                                government_id_image LONGBLOB NOT NULL,
                                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";

$execute = $conn->prepare($query);
$execute->execute();