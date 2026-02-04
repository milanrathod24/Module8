<?php
class User {

    public static function getByToken($token) {
        // Normally DB lookup
        if ($token === "validtoken123") {
            return [
                "id" => 1,
                "name" => "Milan",
                "email" => "milan@gmail.com"
            ];
        }
        return null;
    }
}
