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

require_once('../models/model.php');
require_once('../models/user.php');

Model::setConnection($conn);

// Detect if it's JSON
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';

// loginuser
if($_SERVER['REQUEST_METHOD'] === 'POST' && str_starts_with($contentType, 'multipart/form-data')){
if (isset($_POST['email']) && isset($_POST['password'])) {
    $column = 'email';
    $value = $_POST['email'];
    $password = $_POST['password'];

    // Find user by email
    $user = User::findByValue($column, $value);

    if ($user) {
        // Verify password
        if (password_verify($password, $user->getPassword())) {
            echo json_encode([
                'status' => 'success',
                'data' => $user->toArray()
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid password'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'User not found'
        ]);
    }
    exit;
}
}


