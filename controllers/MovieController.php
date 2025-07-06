<?php
require(__DIR__.'/./baseController.php');
require(__DIR__.'/../services/ArrayService.php');
require(__DIR__.'/../models/movie.php');


class MovieController{

    public function GetAllMovies() {
    if (isset($_GET['id'])) {
        $user = Movie::find($_GET['id'])->toArray();
        echo ResponseService::success_response($user);
    }

    // GET ALL MOVIES
        $movies = Movie::all();
        $arrayMovie = ArrayService::userArray($movies);
        echo ResponseService::success_response($arrayMovie);
    }

    public function Add() {

        if (
            isset($_POST["title"]) &&
            isset($_POST["description"]) &&
            isset($_POST["release_date"]) &&
            isset($_POST["duration"])&&
            isset($_POST["rating"])&&
            isset($_FILES["image"])&&
            isset($_POST["url"])&&
            isset($_POST["auditorium_id"])
        ) {
            $target_dir = "../uploads/movie";
            $uniq_name = uniqid() . "_" . basename($_FILES["image"]["name"]);
            $imageUrl = $target_dir . $uniq_name;

            $userData = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'release_date' => $_POST['release_date'],
                'duration' => $_POST['duration'],
                'rating' => $_POST['rating'],
                'image' => $imageUrl,
                'url' => $_POST['url'],
                'auditorium_id' => $_POST['auditorium_id']
            ];

            // Save to DB
            Model::create($userData);
        }
    }
}