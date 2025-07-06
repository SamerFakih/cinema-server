<?php
// CORS headers
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once(__DIR__.'/../models/model.php');
require(__DIR__.'/../connection/connection.php');
require(__DIR__.'/../services/ResponseService.php');

Model::setConnection($conn);