<?php
require_once "models/UserModel.php";
require_once "models/ProductModel.php";

class ApiController {

    // User Authentication Service
    public function login() {
        $user = new UserModel();

        if ($user->authenticate($_POST['username'], $_POST['password'])) {
            echo json_encode(["status" => "success", "message" => "Login successful"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
        }
    }

    // Product Management Service
    public function products() {
        $product = new ProductModel();
        echo json_encode($product->getProducts());
    }
}
?>
