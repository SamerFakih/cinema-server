<?php
require(__DIR__. '/./BaseController.php');
require_once(__DIR__.'/../models/model.php');

class AuthController {

    public function login() {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $column = 'email';
        $value = $_POST['email'];
        $password = $_POST['password'];

        $user = User::findByValue($column, $value);

        if ($user) {
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
    }else {
        echo json_encode(['status' => 'error', 'message' => 'Missing fields']);
        exit;}
    }

    public function register() {
    if (
        isset($_POST['name'])
        && isset($_POST['email'])
        && isset($_POST['mobile'])
        && isset($_POST['password'])
        && isset($_POST['dob'])
        && isset($_FILES['government_id_image'])
    ) {
        $target_dir = "../uploads/user";
        $uniq_name = uniqid() . "_" .$_FILES["government_id_image"]["name"];
        $imageUrl = $target_dir . $uniq_name;

        $userData = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'mobile' => $_POST['mobile'],
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'dob' => $_POST['dob'],
            'government_id_image' => $imageUrl,
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
}

