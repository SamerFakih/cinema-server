<?php
class ArrayService {
    public static function userArray($users) {
        $objects = [];

        foreach ($users as $user) {
            $objects[] = $user->toArray();
        }

        return $objects;
    }
}