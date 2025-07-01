<?php
// CORS headers
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once('../models/model.php');
require_once('../models/user.php');

Model::setConnection($conn);

$contentType = $_SERVER['CONTENT_TYPE'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && str_starts_with($contentType, 'multipart/form-data')) {
    if (
        isset($_POST['name'], $_POST['email'], $_POST['mobile'], $_POST['password'], $_POST['dob']) &&
        isset($_FILES['government_id_image'])
    ) {
        $target_dir = "../uploads/";
        $uniq_name = uniqid() . "_" . basename($_FILES["government_id_image"]["name"]);
        $target_file = $target_dir . $uniq_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate image file size
        if ($_FILES["government_id_image"]["size"] > 500000) {
            echo json_encode(['status' => 'error', 'message' => 'File too large']);
            exit;
        }

        // Validate file format
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo json_encode(['status' => 'error', 'message' => 'Only JPG, JPEG, PNG & GIF files allowed']);
            exit;
        }

        if (!move_uploaded_file($_FILES["government_id_image"]["tmp_name"], $target_file)) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file']);
            exit;
        }

        $imageUrl = "http://localhost/Cinema_server/uploads/" . $uniq_name;

        $userData = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'mobile' => $_POST['mobile'],
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'dob' => $_POST['dob'],
            'government_id_image' => $imageUrl,
        ];

        if (User::create($userData)) {
            echo json_encode(['status' => 'success', 'message' => 'User created successfully', 'image_url' => $imageUrl]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to create user']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing fields']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request — no action matched']);
