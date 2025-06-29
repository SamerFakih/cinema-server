<?php
// Allow CORS for local frontend
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Include required files
require_once('../connection/connection.php');
require('../models/movie.php');
require_once('../models/model.php');

// Set database connection in the model
Model::setConnection($conn);

// GET USER BY ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $user = Movie::find($_GET['id']);
    if ($user) {
        echo json_encode(['status' => 'success', 'data' => $user->toArray()]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
    exit;
}

// GET ALL MOVIES
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $movies = Movie::all();
    $objects = [];
    
    foreach ($movies as $movie) {
        $objects[] = $movie->toArray();
    }
    $response = [
        'status' => 'success',
        'data' => $objects
    ];
    echo json_encode($response);
    exit;
}