<?php
$apis = [

    '/login'         => ['controller' => 'AuthController', 'method' => 'login'],
    '/register'         => ['controller' => 'AuthController', 'method' => 'register'],

    '/user'      => ['controller' => 'UserController', 'method' => 'getAllUsers'],

    '/movie'      => ['controller' => 'MovieController', 'method' => 'getAllMovies'],
    '/add_movie'      => ['controller' => 'MovieController', 'method' => 'Add'],

];