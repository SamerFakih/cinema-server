<?php
require('../connection/connection.php');

$query = "CREATE TABLE movies (id INT AUTO_INCREMENT PRIMARY KEY,
                                title VARCHAR(255) NOT NULL,
                                description TEXT NOT NULL,
                                release_date DATE NOT NULL,
                                duration INT NOT NULL,
                                rating FLOAT CHECK (rating >= 0 AND rating <= 10),
                                image VARCHAR(255) NOT NULL,
                                url VARCHAR(255) NOT NULL,
                                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";

$execute = $conn->prepare($query);
$execute->execute();