<?php
require_once('../connection/connection.php');


$query = "ALTER TABLE movies ADD COLUMN auditorium_id int NOT NULL";

$execute= $conn->prepare($query);
$execute->execute();