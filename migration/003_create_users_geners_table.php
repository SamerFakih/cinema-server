<?php
require('../connection/connection.php');

$query = "CREATE TABLE users_geners (user_id INT NOT NULL,
                                    gener_id INT NOT NULL,
                                    FOREIGN KEY (user_id) REFERENCES users(id),
                                    FOREIGN KEY (gener_id) REFERENCES geners(id))";

$execute = $conn->prepare($query);
$execute->execute();