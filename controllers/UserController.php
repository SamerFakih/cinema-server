<?php
require(__DIR__.'/./BaseController.php');
require(__DIR__.'/../models/user.php');
require(__DIR__.'/../services/ArrayService.php');


class UserController {
    public function getAllUsers() {
    // GET USER BY ID
    if (isset($_GET['id'])) {
        $user = User::find($_GET['id'])->toArray();
        echo ResponseService::success_response($user);
    }

    // GET ALL USERS
    $users = User::all();
    $userArray = ArrayService::userArray($users);
    echo ResponseService::success_response($userArray);
    exit;
    }
}