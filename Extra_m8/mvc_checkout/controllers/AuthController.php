<?php
class AuthController {

    public function login() {
        if (isset($_POST['login'])) {
            $_SESSION['user'] = $_POST['username'];
            header("Location: index.php?page=cart");
        }
        require 'views/login.php';
    }
}
