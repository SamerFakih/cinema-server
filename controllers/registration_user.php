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



if ($_SERVER['REQUEST_METHOD'] === 'POST' && str_starts_with($contentType, 'multipart/form-data')) {
    if (
        isset($_POST['name'], $_POST['email'], $_POST['mobile'], $_POST['password'], $_POST['dob']) &&
        isset($_FILES['government_id_image'])
    ) {
        $userData = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'mobile' => $_POST['mobile'],
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'dob' => $_POST['dob'],
            'government_id_image' => file_get_contents($_FILES['government_id_image']['tmp_name']),
        ];

        if (User::create($userData)) {
            echo json_encode(['status' => 'success', 'message' => 'User created successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to create user']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing fields']);
    }
    exit;
}

// Default fallback
echo json_encode(['status' => 'error', 'message' => 'Invalid request — no action matched']);
