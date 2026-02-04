<?php
class UserModel {

    public function authenticate($username, $password) {
        // Sample static user
        if ($username === "admin" && $password === "12345") {
            return true;
        }
        return false;
    }
}
?>
