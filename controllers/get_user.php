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
require_once('../models/model.php');
require_once('../models/user.php');

// Set database connection in the model
Model::setConnection($conn);

// GET USER BY ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $user = User::find($_GET['id']);
    if ($user) {
        echo json_encode(['status' => 'success', 'data' => $user->toArray()]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
    exit;
}

// GET ALL USERS
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $users = User::all();
    $objects = [];
    
    foreach ($users as $user) {
        $objects[] = $user->toArray();
    }
    $response = [
        'status' => 'success',
        'data' => $objects
    ];
    echo json_encode($response);
    exit;
}